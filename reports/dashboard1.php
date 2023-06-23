<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../includes/functions.php'));
require_once(realpath(__DIR__ . '/../includes/authenticate.php'));
require_once(realpath(__DIR__ . '/../includes/display.php'));
require_once(realpath(__DIR__ . '/../includes/reporting.php'));
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

// Add various security headers
add_security_headers();

// Add the session
add_session_check();

// Include the CSRF Magic library
include_csrf_magic();

// Include the GRCfy language file
// Ignoring detections related to language files
// @phan-suppress-next-line SecurityCheck-PathTraversal
require_once(language_file());

$teamOptions = get_teams_by_login_user();
array_unshift($teamOptions, array(
    'value' => "0",
    'name' => $lang['Unassigned'],
));

$teams = [];
// Get teams submitted by user
if(isset($_GET['teams'])){
    $teams = array_filter(explode(',', $_GET['teams']), 'ctype_digit');
}elseif(is_array($teamOptions)){
    foreach($teamOptions as $teamOption){
        $teams[] = (int)$teamOption['value'];
    }
}

// Get the risk pie array
$pie_array = get_pie_array(null, $teams);

// Get the risk location pie array
$pie_location_array = get_pie_array("location", $teams);

// Get the risk team pie array
$pie_team_array = get_pie_array("team", $teams);

// Get the risk technology pie array
$pie_technology_array = get_pie_array("technology", $teams);

?>

<!doctype html>
<html lang="<?php echo $escaper->escapehtml($_SESSION['lang']); ?>" xml:lang="<?php echo $escaper->escapeHtml($_SESSION['lang']); ?>">

<head>
<?php
        // Use these jQuery scripts
        $scripts = [
                'jquery.min.js',
        ];

        // Include the jquery javascript source
        display_jquery_javascript($scripts);

	display_bootstrap_javascript();
?>
  <script src="../js/bootstrap-multiselect.js?<?php echo current_version("app"); ?>"></script>
  <script src="../js/sorttable.js?<?php echo current_version("app"); ?>"></script>
  <script src="../js/obsolete.js?<?php echo current_version("app"); ?>"></script>

    <?php
        // Use these HighCharts scripts
        $scripts = [
                'highcharts.js',
        ];

        // Display the highcharts javascript source
        display_highcharts_javascript($scripts);
        display_new_css();

    ?>

  <title>GRCfy: Enterprise Risk Management Simplified</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  
  <!-- <link rel="stylesheet" href="../css/bootstrap.css?<?php echo current_version("app"); ?>"> -->
  <!-- <link rel="stylesheet" href="../css/bootstrap-responsive.css?<?php echo current_version("app"); ?>">

  <link rel="stylesheet" href="../vendor/components/font-awesome/css/fontawesome.min.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/theme.css?<?php echo current_version("app"); ?>">
  <link rel="stylesheet" href="../css/side-navigation.css?<?php echo current_version("app"); ?>"> -->

  
  <?php

    setup_favicon("..");
	setup_alert_requirements("..");
  ?>

  <script type="">
    
    
    function submitForm() {
        var brands = $('#teams option:selected');
        var selected = [];
        $(brands).each(function(index, brand){
            selected.push($(this).val());
        });
        
        $("#team_options").val(selected.join(","));
        $("#risks_dashboard_form").submit();
    }
  
    $(function(){
        $("#teams").multiselect({
            allSelectedText: '<?php echo $escaper->escapeHtml($lang['AllTeams']); ?>',
            includeSelectAllOption: true,
            onChange: submitForm,
            onSelectAll: submitForm,
            onDeselectAll: submitForm,
            enableCaseInsensitiveFiltering: true,
        });
        
        $(".btn-group").click(function(){
          $('.multiselect-container').show();
        });

        $(".open").click(function(){
          $('.multiselect-container').hide();
        });
    });
  
  </script>
  
  <?php
    setup_favicon("..");
    setup_alert_requirements("..");
  ?>
