<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../includes/assets.php'));
require_once(realpath(__DIR__ . '/../includes/authenticate.php'));
require_once(realpath(__DIR__ . '/../includes/display.php'));
require_once(realpath(__DIR__ . '/../includes/alerts.php'));
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

// Add various security headers
add_security_headers();

// Add the session
$permissions = array(
        "check_access" => true,
        "check_assets" => true,
);
add_session_check($permissions);

// Include the CSRF Magic library
include_csrf_magic();

// Include the GRCfy language file
// Ignoring detections related to language files
// @phan-suppress-next-line SecurityCheck-PathTraversal
require_once(language_file());

// Check if the user has access to manage assets
if (!isset($_SESSION["asset"]) || $_SESSION["asset"] != 1)
{
  header("Location: ../index.php");
  exit(0);
}
else $manage_assets = true;

// Check if an asset search was submitted
if ((isset($_POST['search'])) && $manage_assets)
{
  $range = $_POST['range'];
  $AvailableIPs = discover_assets($range);

  // If the IP was not in a recognizable format
  if ($AvailableIPs === false)
  {
    // Display an alert
    set_alert(true, "bad", $escaper->escapeHtml($lang['IPFormatNotRecognized']));
  }
}

?>

<!doctype html>
<html>

<head>
<?php
        // Use these jQuery scripts
        $scripts = [
                'jquery.min.js',
        ];

        // Include the jquery javascript source
        display_jquery_javascript($scripts);

	display_bootstrap_javascript();
display_new_css();

?>
  <title>GRCfy: Enterprise Risk Management Simplified</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<!--  <link rel="stylesheet" href="../css/bootstrap.css?--><?php //echo current_version("app"); ?><!--">-->
  <link rel="stylesheet" href="../css/bootstrap-responsive.css?<?php echo current_version("app"); ?>">


  <link rel="stylesheet" href="../css/divshot-util.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/divshot-canvas.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/display.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../vendor/components/font-awesome/css/fontawesome.min.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/theme.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/side-navigation.css?<?php echo current_version("app"); ?>">



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

  <script type="text/javascript">
  var loading={
      ajax:function(st)
      {
        this.show('load');
      },
      show:function(el)
      {
        this.getID(el).style.display='';
      },
      getID:function(el)
      {
        return document.getElementById(el);
      }
    }
  </script>
</head>

<body class="ltr main-body app sidebar-mini index">


  <?php
  view_top_menu("AssetManagement");

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

  <div id="load" style="display:none;">Scanning IPs... Please wait.</div>
  <div class="container-fluid">
    <div class="row-fluid">

      <div class="span9">
        <div class="row-fluid">
          <div class="span12">
            <div class="hero-unit">
              <h4><?php echo $escaper->escapeHtml($lang['AutomatedDiscovery']); ?></h4>
              <p><?php echo $escaper->escapeHtml($lang['AutomatedDiscoveryHelp']); ?></p>
              <ul>
                <li>192.168.0.1</li>
                <!-- 192.168.0.0/24<br />-->
                <li>192.168.0.1-192.168.0.255</li>
              </ul>
            </p>
            <form name="discover_assets" method="post" action="" enctype="multipart/form-data" onsubmit="return loading.ajax()">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100px"><?php echo $escaper->escapeHtml($lang['IPRange']); ?>:</td>
                  <td><input maxlength="100" name="range" id="range" class="input-medium" type="text"></td>
                </tr>
              </table>

              <div class="form-actions">
                <button type="submit" name="search" class="btn btn-primary"><?php echo $escaper->escapeHtml($lang['Search']); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      </div>
  </div>


</body>

</html>
