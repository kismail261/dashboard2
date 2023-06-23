<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include the GRCfy configuration file
require_once(realpath(__DIR__ . '/includes/config.php'));

// If the database hasn't been installed yet
if (defined('SIMPLERISK_INSTALLED') && SIMPLERISK_INSTALLED == "false")
{
    // Include the required installation file
    require_once(realpath(__DIR__ . '/includes/install.php'));

    // Call the GRCfy installation process
    simplerisk_installation();
} // The GRCfy database has been installed
else
{
// Include required functions file
require_once(realpath(__DIR__ . '/includes/functions.php'));
require_once(realpath(__DIR__ . '/includes/authenticate.php'));
require_once(realpath(__DIR__ . '/includes/display.php'));
require_once(realpath(__DIR__ . '/includes/alerts.php'));
require_once(realpath(__DIR__ . '/includes/extras.php'));
require_once(realpath(__DIR__ . '/includes/install.php'));
require_once(realpath(__DIR__ . '/vendor/autoload.php'));

// Add various security headers
add_security_headers();

// Get the number of users in the database
$db = db_open();
$stmt = $db->prepare("SELECT count(value) as count FROM `user`;");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $result['count'];
db_close($db);

if (!isset($_SESSION)) {
    // Session handler is database
    if (USE_DATABASE_FOR_SESSIONS == "true") {
        session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
    }

    // Start session
    session_set_cookie_params(0, '/', '', isset($_SERVER["HTTPS"]), true);

    sess_gc(1440);
    session_name('GRCfy');
    session_start();
}

// Include the language file
// Ignoring detections related to language files
// @phan-suppress-next-line SecurityCheck-PathTraversal
require_once(language_file());

// If the database has been installed but there are no users
if ($count == 0) {
    // Create the default admin account
    create_default_admin_account();

    // Don't display the rest of the page
    exit();
} // Otherwise go about the standard login process
else {
    // Checking for the SAML logout status
    if (custom_authentication_extra() && isset($_REQUEST['LogoutState'])) {
        global $lang;
        // Parse the logout state
        $state = \SimpleSAML\Auth\State::loadState((string)$_REQUEST['LogoutState'], 'MyLogoutState');
        $ls = $state['saml:sp:LogoutStatus']; /* Only works for SAML SP */
        if ($ls['Code'] === 'urn:oasis:names:tc:SAML:2.0:status:Success' && !isset($ls['SubCode'])) {
            /* Successful logout. */
            set_alert(true, "good", $lang['SAMLLogoutSuccessful']);
        } else {
            /* Logout failed. Tell the user to close the browser. */
            set_alert(true, "bad", $lang['SAMLLogoutFailed']);
        }
    }
    // If the login form was posted
    if (isset($_POST['submit'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        // Check for expired lockouts
        check_expired_lockouts();

        // If the user is valid
        if (is_valid_user($user, $pass)) {
            $uid = get_id_by_user($user);
            $array = get_user_by_id($uid);
            $_SESSION['user'] = $array['username'];

            // If the user needs to change their password upon login
            if ($array['change_password']) {
                $_SESSION['first_login_uid'] = $uid;

                if (encryption_extra()) {
                    // Load the extra
                    require_once(realpath(__DIR__ . '/extras/encryption/index.php'));

                    // Get the current password encrypted with the temp key
                    check_user_enc($user, $pass);
                }

                // Put the posted password in the session before redirecting them to the reset page
                $_SESSION['first_login_pass'] = $pass;

                header("location: reset_password.php");
                exit;
            }

            // Create the GRCfy instance ID if it doesn't already exist
            create_simplerisk_instance_id();

            // Set the user permissions
            set_user_permissions($user);

            // Ping the server
            ping_server();

            // Do a license check
            simplerisk_license_check();

            // Get base url
            $_SESSION['base_url'] = get_base_url();

            // Set login status
            login($user, $pass);
        } // If the user is not a valid user
        else {
            // In case the login attempt fails we're checking the cause.
            // If it's because the user 'Does Not Exist' we're doing a dummy
            // validation to make sure we're using the same time on a non-existant
            // user as we'd use on an existing
            if (get_user_type($user, false) === "DNE") {
                fake_simplerisk_user_validity_check();
            }

            $_SESSION["access"] = "denied";

            // If case sensitive usernames are enabled
            if (get_setting("strict_user_validation") != 0) {
                // Display an alert
                set_alert(true, "bad", $escaper->escapeHtml($lang["InvalidUsernameOrPasswordCaseSensitive"]));
            } else set_alert(true, "bad", $escaper->escapeHtml($lang["InvalidUsernameOrPassword"]));

            // If the password attempt lockout is enabled
            if (get_setting("pass_policy_attempt_lockout") != 0) {
                // Add the login attempt and block if necessary
                add_login_attempt_and_block($user);
            }
        }
    }

    if (isset($_SESSION["access"]) && ($_SESSION["access"] == "1")) {
        // Select where to redirect the user next
        select_redirect();
    }

    // If the user has already authorized and we are authorizing with multi factor
    if (isset($_SESSION["access"]) && ($_SESSION["access"] == "mfa")) {
        // If a response has been posted
        if (isset($_POST['authenticate'])) {
            // If the mfa token matches
            if (does_mfa_token_match()) {
                // If the encryption extra is enabled
                if (encryption_extra()) {
                    // Load the extra
                    require_once(realpath(__DIR__ . '/extras/encryption/index.php'));

                    // Check user enc
                    check_user_enc($user, $pass);
                }

                // Grant the user access
                grant_access();

                // Select where to redirect the user next
                select_redirect();
            }
        }
    }

    // If the user has already been authorized and we need to verify their mfa
    if (isset($_SESSION["access"]) && $_SESSION["access"] == "mfa_verify") {
        // If a response has ben posted
        if (isset($_POST['verify'])) {
            // If the MFA verification process worked
            if (process_mfa_verify()) {
                // Convert the user to use the core MFA going forward
                enable_mfa_for_uid();

                // If the encryption extra is enabled
                if (encryption_extra()) {
                    // Load the extra
                    require_once(realpath(__DIR__ . '/extras/encryption/index.php'));

                    // Check user enc
                    check_user_enc($user, $pass);
                }

                // Grant the user access
                grant_access();

                // Select where to redirect the user next
                select_redirect();
            }
        }
    }

    // If the user has already authorized and we are authorizing with duo
    if (isset($_SESSION["access"]) && ($_SESSION["access"] == "duo")) {
        // If a response has been posted
        if (isset($_POST['sig_response'])) {
            // Get the username and password and then unset the session values
            $user = $_SESSION['user'];
            $pass = $_SESSION['pass'];
            unset($_SESSION['user']);
            unset($_SESSION['pass']);

            // Include the custom authentication extra
            require_once(realpath(__DIR__ . '/extras/authentication/index.php'));

            // Get the authentication settings
            $configs = get_authentication_settings();

            // For each configuration
            foreach ($configs as $config) {
                // Set the name value pair as a variable
                ${$config['name']} = $config['value'];
            }

            // Get the response back from Duo
            $resp = Duo\Web::verifyResponse($IKEY, $SKEY, get_duo_akey(), $_POST['sig_response']);

            // If the response is not null
            if ($resp != NULL) {
                // Create the MFA secret for the uid
                create_mfa_secret_for_uid();

                // Set the session to indicate that the Duo auth was successful, but we need to verify the new MFA
                $_SESSION["access"] = "mfa_verify";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme-color="default">
<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title -->
    <title> Enterprises Risk Management Simplified...</title>

    <!-- Favicon -->
    <link rel="icon" href="./zem_glass_assets/assets/img/brand/favicon.ico" type="image/x-icon"/>

    <!-- Icons css -->
    <link href="./zem_glass_assets/assets/css/icons.css" rel="stylesheet">

    <!--  Bootstrap css-->
    <link id="style" href="./zem_glass_assets/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Style css -->
    <link href="./zem_glass_assets/assets/css/style.css" rel="stylesheet">

    <?php
    setup_favicon();
    setup_alert_requirements();
    ?>

</head>
<body class="ltr error-page1 bg-primary">

<!-- Progress bar on scroll -->
<div class="progress-top-bar"></div>

<!-- Loader -->
<div id="global-loader">
    <img src="./zem_glass_assets/assets/img/loader.svg" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<div class="square-box">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>

<div class="bg-svg">
    <div class="page">
        <div class="z-index-10">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 mx-auto my-auto py-4 justify-content-center">
                        <div class="card-sigin">
                            <!-- Demo content-->
                            <div class="main-card-signin d-md-flex">
                                <div class="wd-100p">
                                    <div class="d-flex">
                                        <a href="index.html">
                                            <img src="./zem_glass_assets/assets/img/brand/favicon-white.png"
                                                 class="sign-favicon ht-40 logo-dark" alt="logo">
                                            <img src="./zem_glass_assets/assets/img/brand/favicon-white-1.png"
                                                 class="sign-favicon ht-40 logo-light-theme" alt="logo">
                                        </a>
                                    </div>
                                    <div class="mt-3">
                                        <h2 class="tx-medium tx-primary">
                                            Enterprise Risk Management Simplified...
                                        </h2>
                                        <h6 class="font-weight-semibold mb-4 text-white-50">
                                            Please sign in to continue.
                                        </h6>
                                        <div class="panel tabs-style7 scaleX mt-2">
                                            <div class="panel-body p-0">
                                                <div class="tab-content mt-3">
                                                    <div class="tab-pane active" id="signinTab1">
                                                        <?php
                                                        // If the user has authenticated and now we need to authenticate with mfa
                                                        if (isset($_SESSION["access"]) && $_SESSION["access"] == "mfa") {
                                                            echo "<div class=\"row-fluid\">\n";
                                                            echo "<div class=\"span9\">\n";
                                                            echo "<form name='mfa' method='post' action=''>\n";

                                                            // Perform a duo authentication request for the user
                                                            display_mfa_authentication_page();

                                                            echo "</form>\n";
                                                            echo "</div>\n";
                                                            echo "</div>\n";
                                                        } // If the user needs to verify the new MFA
                                                        else if (isset($_SESSION["access"]) && $_SESSION["access"] == "mfa_verify") {
                                                            echo "<div class=\"row-fluid\">\n";
                                                            echo "<div class=\"span9\">\n";
                                                            echo "<form name='mfa' method='post' action=''>\n";

                                                            // Display the MFA verification page
                                                            display_mfa_verification_page();

                                                            echo "</form>\n";
                                                            echo "</div>\n";
                                                            echo "</div>\n";
                                                        } // If the user has authenticated and now we need to authenticate with duo
                                                        else if (isset($_SESSION["access"]) && $_SESSION["access"] == "duo") {
                                                            echo "<div class=\"row-fluid\">\n";
                                                            echo "<div class=\"span9\">\n";
                                                            // echo "<div class=\"well\">\n";

                                                            // Include the custom authentication extra
                                                            require_once(realpath(__DIR__ . '/extras/authentication/index.php'));

                                                            // Store the user and password temporarily in the session
                                                            $_SESSION['user'] = $_POST['user'];
                                                            $_SESSION['pass'] = $_POST['pass'];

                                                            // Perform a duo authentication request for the user
                                                            duo_authentication($_SESSION["user"]);

                                                            // echo "</div>\n";
                                                            echo "</div>\n";
                                                            echo "</div>\n";
                                                        } // If the user has not authenticated
                                                        else if (!isset($_SESSION["access"]) || $_SESSION["access"] != "1") {

                                                            // Get any alert messages

                                                            echo '<form  name="authenticate" method="post" action="" class="loginForm">
                                                            <div class="form-group">
                                                                <input name="user" id="user" class="form-control" placeholder="Enter Username" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <input name="pass" id="pass" class="form-control" placeholder="Enter Password" type="password">
                                                            </div>
                                                           '; echo get_alert();
                                                           echo '
                                                            
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <p class="mb-0">
                                                                    <a href="/reset.php" class="tx-primary">
                                                                        ' . $escaper->escapeHtml($lang['ForgotYourPassword']) . '
                                                                    </a>
                                                                </p>
                                                                ';
                                                            if (custom_authentication_extra()) {
                                                                // If SSO Login is enabled or not set yet
                                                                if (get_setting("GO_TO_SSO_LOGIN") === false || get_setting("GO_TO_SSO_LOGIN") === '1') {
                                                                    echo '          <p class="mb-0">
                                                                    <a href="/extras/authentication/login.php" class="tx-primary">
                                                                        ' . $escaper->escapeHtml($lang['GoToSSOLoginPage']) . '
                                                                    </a>
                                                                </p>';
                                                                }
                                                            }
                                                            echo '
                                                                
                                                                <button onclick="submitForm()" id="submit" type="submit" name="submit" class="btn btn-primary">' . $escaper->escapeHtml($lang['Login']) . '</button>
                                                            </div>
                                                        </form>';

                                                        }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JQuery min js -->
<script src="./zem_glass_assets/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap js -->
<script src="./zem_glass_assets/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- generate-otp js -->
<script src="./zem_glass_assets/assets/js/generate-otp.js"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="./zem_glass_assets/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!-- custom js -->
<script src="./zem_glass_assets/assets/js/custom.js"></script>

<script>
    $(window).load(function() {
        $('#global-loader').hide();
    });

    function submitForm() {
        console.log('hello')
        $('#global-loader').show();
    }
</script>
</body>
</html>