</head>

<body class="ltr main-body app sidebar-mini index">


  <?php
    // view_top_menu("Reporting");
    display_license_check();

    // Get any alert messages
    get_alert();
  ?>
  <div class="progress-top-bar"></div>

  <!-- Back-to-top -->
  <a href="#top" id="back-to-top" class="back-to-top rounded-circle shadow"><i class="las la-arrow-up"></i></a>

  <!-- Loader -->
  <!-- <div id="global-loader">
    <img src="../zem_glass_assets/assets/img/loader.svg" class="loader-img" alt="Loader">
  </div> -->
<!-- /Loader -->
  <!-- Page -->
  <div class="page">

      <div class="layout-position-binder">
            <?php new_top_menu(); ?>
            <?php 
                $urls = $_SERVER['REQUEST_URI'];  
                $url = explode("/",$urls);
                display_new_sidebar('RiskDashboard', $url[2]); 
            ?>
        </div>
      </div>
      <div class="main-content app-content">
        <div class="main-container container-fluid">
          <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Risks Dashboard</span>
                </div>
                <div class="justify-content-center mt-2">
                    <ol class="breadcrumb breadcrumb-style3">
                        <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Reports</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Risks Dashboard</li>
                    </ol>
                </div>
          </div>
          <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1"><?php echo $escaper->escapeHtml($lang['OpenRisks']); ?> (<?php echo $escaper->escapeHtml(get_open_risks($teams)); ?>)</span>
                </div>
          </div>
          <div class="row-fluid">
              <div class="span4">
                  <u><?php echo $escaper->escapeHtml($lang['Teams']); ?></u>: &nbsp;
                  <?php create_multiple_dropdown("teams", $teams, NULL, $teamOptions); ?>
                  <form id="risks_dashboard_form" method="GET">
                      <input type="hidden" value="<?php echo $escaper->escapeHtml(implode(',', $teams)); ?>" name="teams" id="team_options">
                  </form>
              </div>
          </div>
          <div class="row">
                <div class="col-xxl-8 col-xl-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card" style="height: 415px;">
                                <div class="card-header">
                                    <div class="card-title">
                                        Risk Level
                                    </div>
                                </div>
                                <div class="card-body">
                                <?php open_risk_level_pie_new(js_string_escape($lang['RiskLevel']), $teams); ?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
          
          <div class="row-fluid">
            <div class="span4">
              <div class="well">
                <?php open_risk_level_pie(js_string_escape($lang['RiskLevel']), $teams); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_status_pie($pie_array, js_string_escape($lang['Status'])); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_location_pie($pie_location_array, js_string_escape($lang['SiteLocation'])); ?>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <div class="well">
                <?php open_risk_source_pie($pie_array, js_string_escape($lang['RiskSource'])); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_category_pie($pie_array, js_string_escape($lang['Category'])); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_team_pie($pie_team_array, js_string_escape($lang['Team'])); ?>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <div class="well">
                <?php open_risk_technology_pie($pie_technology_array, js_string_escape($lang['Technology'])); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_owner_pie($pie_array, js_string_escape($lang['Owner'])); ?>
              </div>
            </div>
            <div class="span4">
              <div class="well">
                <?php open_risk_owners_manager_pie($pie_array, js_string_escape($lang['OwnersManager'])); ?>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <div class="well">
                <?php open_risk_scoring_method_pie($pie_array, js_string_escape($lang['RiskScoringMethod'])); ?>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <h3><?php echo $escaper->escapeHtml($lang['ClosedRisks']); ?>: (<?php echo $escaper->escapeHtml(get_closed_risks($teams)); ?>)</h3>
          </div>
          <div class="row-fluid">
            <div class="span4">
              <div class="well">
                <?php closed_risk_reason_pie(js_string_escape($lang['Reason']), $teams); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    
</body>
<?php display_new_js(); ?>
</html>
