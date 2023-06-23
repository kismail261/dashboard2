<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

require_once(realpath(__DIR__ . '/../vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../includes/functions.php'));

/**************************************
 * FUNCTION: ENABLE MFA FOR ALL USERS *
 **************************************/
function enable_mfa_for_all_users()
{
    // Open the database connection
    $db = db_open();

    // Get the list of all users
    $stmt = $db->prepare("SELECT * FROM `user`;");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // For each user
    foreach ($users as $user)
    {
        // Get the user ID
        $uid = $user['value'];

        // Create an entry in the user_mfa table for the user
        verify_mfa_for_uid($uid);
        user_mfa_verified($uid);
    }

    // Set all users to MFA enabled
    $stmt = $db->prepare("UPDATE `user` set `multi_factor` = 1;");
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/**********************************************
 * FUNCTION: DISABLE MFA FOR UNVERIFIED USERS *
 **********************************************/
function disable_mfa_for_unverified_users()
{
    // Open the database connection
    $db = db_open();

    // Set multi_factor to disabled for all unverified users
    $stmt = $db->prepare("UPDATE `user` u LEFT JOIN `user_mfa` um ON u.value = um.uid SET u.`multi_factor` = 0 WHERE um.verified = 0;");
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/**************************************
 * FUNCTION: GET MULTI FACTOR FOR UID *
 **************************************/
function get_multi_factor_for_uid($uid = null)
{
    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Open the database connection
    $db = db_open();

    // Get the user_mfa table for this uid
    $stmt = $db->prepare("SELECT `multi_factor` FROM `user` WHERE value = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $multi_factor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // Return the multi factor value
    return $multi_factor['multi_factor'];
}

/*******************************
 * FUNCTION: GET MFA BY USERID *
 *******************************/
function get_mfa_by_userid($uid)
{
    // Open the database connection
    $db = db_open();

    // Get the user_mfa table for this uid
    $stmt = $db->prepare("SELECT * FROM `user_mfa` WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();

    // Get the value for this uid
    $user_mfa = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // Return the user_mfa
    return $user_mfa;
}

/*************************************
 * FUNCTION: IS MFA VERIFIED FOR UID *
 *************************************/
function is_mfa_verified_for_uid($uid = null)
{
    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Open the database connection
    $db = db_open();

    // Get the user_mfa table for this uid
    $stmt = $db->prepare("SELECT *  FROM `user_mfa` WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // If we already have an entry in the user_mfa table
    if (!empty($results))
    {
        // Get the verified value
        $verified = $results['verified'];
    }
    // If we do not already have an entry in the user_mfa table
    else
    {
        // Set it to not verified
        $verified = false;
    }

    // Return the verified value
    return $verified;
}

/*************************************
 * FUNCTION: USER MFA EXISTS FOR UID *
 *************************************/
function user_mfa_exists_for_uid($uid)
{
    // Open the database connection
    $db = db_open();

    // Get the user_mfa table for this uid
    $stmt = $db->prepare("SELECT *  FROM `user_mfa` WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // If we already have an entry in the user_mfa table
    if (!empty($results))
    {
        // Return that the entry exists
        return true;
    }
    // If we do not already have an entry in the user_mfa table
    else
    {
        // Return that the entry does not exist
        return false;
    }
}

function user_mfa_verified($uid)
{
    // Open the database connection
    $db = db_open();

    // Get the user_mfa table for this uid
    $stmt = $db->prepare("SELECT *  FROM `user_mfa` WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // If we already have an entry in the user_mfa table
    if (!empty($results))
    {
        // Get the verified value
        $verified = $results['verified'];
    }
    // If we do not already have an entry in the user_mfa table
    else
    {
        // Create the MFA for this uid
        get_mfa_secret_for_uid($uid);

        // Set it to not verified
        $verified = false;
    }

    // Return the verified value
    return $verified;
}

/********************************
 * FUNCTION: ENABLE MFA FOR UID *
 ********************************/
function enable_mfa_for_uid($uid = null)
{
    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Open the database connection
    $db = db_open();

    // Set the user to MFA enabled
    $stmt = $db->prepare("UPDATE `user` SET `multi_factor` = 1 WHERE value = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/*********************************
 * FUNCTION: DISABLE MFA FOR UID *
 *********************************/
function disable_mfa_for_uid($uid = null)
{
    global $lang;

    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // If we do not require MFA for all users
    if (!get_setting("mfa_required"))
    {
        // Open the database connection
        $db = db_open();

        // Set the multi_factor value for this user to 0
        $stmt = $db->prepare("UPDATE `user` SET `multi_factor` = 0 WHERE `value` = :uid;");
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->execute();

        // Remove any entries in the user_mfa table for this user
        $stmt = $db->prepare("DELETE FROM `user_mfa` WHERE `uid` = :uid;");
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->execute();

        // Close the database connection
        db_close($db);

        // Display an alert
        set_alert(true, "good", $lang['MFADisabledSuccessfully']);
    }
    // If MFA is required for all users
    else
    {
        // Display an alert
        set_alert(true, "bad", $lang['MFARequiredForAllusers']);
    }
}

/********************************
 * FUNCTION: MFA ENABLED FOR UID *
 ********************************/
function mfa_enabled_for_uid($uid)
{
    // Open the database connection
    $db = db_open();

    // Set the user to MFA enabled
    $stmt = $db->prepare("SELECT `multi_factor` FROM `user` WHERE value = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $multi_factor = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // If MFA is enabled for the user
    if ($multi_factor['multi_factor'] === 1)
    {
        return true;
    }
    else return false;
}

/*******************************
 * FUNCTION: MFA DELETE USERID *
 *******************************/
function mfa_delete_userid($uid)
{
    // Open the database connection
    $db = db_open();

    // Delete the user_mfa entry for this user ID
    $stmt = $db->prepare("DELETE FROM `user_mfa` WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/********************************
 * FUNCTION: VERIFY MFA FOR UID *
 ********************************/
function verify_mfa_for_uid($uid)
{
    // Open the database connection
    $db = db_open();

    // Set this uid to verified
    $stmt = $db->prepare("UPDATE `user_mfa` SET `verified` = 1 WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/**********************************
 * FUNCTION: UNVERIFY MFA FOR UID *
 **********************************/
function unverify_mfa_for_uid($uid)
{
    // Open the database connection
    $db = db_open();

    // Set this uid to verified
    $stmt = $db->prepare("UPDATE `user_mfa` SET `verified` = 0 WHERE uid = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();

    // Close the database connection
    db_close($db);
}

/************************************
 * FUNCTION: GET MFA SECRET FOR UID *
 ************************************/
function get_mfa_secret_for_uid($uid)
{
    // Open the database connection
    $db = db_open();

    // Check if we already have an entry in the user_mfa table for this user
    $stmt = $db->prepare("SELECT * FROM `user_mfa` WHERE `uid` = :uid;");
    $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    db_close($db);

    // If we already have an entry in the user_mfa table
    if (!empty($results))
    {
        // Get the secret key
        $secret = $results['secret'];
    }
    // Otherwise, create a new entry in the user_mfa table
    else
    {
        // Create the new MFA secret key
        $secret = create_mfa_secret_for_uid($uid);
    }

    // Return the secret
    return $secret;
}

/***************************************
 * FUNCTION: CREATE MFA SECRET FOR UID *
 ***************************************/
function create_mfa_secret_for_uid($uid = null)
{
    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // If we don't already have a user_mfa entry for this user
    if (!user_mfa_exists_for_uid($uid))
    {
        // Open the database connection
        $db = db_open();

        // Create a new Google2FA
        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        // Create the new MFA secret key
        $secret = $google2fa->generateSecretKey();

        // Store it in the database
        $stmt = $db->prepare("INSERT INTO `user_mfa` (`uid`, `verified`, `secret`) VALUES (:uid, 0, :secret);");
        $stmt->bindParam(":uid", $uid, PDO::PARAM_INT);
        $stmt->bindParam(":secret", $secret, PDO::PARAM_STR);
        $stmt->execute();

        // Close the database connection
        db_close($db);

        // Return the MFA secret
        return $secret;
    }
}

/*********************************
 * FUNCTION: GET MFA QR CODE URL *
 *********************************/
function get_mfa_qr_code_url($uid)
{
    // Get the username for this uid
    $user = get_user_by_id($uid);
    $username = $user['username'];

    // Get the MFA secret for the authenticated user
    $secret = get_mfa_secret_for_uid($uid);

    // Create a TOTP URI
    $parameters = [
        "secret" => $secret,
        "issuer" => "GRCfy",
        "image" => "https://www.simplerisk.com/sites/default/files/logos/logo.png",
    ];

    // Build an HTTP string from the parameters
    $totp_parameters = http_build_query($parameters, '', '&');

    // Construct the TOTP URI
    $totp_uri = "otpauth://totp/GRCfy:" . $username . "?" . $totp_parameters;

    // Use the Google Chart API to generate the QR code
    $image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.urlencode($totp_uri);

    // Return the image URL
    return $image_url;
}

/********************************
 * FUNCTION: PROCESS MFA VERIFY *
 ********************************/
function process_mfa_verify($uid = null)
{
    global $lang;

    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Get the POSTed secret
    $verify_secret = isset($_POST['mfa_secret']) ? $_POST['mfa_secret'] : null;

    // Get the secret for the currently logged in user
    $secret = get_mfa_secret_for_uid($uid);

    // Create a new Google2FA
    $google2fa = new \PragmaRX\Google2FA\Google2FA();

    // If the secrets match
    if ($google2fa->verifyKey($secret, $verify_secret))
    {
        // Set the user to MFA enabled
        enable_mfa_for_uid($uid);

        // Set the user to MFA verified
        verify_mfa_for_uid($uid);

        // Display an alert
        set_alert(true, "good", $lang['MFAEnabledSuccessfully']);

        // Return true
        return true;
    }
    else return false;
}

/*********************************
 * FUNCTION: PROCESS MFA DISABLE *
 *********************************/
function process_mfa_disable($uid = null)
{
    global $lang;

    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Get the POSTed MFA token
    $mfa_token = isset($_POST['mfa_token']) ? $_POST['mfa_token'] : null;

    // Get the user_mfa for the currently logged in user
    $secret = get_mfa_secret_for_uid($uid);

    // Create a new Google2FA
    $google2fa = new \PragmaRX\Google2FA\Google2FA();

    // If the secrets match
    if ($google2fa->verifyKey($secret, $mfa_token))
    {
        // Disable MFA for the user
        disable_mfa_for_uid($uid);

        // Display an alert
        set_alert(true, "good", $lang['MFADisabledSuccessfully']);

        // Return true
        return true;
    }
    // If the secrets don't match
    else
    {
        // Display an alert
        set_alert(true, "bad", $lang['MFAVerificationFailed']);

        // Return false
        return false;
    }
}

/****************************************
 * FUNCTION: CONFIRM MATCHING MFA TOKEN *
 ****************************************/
function does_mfa_token_match($mfa_token = null, $uid = null)
{
    // If the MFA token was not provided
    if($mfa_token === null)
    {
        // Set the MFA token to the POSTed value
        $mfa_token = isset($_POST['mfa_token']) ? $_POST['mfa_token'] : null;
    }

    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    // Get the user_mfa for the uid
    $secret = get_mfa_secret_for_uid($uid);

    // Create a new Google2FA
    $google2fa = new \PragmaRX\Google2FA\Google2FA();

    // If the secrets match
    if ($google2fa->verifyKey($secret, $mfa_token))
    {
        // Return true
        return true;
    }
    else return false;
}

/*******************************************
 * FUNCTION: DISPLAY MFA VERIFICATION PAGE *
 *******************************************/
function display_mfa_verification_page($uid = null)
{
    global $escaper, $lang;

    // If the uid is null
    if ($uid === null )
    {
        // Set it to the session uid
        $uid = $_SESSION['uid'];
    }

    echo "<div class='hero-unit'>\n";
    echo "<table name='verify' border='0'>\n";

    // Get the multi_factor value for this uid
    $multi_factor = get_multi_factor_for_uid($uid);

    echo "<tr>\n";
    echo "<td><h3>" . $escaper->escapeHtml($lang['ProtectYourGRCfyAccount']) . "</h3></td>\n";
    echo "</tr>\n";

    // If the user has Duo or Toopher for MFA
    if ($multi_factor == 2 || $multi_factor == 3)
    {
        // Display a message about them being removed
        echo "<tr>\n";
        echo "<td><h4>" . $escaper->escapeHtml($lang['DuoToopherRemoved']) . "</h4></td>\n";
        echo "</tr>\n";
    }

    echo "<tr>\n";
    echo "<td><h4>" . $escaper->escapeHtml($lang['2FADescription']) . "</h4></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</div>\n";

    echo "<div class='hero-unit'>\n";
    echo "<table name='verify' border='0' cellspacing='5'>\n";
    echo "<tr>\n";
    echo "<td><h4>" . $escaper->escapeHtml($lang['2FAStep1']) . "</h4></td>\n";
    echo "<td><h4>" . $escaper->escapeHtml($lang['2FAStep2']) . "</h4></td>\n";
    echo "</tr>\n";

    echo "<tr>\n";
    echo "<td><img src=\"" . get_mfa_qr_code_url($uid) . "\" /></td>\n";
    echo "<td valign='top'><input name='mfa_secret' type='number' minlength='6' maxlength='6' autofocus='autofocus' />&nbsp;&nbsp;<input type='submit' name='verify' value='" . $escaper->escapeHtml($lang['Verify']) . "' /></td>\n";
    echo "</tr>\n";

    echo "</table>\n";
    echo "</div>\n";
}

/************************************
 * FUNCTION: DISPLAY MFA RESET PAGE *
 ************************************/
function display_mfa_reset_page()
{
    global $lang, $escaper;

    echo "<div class='hero-unit'>\n";
    echo "<table name='protected' border='0'>\n";
    echo "<tr>\n";
    echo "<td><h3>" . $escaper->escapeHtml($lang['YourGRCfyAccountIsProtected']) . "</h3></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</div>\n";

    // If we do not require MFA for all users
    if (!get_setting("mfa_required")) {
        // Allow MFA to be disabled
        echo "<div class='hero-unit'>\n";
        echo "<table name='disable' border='0'>\n";
        echo "<tr>\n";
        echo "<td><h4>" . $escaper->escapeHtml($lang['ToDisableMFA']) . "</h4></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td><h4>" . $escaper->escapeHtml($lang['MFAToken']) . ":&nbsp;&nbsp;<input name='mfa_token' type='number' minlength='6' maxlength='6' /></h4></td>\n";
        echo "</tr>\n";
        echo "<tr>\n";
        echo "<td><input type='submit' name='disable' value='" . $escaper->escapeHtml($lang['Disable']) . "' /></h4></td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";
    }
    // Otherwise display a message that disabling MFA is not availabl
    else
    {
        echo "<div class='hero-unit'>\n";
        echo "<table name='disable' border='0'>\n";
        echo "<tr>\n";
        echo "<td><h4>" . $escaper->escapeHtml($lang['MFARequiredForAllusers']) . "</h4></td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";
    }
}

/*********************************************
 * FUNCTION: DISPLAY MFA AUTHENTICATION PAGE *
 *********************************************/
function display_mfa_authentication_page()
{
    global $lang, $escaper;

    echo "<div class='hero-unit'>\n";
    echo "<table name='protected' border='0'>\n";
    echo "<tr>\n";
    echo "<td><h3>" . $escaper->escapeHtml($lang['YourGRCfyAccountIsProtected']) . "</h3></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</div>\n";

    echo "<div class='hero-unit'>\n";
    echo "<table name='disable' border='0'>\n";
    echo "<tr>\n";
    echo "<td><h4>" . $escaper->escapeHtml($lang['VerifyItsYou']) . "</h4></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td><h4>" . $escaper->escapeHtml($lang['MFAToken']) . ":&nbsp;&nbsp;<input name='mfa_token' type='number' minlength='6' maxlength='6' autofocus='autofocus' /></h4></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td><input type='submit' name='authenticate' value='" . $escaper->escapeHtml($lang['Verify']) . "' /></h4></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

?>