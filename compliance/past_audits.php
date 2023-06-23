<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../includes/functions.php'));
require_once(realpath(__DIR__ . '/../includes/authenticate.php'));
require_once(realpath(__DIR__ . '/../includes/display.php'));
require_once(realpath(__DIR__ . '/../includes/assets.php'));
require_once(realpath(__DIR__ . '/../includes/alerts.php'));
require_once(realpath(__DIR__ . '/../includes/permissions.php'));
require_once(realpath(__DIR__ . '/../includes/governance.php'));
require_once(realpath(__DIR__ . '/../includes/compliance.php'));
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

// Add various security headers
add_security_headers();

// Add the session
$permissions = array(
        "check_access" => true,
        "check_compliance" => true,
);
add_session_check($permissions);

// Include the CSRF Magic library
include_csrf_magic();

// Include the GRCfy language file
// Ignoring detections related to language files
// @phan-suppress-next-line SecurityCheck-PathTraversal
require_once(language_file());

?>
<!doctype html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=10,9,7,8">
<?php
        // Use these jQuery scripts
        $scripts = [
                'jquery.min.js',
        ];

        // Include the jquery javascript source
        display_jquery_javascript($scripts);

        // Use these jquery-ui scripts
        $scripts = [
                'jquery-ui.min.js',
        ];

        // Include the jquery-ui javascript source
        display_jquery_ui_javascript($scripts);

	display_bootstrap_javascript();
display_new_css();

?>
    <script src="../js/jquery.dataTables.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/bootstrap-multiselect.js?<?php echo current_version("app"); ?>"></script>

    <title>GRCfy: Enterprise Risk Management Simplified</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

<!--    <link rel="stylesheet" href="../css/bootstrap.css?--><?php //echo current_version("app"); ?><!--">-->
    <link rel="stylesheet" href="../css/bootstrap-responsive.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/jquery.dataTables.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/bootstrap-multiselect.css?<?php echo current_version("app"); ?>">
    
    <link rel="stylesheet" href="../vendor/components/font-awesome/css/fontawesome.min.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/theme.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/side-navigation.css?<?php echo current_version("app"); ?>">

    <script src="../js/jquery.dataTables.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/grcfy/cve_lookup.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/sorttable.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/grcfy/common.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/grcfy/pages/risk.js?<?php echo current_version("app"); ?>"></script>
    <script src="../vendor/moment/moment/min/moment.min.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/bootstrap-multiselect.js?<?php echo current_version("app"); ?>"></script>
    <script src="../js/jquery.blockUI.min.js?<?php echo current_version("app"); ?>"></script>

    <title>GRCfy: Enterprise Risk Management Simplified</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <!--    <link rel="stylesheet" href="../css/bootstrap.css?--><?php //echo current_version("app"); ?><!--">-->
    <link rel="stylesheet" href="../css/bootstrap-responsive.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/jquery.dataTables.css?<?php echo current_version("app"); ?>">

    <link rel="stylesheet" href="../css/divshot-util.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/divshot-canvas.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/style.css?<?php echo current_version("app"); ?>">

    <link rel="stylesheet" href="../vendor/components/font-awesome/css/fontawesome.min.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/theme.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/side-navigation.css?<?php echo current_version("app"); ?>">
    <link rel="stylesheet" href="../css/bootstrap-multiselect.css?<?php echo current_version("app"); ?>">

    <link rel="stylesheet" href="../css/selectize.bootstrap3.css?<?php echo current_version("app"); ?>">
    <script src="../vendor/simplerisk/selectize.js/dist/js/standalone/selectize.min.js?<?php echo current_version("app"); ?>"></script>


    <!--    scripts added-->

    <!--    <script src="../zem_glass_assets/assets/plugins/jquery/jquery.min.js"></script>';-->
    <!--    -->
    <script src="../backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../backend/plugins/perfect-scrollbar/p-scroll.js"></script>
    <script src="../backend/plugins/side-menu/sidemenu.js"></script>
    <script src="../backend/js/sticky.js"></script>
    <script src="../backend/plugins/sidebar/sidebar.js"></script>
    <script src="../backend/plugins/sidebar/sidebar-custom.js"></script>
    <script src="../backend/js/custom-switcher.js"></script>
    <script src="../backend/js/custom.js"></script>
    <!---->
    <script src="../backend/plugins/ionicons/ionicons.js"></script>
    <script src="../backend/plugins/moment/moment.js"></script>
    <script src="../backend/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../backend/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="../backend/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../backend/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="../backend/plugins/datatable/js/jszip.min.js"></script>
    <script src="../backend/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="../backend/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="../backend/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="../backend/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="../backend/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="../backend/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="../backend/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <!--      	<script src="../backend/js/table-data.js"></script>-->
    <script src="../backend/plugins/select2/js/select2.full.min.js"></script>
    <script src="../backend/js/eva-icons.min.js"></script>







    <?php
        setup_favicon("..");
        setup_alert_requirements("..");
    ?>    
    
</head>

<body class="ltr main-body app sidebar-mini index">

    <?php
        view_top_menu("Compliance");

        // Get any alert messages
        get_alert();
    ?>
    <div class="progress-top-bar"></div>
    <div class="page">

        <div class="layout-position-binder">
            <?php new_top_menu(); ?>
            <?php
            $urls = $_SERVER['REQUEST_URI'];
            $url = explode("/",$urls);
            display_new_sidebar('Overview', $url[2]);
            ?>
        </div>
    </div>
    <div class="main-content app-content">
        <div class="main-container container-fluid">
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="span9 compliance-content-container content-margin-height">                
                <div class="row-fluid">
                    <div class="span12">
                        <?php display_past_audits(); ?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
        </div></div>
    <?php display_set_default_date_format_script(); ?>

</body>
</html>
