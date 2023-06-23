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


    <?php

    // If the Incident Management Extra is enabled
    if (incident_management_extra())
    {
        // Include the incident management javascript file
        echo "        <script src=\"../extras/incident_management/js/incident_management.js?" . current_version("app") . "\"></script>\n";

        // Include the incident management css file
        echo "        <link rel=\"stylesheet\" href=\"../extras/incident_management/css/incident_management.css?" . current_version("app") . "\">\n";
    }

    setup_favicon("..");
    setup_alert_requirements("..");
    ?>
</head>

<body class="ltr main-body app sidebar-mini index">
<?php

display_license_check();
// Get any alert messages
get_alert();

?>
<div class="progress-top-bar"></div>

<!-- Back-to-top -->
<a href="#top" id="back-to-top" class="back-to-top rounded-circle shadow"><i class="las la-arrow-up"></i></a>

<!-- Loader -->
<div id="global-loader">
    <img src="../zem_glass_assets/assets/img/loader.svg" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
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
<!-- main-content -->
<div class="main-content app-content">

    <!-- container -->
    <div class="main-container container-fluid">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">Overview</span>
            </div>
            <div class="justify-content-center mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0)">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row">
            <div class="col-xxl-8 col-xl-12">
                <div class="row">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card" style="height: 415px;">
                            <div class="card-header">
                                <div class="card-title">
                                    Open Vs Closed
                                </div>
                            </div>
                            <div class="card-body">
                                <?php open_close_donut('Open Closed'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card" style="height: 415px;">
                            <div class="card-header">
                                <div class="card-title">
                                    Mitigation Planned Vs Unplanned
                                </div>
                            </div>
                            <div class="card-body">
                                <?php new_mitigation_donut('Open Closed'); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="card" style="height: 415px;">
                            <div class="card-header">
                                <div class="card-title">
                                    Reviewed Vs Unreviewed
                                </div>
                            </div>
                            <div class="card-body">
                                <?php new_review_donut('new'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php risks_by_month_table(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Container -->

    </div>
    <!-- /main-content -->

    <!-- Sidebar-right-->
    <div class="sidebar sidebar-right sidebar-animate">
        <div class="tab-menu-heading p-3">
            <h6 class="mb-0 tx-uppercase tx-semibold">Side Menu</h6>
            <a href="javascript:void(0)" class="btn btn-def def-white sidebar-remove ms-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="panel tabs-style2">
            <div class="panel-head">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#side1"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon right-menu__icon" viewBox="0 0 512 512"><path d="M427.68 351.43C402 320 383.87 304 383.87 217.35 383.87 138 343.35 109.73 310 96c-4.43-1.82-8.6-6-9.95-10.55C294.2 65.54 277.8 48 256 48s-38.21 17.55-44 37.47c-1.35 4.6-5.52 8.71-9.95 10.53-33.39 13.75-73.87 41.92-73.87 121.35C128.13 304 110 320 84.32 351.43 73.68 364.45 83 384 101.61 384h308.88c18.51 0 27.77-19.61 17.19-32.57zM320 384v16a64 64 0 01-128 0v-16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg> Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#side2"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon right-menu__icon" viewBox="0 0 512 512"><rect x="48" y="96" width="416" height="320" rx="40" ry="40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M112 160l144 112 144-112"/></svg> Chat</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#side3"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon right-menu__icon" viewBox="0 0 512 512"><path d="M262.29 192.31a64 64 0 1057.4 57.4 64.13 64.13 0 00-57.4-57.4zM416.39 256a154.34 154.34 0 01-1.53 20.79l45.21 35.46a10.81 10.81 0 012.45 13.75l-42.77 74a10.81 10.81 0 01-13.14 4.59l-44.9-18.08a16.11 16.11 0 00-15.17 1.75A164.48 164.48 0 01325 400.8a15.94 15.94 0 00-8.82 12.14l-6.73 47.89a11.08 11.08 0 01-10.68 9.17h-85.54a11.11 11.11 0 01-10.69-8.87l-6.72-47.82a16.07 16.07 0 00-9-12.22 155.3 155.3 0 01-21.46-12.57 16 16 0 00-15.11-1.71l-44.89 18.07a10.81 10.81 0 01-13.14-4.58l-42.77-74a10.8 10.8 0 012.45-13.75l38.21-30a16.05 16.05 0 006-14.08c-.36-4.17-.58-8.33-.58-12.5s.21-8.27.58-12.35a16 16 0 00-6.07-13.94l-38.19-30A10.81 10.81 0 0149.48 186l42.77-74a10.81 10.81 0 0113.14-4.59l44.9 18.08a16.11 16.11 0 0015.17-1.75A164.48 164.48 0 01187 111.2a15.94 15.94 0 008.82-12.14l6.73-47.89A11.08 11.08 0 01213.23 42h85.54a11.11 11.11 0 0110.69 8.87l6.72 47.82a16.07 16.07 0 009 12.22 155.3 155.3 0 0121.46 12.57 16 16 0 0015.11 1.71l44.89-18.07a10.81 10.81 0 0113.14 4.58l42.77 74a10.8 10.8 0 01-2.45 13.75l-38.21 30a16.05 16.05 0 00-6.05 14.08c.33 4.14.55 8.3.55 12.47z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg> Settings</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="side1">
                        <div class="flex-between px-4 mt-3">
                            <a href="#" class="btn btn-sm btn-outline-primary">Mark All As Read</a>
                            <a href="profile-notifications.html" class="tx-primary">View All</a>
                        </div>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/1.jpg">
                                    <span class="notification-indicator bg-primary"></span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Madeleine <span class="tx-11 tx-muted font-weight-normal float-end">1min ago</span> </h6>
                                    <p class="mb-0 tx-12">Added 3 files to <a href="#" class="tx-primary">Tempor Dolor</a> task.</p>
                                    <div class="bg-black-03  radius-4 p-2 d-flex align-items-center my-1 pos-relative">
                                        <div class="wd-40">
                                            <img src="../assets/img/files/1.png" alt="docx">
                                        </div>
                                        <div class="ms-1 tx-11">
                                            <p class="mb-0">WORD_File</p>
                                            <span class="small tx-11">35.9mb <a href="#" class="ms-1"><i class="fe fe-download tx-11"></i></a> </span>
                                        </div>
                                        <a href="#" class="tx-11 more pos-absolute">+2 More</a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/2.jpg">
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Dee End <span class="tx-11 tx-muted font-weight-normal float-end">10min ago</span> </h6>
                                    <p class="mb-0 tx-12">At sanctus labore rebum stet sed.</p>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar rounded-circle shadow bg-secondary text-dark text-center me-2">
                                    <span class="tx-20">LN</span>
                                    <span class="notification-indicator bg-primary"></span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Lee Nonmi<span class="tx-11 tx-muted font-weight-normal float-end">15:13</span> </h6>
                                    <p class="mb-0 tx-12">Tempor justo ipsum <a href="#" class="tx-primary">clita rebum lorem</a>.</p>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/10.jpg">
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Peter Owt<span class="tx-11 tx-muted font-weight-normal float-end">12:11</span> </h6>
                                    <p class="mb-0 tx-12">Tempor justo ipsum clita rebum lorem.</p>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/11.jpg">
                                    <span class="notification-indicator bg-primary"></span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Percy Kewshu <span class="tx-11 tx-muted font-weight-normal float-end">00:15</span> </h6>
                                    <p class="mb-0 tx-12">You Have Received 4 files.</p>
                                    <div class="bg-black-03  radius-4 p-2 d-flex align-items-center my-1 pos-relative">
                                        <div class="wd-40">
                                            <img src="../assets/img/files/6.png" alt="ppt">
                                        </div>
                                        <div class="ms-1 tx-11">
                                            <p class="mb-0">PPT_File</p>
                                            <span class="small tx-11">35.9mb <a href="#" class="ms-1"><i class="fe fe-download tx-11"></i></a> </span>
                                        </div>
                                        <a href="#" class="tx-11 more pos-absolute">+3 More</a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/5.jpg">
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Rod Knee<span class="tx-11 tx-muted font-weight-normal float-end">1d ago</span> </h6>
                                    <p class="mb-0 tx-12">Ea duo eos amet ut.</p>
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="main-img-user1 avatar me-2">
                                    <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/13.jpg">
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-1">Mustafa Lee<span class="tx-11 tx-muted font-weight-normal float-end">1w ago</span> </h6>
                                    <p class="mb-0 tx-12">Sed amet stet clita dolores et,.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="side2">
                        <div class="m-3 text-end">
                            <a href="mail-settings.html" class="tx-primary">Mail Settings</a>
                        </div>
                        <div class="px-3 pt-0 pb-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between my-3">
                                <p class="mb-0 font-weight-semibold">Workspace</p>
                                <a href="mail-compose.html" class="btn btn-sm btn-def tx-muted"><i class="fe fe-plus-circle"></i></a>
                            </div>
                            <ul class="list-unstyled mb-0 mt-1">
                                <li>
                                    <div class="d-flex">
                                        <div class="avatar avatar radius-7 shadow bg-purple-gradient">
                                            <i class="fe fe-users"></i>
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Wiley Waites<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">2:00 PM</span>
                                            </div>
                                            <p class="mb-0 tx-12">Aliquyam ipsum sit.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="avatar avatar radius-7 shadow bg-teal-gradient">
                                            <i class="fe fe-terminal"></i>
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Annie Versaree<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">2</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">12:00 PM</span>
                                            </div>
                                            <p class="mb-0 tx-12">At eos no sit...</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="avatar avatar radius-7 shadow bg-primary-gradient">
                                            <i class="fe fe-airplay"></i>
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Hugo First<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">24</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">16 Jan</span>
                                            </div>
                                            <p class="mb-0 tx-12">Sit est dolor dolor.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="avatar avatar radius-7 shadow bg-secondary-gradient text-dark">
                                            <i class="fe fe-terminal"></i>
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Willie Makit<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">3</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">19 Jan </span>
                                            </div>
                                            <p class="mb-0 tx-12">Erat diam ipsum... Sed dolor...</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-0">
                                    <div class="d-flex">
                                        <div class="avatar avatar radius-7 shadow bg-orange-gradient">
                                            <i class="fe fe-airplay"></i>
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Ben Dover<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">20 Jan</span>
                                            </div>
                                            <p class="mb-0 tx-12">Justo accusam stet eirmod et....</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-end mt-2">
                                <a href="chat.html" class="tx-primary">View All</a>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <p class="mb-0 font-weight-semibold">Messages</p>
                                <a href="mail-compose.html" class="btn btn-sm btn-def tx-muted"><i class="fe fe-message-square"></i></a>
                            </div>
                            <ul class="list-unstyled mb-0 mt-2">
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#chatModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/5.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Dulcie Veeta<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">2</span><span class="ms-2"><i class="ti-pin-alt tx-11 tx-muted"></i></span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">3:55 PM</span>
                                            </div>
                                            <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-edit-2 me-1 tx-12 tx-primary"></i>Dulcie is typing...</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#chatModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/9.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Lupe Lamora<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">1:03 PM</span>
                                            </div>
                                            <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-mic me-1 tx-12 tx-primary"></i>Voice message...</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#chatModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/8.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Skye Blue<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">2</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">Yesterday</span>
                                            </div>
                                            <p class="mb-0 tx-12">Sea lorem sit sed tempor..</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#chatModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/3.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Anne Ortha<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">21 Jan</span>
                                            </div>
                                            <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-link-2 me-1 tx-12 tx-primary"></i><a href="#">http://Diam-duoet.xd</a></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-0">
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#chatModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/10.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Michael Souris<span class="badge bg-black-03 text-dark tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">22 Jan</span>
                                            </div>
                                            <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-image me-1 tx-12 tx-primary"></i>+10 photos</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-end mt-2">
                                <a href="chat.html" class="tx-primary">View All</a>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <p class="mb-0 font-weight-semibold">Calls</p>
                                <a href="contacts.html" class="btn btn-sm btn-def tx-muted"><i class="fe fe-phone"></i></a>
                            </div>
                            <ul class="list-unstyled mb-0 mt-2">
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#audioModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/14.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Wilfrid Price<span class="badge bg-danger-transparent tx-danger tx-11 ms-2 font-weight-normal">3</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">12:05 PM</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-x me-1 tx-13 tx-danger"></i>Missed call</p>
                                                <span class="tx-primary"><i class="fe fe-phone"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#videoModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/7.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Jasmin O'Kon</h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">Yesterday</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-arrow-down-left me-1 tx-13 tx-primary"></i>Duration: 15:30</p>
                                                <span class="tx-primary"><i class="fe fe-video"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#videoModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/4.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">River Gleichner</h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">21 Jan</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-arrow-up-right me-1 tx-13 tx-primary"></i>Declined</p>
                                                <span class="tx-primary"><i class="fe fe-video"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#audioModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/12.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Saul Goodmate<span class="badge bg-danger-transparent tx-danger tx-11 ms-2 font-weight-normal">1</span></h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">20 Jan</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-x me-1 tx-13 tx-danger"></i>Missed call</p>
                                                <span class="tx-primary"><i class="fe fe-phone"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-0">
                                    <div class="d-flex pos-relative">
                                        <a href="javascript:void(0)" class="link-overlap" data-bs-toggle="modal" data-bs-target="#audioModal"></a>
                                        <div class="main-img-user avatar d-none d-sm-block">
                                            <img alt="avatar" class="rounded-circle shadow" src="../assets/img/users/13.jpg">
                                        </div>
                                        <div class="flex-1 ms-2">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">Edgardo Huel</h6>
                                                <span class="tx-11 tx-muted ms-auto my-auto">15 Jan</span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0 tx-12 tx-muted d-flex align-items-center"><i class="fe fe-arrow-down-left me-1 tx-13 tx-success"></i>Duration: 01:20:10</p>
                                                <span class="tx-primary"><i class="fe fe-phone"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-end mt-3">
                                <a href="chat.html" class="tx-primary">View All</a>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <div class="svg-card overflow-hidden">
                                <svg class="svg-find" width="150" height="150"><defs ></defs><g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4680 3120" width="150" height="150"><defs><clipPath id="a"><path fill="none" d="M768.84,1618c94.12-107.94,223.54-178.2,330.25-273.7,167.07-149.52,275.28-363.12,297-586.26,8.16-83.8,4.86-170,31.33-249.95,41.45-125.17,159.5-221.36,290.46-236.68,119.78-14,238.73,34.92,340.09,100.26s191.06,147.58,293,212.07C2645.36,770,3038.23,789,3349.24,632c111.24-56.16,221.65-135.27,346-127.1,256.55,16.87,358.67,329.23,286.73,545.89-29.71,89.49-94.81,163.28-129.3,251-48.19,122.64-25.75,265.43,47.24,373.42,77.48,114.63,107.6,219.45,101.23,363.74-4.77,108.09-36.11,216.64-100.26,303.77-111.43,151.38-308.81,220-496.78,220.43s-370.56-58.05-548.83-117.65S2496.19,2324,2308.36,2316.81c-201.66-7.67-400.52,48.52-589,120.56C1485.84,2526.6,1234,2642.8,996.72,2564.22c-71.93-23.82-137.46-64.81-194.54-114.63C548.06,2227.76,555,1863.19,768.84,1618Z"></path></clipPath><clipPath id="b"><rect width="126.5" height="173.72" x="1619.61" y="1759.63" fill="none" transform="rotate(-18.58 1682.841 1846.477)"></rect></clipPath><clipPath id="c"><rect width="126.5" height="173.72" x="977.11" y="1991.17" fill="none" transform="rotate(-18.58 1040.345 2078.01)"></rect></clipPath><clipPath id="d"><rect width="126.5" height="173.72" x="2944.28" y="1313.72" fill="none" transform="rotate(-18.58 3007.49 1400.57)"></rect></clipPath><clipPath id="e"><rect width="126.5" height="173.72" x="2669.05" y="438.07" fill="none" transform="rotate(-18.58 2732.275 524.928)"></rect></clipPath><clipPath id="f"><polygon fill="none" points="1474.54 1064.71 1353.28 1107.01 1295.45 940.55 1416.71 898.26 1474.54 1064.71"></polygon></clipPath><clipPath id="g"><polygon fill="none" points="2421.97 1687.1 2300.71 1729.39 2242.88 1562.94 2364.14 1520.64 2421.97 1687.1"></polygon></clipPath><clipPath id="h"><rect width="126.5" height="173.72" x="2008.79" y="673.3" fill="none" transform="rotate(-18.58 2072.009 760.145)"></rect></clipPath><linearGradient id="i" x1="3056.29" x2="3228.48" y1="-1449.93" y2="-1202.88" gradientTransform="rotate(-173.54 2679.827 -225.499)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffffff" class="stopColorfff svgShape"></stop><stop offset="1" stop-color="#ffffff" stop-opacity="0" class="stopColorfff svgShape"></stop></linearGradient></defs><g data-name="8" fill="#000000" class="color000 svgShape"><rect width="4680" height="3120" fill="transparent" class="colorfff svgShape"></rect><path fill="var(--primary-bg-color)" d="M3899.91,1675.27c77.48,114.64,107.6,219.45,101.24,363.74q-.57,13.13-1.7,26.2-.3,3.67-.66,7.3v0c-6.28,65.65-22.62,130.59-50.43,190-1.56,3.34-3.16,6.68-4.81,10q-2.31,4.66-4.72,9.28h0c-1.58,3.09-3.23,6.14-4.9,9.19a464.23,464.23,0,0,1-33,51.81q-6.91,9.42-14.29,18.37-4.3,5.24-8.77,10.35-9.55,11-19.79,21.37a489.3,489.3,0,0,1-62.92,53.68c-1.74,1.27-3.5,2.51-5.28,3.76a568.27,568.27,0,0,1-96.86,54.26c-1.45.64-2.92,1.29-4.39,1.91-6.7,2.87-13.45,5.66-20.24,8.31q-28.22,11-57.59,19.5c-20.08,5.81-40.48,10.73-61,14.74-6,1.2-12,2.29-18,3.29a767.81,767.81,0,0,1-127.61,10.89h-1.85c-4.61,0-9.24,0-13.84-.11-.45,0-.89,0-1.32,0h-.38c-3.6-.06-7.19-.13-10.79-.24-3.86-.11-7.68-.25-11.51-.4-.34,0-.67,0-1-.05-2.6-.11-5.18-.22-7.77-.35s-5.16-.27-7.74-.43-5.17-.31-7.75-.46c-4.5-.29-9-.63-13.45-1-1.85-.14-3.67-.29-5.5-.45-1.42-.11-2.85-.24-4.27-.38-2.58-.22-5.17-.46-7.73-.71-2.27-.22-4.58-.44-6.85-.69h-.11c-5.41-.56-10.8-1.13-16.19-1.78-2.56-.29-5.12-.6-7.7-.93-4-.49-8-1-12.07-1.56l-5.88-.8c-2.91-.43-5.81-.83-8.72-1.27-2.5-.36-5-.74-7.46-1.14-1.43-.2-2.85-.42-4.28-.67-2.45-.38-4.9-.78-7.34-1.18l-.63-.09c-2.45-.4-4.92-.82-7.37-1.24-1.35-.23-2.71-.45-4-.69l-6.17-1.09c-1.69-.29-3.38-.6-5.07-.92-2.56-.46-5.1-.93-7.66-1.42q-20.37-3.84-40.65-8.26l-6-1.34q-22.35-4.93-44.62-10.53l-14.43-3.67c-7.34-1.92-14.71-3.85-22.06-5.86-1.45-.37-2.89-.77-4.36-1.18s-3-.8-4.48-1.22c-2.51-.69-5-1.38-7.54-2.09q-21.15-5.88-42.22-12.18-11-3.24-21.88-6.59-20.48-6.28-40.85-12.78c-2.5-.78-5-1.58-7.46-2.38-5.7-1.83-11.38-3.65-17.08-5.5l-2.87-.94-9.84-3.2q-30.09-9.86-60-19.88C2677,2386,2496.2,2324,2308.36,2316.81c-201.66-7.68-400.53,48.53-589,120.55-88.18,33.71-179,71.27-270.65,100.72q-19.44,6.26-38.94,12l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38q-30.12,4.54-60.15,6.64c-39.85,2.74-79.57,2-119-3.3-3.07-.4-6.12-.82-9.19-1.29a503.57,503.57,0,0,1-83.49-19.88q-16.07-5.31-31.66-11.76-5.72-2.33-11.35-4.83c-47.4-20.81-91.59-48.91-131.94-81.57a0,0,0,0,1,0,0c-1.56-1.25-3.09-2.52-4.63-3.76q-7.57-6.26-14.94-12.69a583,583,0,0,1-74.76-78.44h0a548.87,548.87,0,0,1-53.81-82.53A533.35,533.35,0,0,1,648.75,2235c-1.29-3.25-2.56-6.53-3.78-9.8q-6.51-17.33-11.78-35c-57.55-192-7-408.61,135.65-572.18C863,1510,992.39,1439.77,1099.09,1344.26c167.07-149.52,275.29-363.11,297-586.25,8.17-83.8,4.87-170,31.32-249.95C1468.89,382.89,1587,286.7,1717.9,271.38c119.78-14,238.73,34.91,340.09,100.27,80.73,52.05,154.06,114.79,232.07,170.76,19.93,14.32,40.17,28.19,60.89,41.3q8.28,5.24,16.68,10.31,16.83,10.18,34.06,19.61,17.89,9.86,36.2,18.9a987.09,987.09,0,0,0,113,47.44c258.23,90.17,553.6,75.59,798.31-48,111.25-56.15,221.66-135.27,346-127.1,256.54,16.87,358.66,329.23,286.73,545.89-29.72,89.48-94.82,163.28-129.31,251C3804.47,1424.5,3826.91,1567.27,3899.91,1675.27Z" class="color1f60e5 svgShape"></path><g clip-path="url(#a)" opacity=".81" fill="#000000" class="color000 svgShape"><rect width="594.27" height="790.56" x="1640.71" y="1638.08" fill="#ffffff" transform="rotate(-18.58 1937.811 2033.338)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="1619.61" y="1759.63" fill="#ffffff" transform="rotate(-18.58 1682.841 1846.477)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="1619.61" y="1759.63" fill="var(--primary-bg-color)" opacity=".08" transform="rotate(-18.58 1682.841 1846.477)" class="color1f60e5 svgShape"></rect><g clip-path="url(#b)" fill="#000000" class="color000 svgShape"><polygon fill="#ffffff" points="1713.1 1891.46 1684.62 1900.96 1682.96 1894.36 1679.57 1880.92 1675.99 1866.69 1697.63 1855.26 1703.76 1869.58 1709.66 1883.4 1713.1 1891.46" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M1784.36,1931.8l-132.23,44.08L1640.39,1933a29.21,29.21,0,0,1,10.39-31.08c.57-.43,1.15-.84,1.76-1.23l5-3.17,8.07-5.16,4.3-2.75,9.14-5.85.34-.22.2.86,1.1,4.66,2.62-.24,19.57-1.89,6.94-.67-2.92-10.77-.71-2.6,1.67-.13,5.72-.44,6.2-.49,14.18-1.13a25.18,25.18,0,0,1,5.11.22l.21,0c9.44,1.43,16.34,8.29,21.43,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1784.36,1931.8l-132.23,44.08L1640.39,1933a29.21,29.21,0,0,1,10.39-31.08c.57-.43,1.15-.84,1.76-1.23l5-3.17,8.07-5.16,4.3-2.75,9.14-5.85.34-.22.2.86,1.1,4.66,2.62-.24,19.57-1.89,6.94-.67-2.92-10.77-.71-2.6,1.67-.13,5.72-.44,6.2-.49,14.18-1.13a25.18,25.18,0,0,1,5.11.22l.21,0c9.44,1.43,16.34,8.29,21.43,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1706.32,1832a36,36,0,0,1,.82,13.37h0q-.09.95-.21,1.86c-.46,3.77-2.43,7-3.9,10.5-.65,1.57-1.37,3.16-2.2,4.72-2.56,4.84-6.07,9.26-11.32,11-4,1.34-8.15.83-12.13-.62-5.79-2.1-11.28-6.2-15.78-9.53-1.3-1-2.46-1.85-3.53-2.72a21.41,21.41,0,0,1-7-10.06,34.72,34.72,0,0,1-1.66-6.81c-.66-4.41-.74-9-1.23-13.37q-1-9.18-2-18.38l33-22.93,12.5,16.92,8.9,15c.84,1.43,1.78,2.85,2.67,4.31A28.38,28.38,0,0,1,1706.32,1832Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1702.94,1867.12c-2.59,5.09-6.18,9.84-11.66,11.67-4.21,1.4-8.53.79-12.69-.82l-1.21-5.15c4,1.45,8.1,2,12.13.62,5.25-1.76,8.76-6.18,11.32-11Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1650.56 1842.7l-5.2 4.36a4.43 4.43 0 00-.85 5.75h0a15 15 0 008.89 6.53l6.35 1.66zM1712.89 1829.83a12 12 0 01-.43 8.14 1.17 1.17 0 010 .11c-.05.1-.11.2-.17.3a14.91 14.91 0 01-1.12 1.72l-3.71 4.89-.27.35h0l-4.05-20.07h.14l6.34.18.12.06A7 7 0 011712.89 1829.83z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M1688.68 1806.1c-1.1-2.11-1.91-3.77-2.28-4.55zM1690.13 1808.83c-.25-.47-.5-.92-.74-1.36C1689.64 1807.91 1689.88 1808.36 1690.13 1808.83zM1696.18 1795.35c-.3-.44-.6-.88-.92-1.32C1695.58 1794.47 1695.89 1794.91 1696.18 1795.35z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M1697.45 1820.8c-5.84-4-14.41-13.57-14.41-13.57-3.79 4.84-29.46 9.82-29.46 9.82a48.48 48.48 0 01-2.16 16.7c-.19-8.24-2.19-18.61-2.2-19.67 0-.19.29-.39.82-.6 4.74-1.88 28.81-4.63 36.12-12.41l.11.21c.28.6 1.16 2.42 2.41 4.82l.06.11A126.55 126.55 0 001697.45 1820.8zM1740.4 1912.88l-11 2.4 8.63 7.29-8.72 27.58L1718.93 1983l-25.52-20.84-23.11-18.88 3.44-19.58-9 3-9.12-27.47 1.84-1.7 8.07-5.16 4.3-2.75 9.14-5.85.54.64 3.72 4.42 13.35 15.82 6.22-17.71 4-11.44 1-2.73 5.72-.44 6.2-.49 14.18-1.13a25.18 25.18 0 015.11.22l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1740.4,1912.88l-11,2.4,8.63,7.29-8.72,27.58L1718.93,1983l-25.52-20.84-23.11-18.88,3.44-19.58-9,3-9.12-27.47,1.84-1.7,8.07-5.16,4.3-2.75,9.14-5.85.54.64,3.72,4.42,13.35,15.82,6.22-17.71,4-11.44,1-2.73,5.72-.44,6.2-.49,14.18-1.13a25.18,25.18,0,0,1,5.11.22l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M1706,1872.86l-1.38,2a19.64,19.64,0,0,1-22.15,7.64l-2.77-.88-.17,3.24,30.86,70.44,2.54-46.62Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1700.39,1803.7c2.43,6.71,3.08,13.86,4.31,22.13.07.48.47,2.88-2.69.19-.42-.36-.86-.78-1.3-1.24s-.89-1-1.34-1.51c-.15-.17-.3-.36-.45-.55-.69-.87-1.4-1.82-2.1-2.82-.19-.28-.39-.56-.58-.85-.77-1.13-1.52-2.31-2.25-3.5l-.43-.71-.42-.7-.47-.79c-.26-.44-.51-.88-.76-1.32-.14-.23-.27-.47-.4-.69l-1-1.74-.16-.29-.26-.48c-.25-.47-.49-.92-.74-1.36s-.44-.85-.65-1.26l-.06-.11-2.28-4.55-.07-.15-.06-.11h0l-.11-.22-.46.46c-7.81,7.44-31,10.12-35.66,12-.53.21-.81.41-.81.6s0,.31,0,.59c0,0,0,.1,0,.15s0,.06,0,.09,0,.24,0,.37.09.59.15.94l0,.22c0,.08,0,.16,0,.24s.06.4.09.62,0,.28.07.43.06.37.09.57c.09.68.21,1.43.32,2.22,0,.15,0,.31.07.46.1.73.2,1.48.31,2.27l.09.78.15,1.22.06.58c0,.32.08.64.11,1,.06.59.12,1.19.17,1.8.09,1,.16,1.94.22,2.9,0,.49.05,1,.07,1.47s0,.94,0,1.41v.27c0,.6,0,1.17,0,1.74,0,.14,0,.28,0,.42a23.2,23.2,0,0,1-.38,3.39c-.62,3.19-1.58,2.72-1.42,4-3-7.63-5.49-10.92-8.44-18.59a52.49,52.49,0,0,1-3.29-11.48,22.94,22.94,0,0,1-.23-4.51c.44-8,5.56-14.91,12.68-19.66a42.46,42.46,0,0,1,15.53-6.34h0a44,44,0,0,0,6.32-.69c15-2.8,17.14-12.53,17.14-12.53s11.38,13.51,5.91,23.64c.32.44.62.88.92,1.32s.58.88.85,1.32c.13.22.27.44.39.66s.26.45.38.67.25.44.36.66c.3.56.58,1.13.85,1.69.08.16.15.32.22.48s.23.5.33.75l.21.51c.08.18.15.36.22.54l.21.54C1700.27,1803.34,1700.33,1803.53,1700.39,1803.7Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M1686.27,1801.28h0c-.19.08-.37.16-.57.23l.46-.46Z" class="color2d1d2c svgShape"></path></g><line x1="1781.27" x2="2057.34" y1="1746.63" y2="1653.83" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1790.62" x2="2066.7" y1="1774.55" y2="1681.75" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1790.62" x2="2066.7" y1="1774.55" y2="1681.75" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1799.98" x2="2076.05" y1="1802.47" y2="1709.67" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1659.18" x2="2116.51" y1="1984.14" y2="1830.41" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1677.42" x2="2134.75" y1="2038.58" y2="1884.85" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1696.13" x2="2153.46" y1="2094.42" y2="1940.69" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1714.84" x2="2172.17" y1="2150.26" y2="1996.53" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1733.55" x2="2190.88" y1="2206.09" y2="2052.36" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><rect width="594.27" height="790.56" x="998.21" y="1869.61" fill="#ffffff" transform="rotate(-18.58 1295.315 2264.87)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="977.11" y="1991.17" fill="#ffffff" transform="rotate(-18.58 1040.345 2078.01)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="977.11" y="1991.17" fill="var(--primary-bg-color)" opacity=".08" transform="rotate(-18.58 1040.345 2078.01)" class="color1f60e5 svgShape"></rect><g clip-path="url(#c)" fill="#000000" class="color000 svgShape"><polygon fill="#ffffff" points="1070.6 2123 1042.12 2132.49 1040.46 2125.9 1037.07 2112.46 1033.49 2098.23 1055.13 2086.79 1061.25 2101.12 1067.16 2114.94 1070.6 2123" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M1141.86,2163.34l-132.23,44.07-11.74-42.92a29.2,29.2,0,0,1,10.39-31.08c.57-.43,1.15-.85,1.76-1.23l5-3.17,8.06-5.17,4.31-2.74,9.14-5.85.34-.22.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.94-.67-2.92-10.77-.71-2.6,1.66-.13,5.73-.44,6.2-.5,14.18-1.12a24.51,24.51,0,0,1,5.11.22l.21,0c9.44,1.43,16.34,8.29,21.42,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1141.86,2163.34l-132.23,44.07-11.74-42.92a29.2,29.2,0,0,1,10.39-31.08c.57-.43,1.15-.85,1.76-1.23l5-3.17,8.06-5.17,4.31-2.74,9.14-5.85.34-.22.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.94-.67-2.92-10.77-.71-2.6,1.66-.13,5.73-.44,6.2-.5,14.18-1.12a24.51,24.51,0,0,1,5.11.22l.21,0c9.44,1.43,16.34,8.29,21.42,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1063.82,2063.5a36,36,0,0,1,.82,13.37h0c-.06.63-.13,1.24-.21,1.85-.46,3.77-2.43,7-3.9,10.5-.66,1.57-1.38,3.17-2.2,4.72-2.56,4.84-6.07,9.27-11.32,11-4,1.35-8.15.84-12.13-.61-5.79-2.1-11.29-6.2-15.78-9.54-1.3-1-2.47-1.84-3.53-2.72a21.38,21.38,0,0,1-7-10,35.06,35.06,0,0,1-1.66-6.81c-.66-4.42-.74-9-1.23-13.37-.67-6.12-1.36-12.25-2-18.38l32.95-22.94,12.5,16.93q4.45,7.51,8.9,15c.84,1.42,1.78,2.85,2.67,4.3A28.56,28.56,0,0,1,1063.82,2063.5Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1060.44,2098.66c-2.59,5.09-6.18,9.84-11.66,11.66-4.21,1.41-8.53.79-12.69-.82l-1.21-5.14c4,1.45,8.1,2,12.13.61,5.25-1.75,8.76-6.18,11.32-11Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1008.06 2074.24l-5.2 4.35a4.44 4.44 0 00-.85 5.76h0a15.06 15.06 0 008.89 6.53l6.35 1.66zM1070.39 2061.37a12 12 0 01-.43 8.13.67.67 0 01-.06.12 2.19 2.19 0 01-.16.3 14.91 14.91 0 01-1.12 1.72l-3.71 4.88-.27.36h0l-4.05-20.07h.14l6.34.18a.39.39 0 01.11.06A6.9 6.9 0 011070.39 2061.37z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M1046.18 2037.64c-1.1-2.11-1.91-3.77-2.28-4.55zM1047.63 2040.37c-.26-.47-.5-.93-.74-1.37C1047.13 2039.45 1047.37 2039.9 1047.63 2040.37zM1053.68 2026.89c-.3-.45-.6-.89-.93-1.33C1053.08 2026 1053.39 2026.44 1053.68 2026.89z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M1055 2052.33c-5.85-4-14.41-13.56-14.41-13.56-3.79 4.83-29.46 9.82-29.46 9.82a48.75 48.75 0 01-2.16 16.7c-.19-8.24-2.19-18.61-2.2-19.67 0-.19.29-.39.82-.61 4.74-1.87 28.81-4.62 36.12-12.41l.11.22c.28.6 1.16 2.41 2.41 4.82l.06.11A125.63 125.63 0 001055 2052.33zM1097.9 2144.41l-11 2.4 8.64 7.3-8.72 27.58-10.37 32.81-25.52-20.85-23.11-18.88 3.44-19.58-9 3-9.13-27.47 1.85-1.7 8.06-5.17 4.31-2.74 9.14-5.85.54.64 3.72 4.41 13.35 15.82 6.22-17.7 4-11.44 1-2.73 5.73-.44 6.2-.5 14.18-1.12a24.51 24.51 0 015.11.22l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1097.9,2144.41l-11,2.4,8.64,7.3-8.72,27.58-10.37,32.81-25.52-20.85-23.11-18.88,3.44-19.58-9,3-9.13-27.47,1.85-1.7,8.06-5.17,4.31-2.74,9.14-5.85.54.64,3.72,4.41,13.35,15.82,6.22-17.7,4-11.44,1-2.73,5.73-.44,6.2-.5,14.18-1.12a24.51,24.51,0,0,1,5.11.22l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M1063.47,2104.4l-1.38,2a19.61,19.61,0,0,1-22.15,7.64l-2.77-.87-.17,3.23,30.86,70.45,2.54-46.62Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1057.89,2035.24c2.42,6.71,3.07,13.85,4.31,22.12.07.48.47,2.88-2.69.2-.42-.37-.86-.78-1.3-1.25s-.89-1-1.34-1.5l-.45-.55c-.7-.87-1.4-1.82-2.1-2.82-.19-.28-.39-.56-.58-.85-.77-1.13-1.52-2.31-2.25-3.5l-.43-.71-.42-.71c-.16-.26-.32-.52-.47-.78l-.76-1.33c-.14-.23-.27-.46-.4-.69l-1-1.73-.16-.3c-.09-.15-.17-.31-.26-.47-.26-.47-.5-.92-.74-1.37l-.65-1.25-.06-.11-2.28-4.55-.07-.15-.06-.11h0l-.11-.22-.46.46c-7.81,7.44-31,10.12-35.66,12-.53.22-.81.42-.82.61s0,.31.06.59a.68.68,0,0,0,0,.14s0,.07,0,.1,0,.23.05.36c0,.28.09.59.14.94a1.85,1.85,0,0,1,0,.23c0,.08,0,.16,0,.24s.06.4.09.61.05.28.07.43.06.38.09.57c.09.69.21,1.44.32,2.23,0,.15.05.3.07.46.1.72.2,1.48.31,2.27q0,.38.09.78l.15,1.22.06.57c0,.32.08.65.11,1,.06.6.12,1.2.17,1.8.09,1,.16,1.95.22,2.91,0,.49,0,1,.07,1.47s0,.94,0,1.4v.28c0,.59,0,1.17,0,1.74,0,.14,0,.28,0,.42a23.36,23.36,0,0,1-.38,3.39c-.63,3.18-1.58,2.72-1.42,4-3-7.63-5.49-10.92-8.44-18.59a53.26,53.26,0,0,1-3.3-11.48,23,23,0,0,1-.22-4.52c.44-8,5.56-14.9,12.67-19.66a42.73,42.73,0,0,1,15.54-6.33h0a45.42,45.42,0,0,0,6.32-.69c15-2.8,17.14-12.53,17.14-12.53s11.38,13.51,5.9,23.63c.33.44.63.88.93,1.33s.57.87.85,1.32c.13.22.27.44.39.66s.26.44.38.66.25.45.36.67c.3.56.58,1.12.85,1.69l.22.48c.11.25.23.5.33.74l.21.52.22.54c.07.18.13.35.21.53S1057.83,2035.06,1057.89,2035.24Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M1043.77,2032.82h0l-.57.23.46-.46Z" class="color2d1d2c svgShape"></path></g><line x1="1138.77" x2="1414.84" y1="1978.17" y2="1885.37" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1148.12" x2="1424.2" y1="2006.09" y2="1913.29" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1148.12" x2="1424.2" y1="2006.09" y2="1913.29" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1157.48" x2="1433.55" y1="2034" y2="1941.2" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1016.68" x2="1474.01" y1="2215.68" y2="2061.95" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1034.92" x2="1492.25" y1="2270.12" y2="2116.39" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1053.63" x2="1510.96" y1="2325.96" y2="2172.23" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1072.33" x2="1529.67" y1="2381.79" y2="2228.06" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1091.04" x2="1548.38" y1="2437.63" y2="2283.9" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><rect width="594.27" height="790.56" x="2965.37" y="1192.16" fill="#ffffff" transform="rotate(-18.58 3262.46 1587.43)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="2944.28" y="1313.72" fill="#ffffff" transform="rotate(-18.58 3007.49 1400.57)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="2944.28" y="1313.72" fill="var(--primary-bg-color)" opacity=".08" transform="rotate(-18.58 3007.49 1400.57)" class="color1f60e5 svgShape"></rect><g clip-path="url(#d)" fill="#000000" class="color000 svgShape"><polygon fill="#ffffff" points="3037.76 1445.55 3009.28 1455.04 3007.62 1448.45 3004.24 1435 3000.65 1420.78 3022.29 1409.34 3028.42 1423.67 3034.32 1437.49 3037.76 1445.55" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M3109,1485.88,2976.79,1530,2965.05,1487a29.2,29.2,0,0,1,10.39-31.08c.57-.44,1.16-.85,1.76-1.23l5-3.17,8.07-5.17,4.3-2.75,9.14-5.85.34-.21.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.95-.67-2.93-10.77-.71-2.6,1.67-.13,5.72-.45,6.2-.49,14.19-1.12a24.42,24.42,0,0,1,5.1.22l.21,0c9.44,1.43,16.34,8.29,21.43,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M3109,1485.88,2976.79,1530,2965.05,1487a29.2,29.2,0,0,1,10.39-31.08c.57-.44,1.16-.85,1.76-1.23l5-3.17,8.07-5.17,4.3-2.75,9.14-5.85.34-.21.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.95-.67-2.93-10.77-.71-2.6,1.67-.13,5.72-.45,6.2-.49,14.19-1.12a24.42,24.42,0,0,1,5.1.22l.21,0c9.44,1.43,16.34,8.29,21.43,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M3031,1386.05a36.17,36.17,0,0,1,.81,13.37h0c-.07.62-.13,1.24-.21,1.85-.46,3.77-2.44,7-3.91,10.5-.65,1.57-1.37,3.17-2.2,4.72-2.56,4.84-6.07,9.27-11.32,11a18.15,18.15,0,0,1-12.13-.61c-5.79-2.1-11.28-6.21-15.78-9.54-1.3-1-2.46-1.84-3.52-2.72a21.33,21.33,0,0,1-7-10.05,35.06,35.06,0,0,1-1.66-6.81c-.66-4.42-.74-9-1.23-13.37q-1-9.2-2-18.38l32.95-22.94,12.51,16.93,8.89,15c.85,1.42,1.78,2.85,2.67,4.3A28.6,28.6,0,0,1,3031,1386.05Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M3027.6,1421.21c-2.59,5.09-6.18,9.83-11.66,11.66-4.21,1.41-8.53.79-12.69-.82l-1.21-5.14a18.15,18.15,0,0,0,12.13.61c5.25-1.75,8.76-6.18,11.32-11Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2975.23 1396.79l-5.2 4.35a4.43 4.43 0 00-.86 5.76h0a15.06 15.06 0 008.89 6.53l6.35 1.65zM3037.55 1383.92a12 12 0 01-.43 8.13l0 .12c-.05.1-.11.19-.16.3a15.91 15.91 0 01-1.13 1.72l-3.71 4.88-.26.36h0l-4.05-20.07h.15l6.33.18.12 0A7 7 0 013037.55 1383.92z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M3013.34 1360.19c-1.1-2.12-1.91-3.78-2.28-4.56zM3014.79 1362.92l-.73-1.37C3014.3 1362 3014.54 1362.45 3014.79 1362.92zM3020.84 1349.43c-.3-.44-.6-.88-.92-1.32C3020.24 1348.55 3020.55 1349 3020.84 1349.43z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M3022.12 1374.88c-5.85-4.05-14.42-13.56-14.42-13.56-3.78 4.83-29.46 9.82-29.46 9.82a48.42 48.42 0 01-2.16 16.69c-.19-8.24-2.19-18.6-2.19-19.66 0-.2.29-.4.81-.61 4.74-1.87 28.81-4.62 36.12-12.41l.11.22c.28.6 1.16 2.41 2.41 4.82l.06.11A125.21 125.21 0 003022.12 1374.88zM3065.06 1467l-11 2.4 8.64 7.29-8.72 27.59-10.38 32.81-25.52-20.85L2995 1497.32l3.44-19.58-9 3-9.12-27.47 1.84-1.7 8.07-5.17 4.3-2.75 9.14-5.85.54.65 3.72 4.41 13.35 15.82 6.22-17.7 4-11.44 1-2.73 5.72-.45 6.2-.49 14.19-1.12a24.42 24.42 0 015.1.22l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M3065.06,1467l-11,2.4,8.64,7.29-8.72,27.59-10.38,32.81-25.52-20.85L2995,1497.32l3.44-19.58-9,3-9.12-27.47,1.84-1.7,8.07-5.17,4.3-2.75,9.14-5.85.54.65,3.72,4.41,13.35,15.82,6.22-17.7,4-11.44,1-2.73,5.72-.45,6.2-.49,14.19-1.12a24.42,24.42,0,0,1,5.1.22l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M3030.63,1427l-1.37,2a19.65,19.65,0,0,1-22.16,7.64l-2.77-.87-.17,3.23,30.86,70.44,2.54-46.61Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M3025.05,1357.79c2.43,6.71,3.08,13.85,4.31,22.12.08.48.47,2.88-2.68.19a14.85,14.85,0,0,1-1.31-1.24c-.44-.46-.89-1-1.34-1.5l-.45-.55c-.69-.87-1.4-1.82-2.1-2.82-.19-.28-.39-.56-.58-.85-.76-1.13-1.52-2.31-2.25-3.51-.14-.23-.28-.47-.43-.7l-.42-.71-.47-.79c-.26-.44-.51-.88-.76-1.32l-.39-.69-1-1.73-.16-.3c-.09-.16-.17-.32-.26-.47-.25-.47-.49-.93-.73-1.37l-.66-1.25-.06-.11-2.28-4.56-.07-.14-.06-.11h0l-.11-.22a5,5,0,0,1-.46.46c-7.81,7.44-31,10.11-35.66,12-.53.21-.81.41-.81.6s0,.32.05.6a.68.68,0,0,1,0,.14s0,.07,0,.1,0,.23.05.36c0,.28.09.59.14.94l0,.23a1.57,1.57,0,0,1,0,.23c0,.2.06.4.09.62s.05.28.07.43.06.38.09.57c.1.69.21,1.44.33,2.23l.06.46c.1.72.21,1.48.31,2.27l.09.78.15,1.22.07.57c0,.32.07.65.1,1l.18,1.8q.12,1.46.21,2.91c0,.49.05,1,.07,1.46s0,1,0,1.41v.28c0,.59,0,1.17,0,1.74,0,.14,0,.28,0,.42a24.93,24.93,0,0,1-.37,3.39c-.63,3.18-1.59,2.72-1.42,4-3-7.63-5.5-10.92-8.44-18.59a52.77,52.77,0,0,1-3.3-11.49,22.94,22.94,0,0,1-.23-4.51c.44-8,5.57-14.91,12.68-19.66a42.69,42.69,0,0,1,15.53-6.33h0a43.88,43.88,0,0,0,6.32-.7c15-2.79,17.15-12.52,17.15-12.52s11.37,13.5,5.9,23.63c.32.44.62.88.92,1.32s.58.88.85,1.33c.14.22.27.44.4.66s.25.44.37.66.25.45.37.67c.29.56.58,1.12.84,1.69.08.16.15.32.22.48s.23.49.33.74.14.35.22.51l.21.54c.07.19.14.36.21.54S3025,1357.61,3025.05,1357.79Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M3010.93,1355.37h0l-.57.23a5,5,0,0,0,.46-.46Z" class="color2d1d2c svgShape"></path></g><line x1="3105.93" x2="3382" y1="1300.72" y2="1207.92" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3115.29" x2="3391.36" y1="1328.63" y2="1235.83" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3115.29" x2="3391.36" y1="1328.63" y2="1235.83" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3124.64" x2="3400.71" y1="1356.55" y2="1263.75" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2983.84" x2="3441.17" y1="1538.23" y2="1384.5" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3002.08" x2="3459.41" y1="1592.67" y2="1438.94" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3020.79" x2="3478.12" y1="1648.5" y2="1494.77" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3039.5" x2="3496.83" y1="1704.34" y2="1550.61" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="3058.21" x2="3515.54" y1="1760.18" y2="1606.45" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><rect width="594.27" height="790.56" x="2690.14" y="316.51" fill="#ffffff" transform="rotate(-18.58 2987.245 711.789)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="2669.05" y="438.07" fill="#ffffff" transform="rotate(-18.58 2732.275 524.928)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="2669.05" y="438.07" fill="var(--primary-bg-color)" opacity=".08" transform="rotate(-18.58 2732.275 524.928)" class="color1f60e5 svgShape"></rect><g clip-path="url(#e)" fill="#000000" class="color000 svgShape"><polygon fill="#ffffff" points="2762.53 569.9 2734.06 579.39 2732.39 572.79 2729.01 559.35 2725.42 545.12 2747.07 533.69 2753.19 548.02 2759.09 561.83 2762.53 569.9" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M2833.8,610.23l-132.24,44.08-11.73-42.93a29.19,29.19,0,0,1,10.38-31.08c.57-.43,1.16-.84,1.76-1.23l5-3.17,8.07-5.16,4.3-2.75,9.14-5.85.34-.21.2.86,1.11,4.66,2.61-.25,19.57-1.89,6.95-.66-2.93-10.78-.71-2.59,1.67-.13,5.72-.45,6.2-.49,14.19-1.12a25.13,25.13,0,0,1,5.1.21l.21,0c9.44,1.44,16.34,8.3,21.43,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2833.8,610.23l-132.24,44.08-11.73-42.93a29.19,29.19,0,0,1,10.38-31.08c.57-.43,1.16-.84,1.76-1.23l5-3.17,8.07-5.16,4.3-2.75,9.14-5.85.34-.21.2.86,1.11,4.66,2.61-.25,19.57-1.89,6.95-.66-2.93-10.78-.71-2.59,1.67-.13,5.72-.45,6.2-.49,14.19-1.12a25.13,25.13,0,0,1,5.1.21l.21,0c9.44,1.44,16.34,8.3,21.43,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2755.76,510.4a36.16,36.16,0,0,1,.81,13.37h0c-.07.63-.13,1.25-.21,1.86-.46,3.77-2.44,7-3.91,10.5-.65,1.57-1.37,3.16-2.2,4.72-2.56,4.84-6.06,9.26-11.32,11-4,1.34-8.15.83-12.13-.62-5.78-2.1-11.28-6.2-15.78-9.53-1.29-1-2.46-1.85-3.52-2.72a21.43,21.43,0,0,1-7.05-10.06,35.44,35.44,0,0,1-1.66-6.81c-.66-4.41-.74-9-1.23-13.36q-1-9.19-2-18.38l33-22.94,12.5,16.93,8.89,15c.85,1.43,1.78,2.85,2.67,4.31A28.41,28.41,0,0,1,2755.76,510.4Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2752.37,545.55c-2.59,5.09-6.17,9.84-11.66,11.67-4.21,1.4-8.53.79-12.68-.82l-1.22-5.15c4,1.45,8.1,2,12.13.62,5.26-1.76,8.76-6.18,11.32-11Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2700 521.14l-5.2 4.35a4.42 4.42 0 00-.86 5.75h0a15 15 0 008.89 6.53l6.35 1.66zM2762.32 508.27a11.91 11.91 0 01-.43 8.13.37.37 0 010 .11l-.16.3a14.16 14.16 0 01-1.13 1.72l-3.71 4.89-.26.35h0l-4.05-20.07h.15l6.34.18.11.05A6.88 6.88 0 012762.32 508.27z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M2738.12 484.54c-1.11-2.12-1.92-3.78-2.29-4.56zM2739.56 487.26c-.25-.46-.5-.92-.73-1.36zM2745.62 473.78q-.45-.66-.93-1.32C2745 472.9 2745.32 473.34 2745.62 473.78z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M2746.89 499.23c-5.85-4.05-14.42-13.57-14.42-13.57-3.78 4.84-29.45 9.82-29.45 9.82a48.71 48.71 0 01-2.17 16.7c-.19-8.24-2.19-18.61-2.19-19.67 0-.19.29-.39.82-.6 4.74-1.88 28.8-4.62 36.11-12.41l.11.21c.28.61 1.16 2.42 2.41 4.83l.06.1A124.46 124.46 0 002746.89 499.23zM2789.83 591.31l-11 2.4 8.64 7.29-8.72 27.58-10.38 32.82-25.52-20.85-23.11-18.88 3.44-19.58-9 3-9.13-27.47 1.84-1.7 8.07-5.16 4.3-2.75 9.14-5.85.54.65 3.72 4.41L2746.05 583l6.22-17.71 4-11.44 1-2.72 5.72-.45 6.2-.49 14.19-1.12a25.13 25.13 0 015.1.21l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2789.83,591.31l-11,2.4,8.64,7.29-8.72,27.58-10.38,32.82-25.52-20.85-23.11-18.88,3.44-19.58-9,3-9.13-27.47,1.84-1.7,8.07-5.16,4.3-2.75,9.14-5.85.54.65,3.72,4.41L2746.05,583l6.22-17.71,4-11.44,1-2.72,5.72-.45,6.2-.49,14.19-1.12a25.13,25.13,0,0,1,5.1.21l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M2755.4,551.3l-1.37,2a19.65,19.65,0,0,1-22.16,7.64l-2.77-.88-.17,3.24,30.87,70.44,2.53-46.61Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2749.83,482.14c2.42,6.7,3.07,13.85,4.31,22.12.07.48.47,2.88-2.69.19a16.49,16.49,0,0,1-1.31-1.24c-.44-.46-.89-1-1.34-1.5l-.45-.56c-.69-.87-1.39-1.82-2.1-2.81l-.58-.86c-.76-1.13-1.51-2.31-2.25-3.5l-.42-.7-.43-.71-.46-.79c-.26-.44-.52-.88-.77-1.32l-.39-.69c-.33-.59-.66-1.17-1-1.74a2.69,2.69,0,0,0-.16-.29l-.26-.48-.73-1.36-.66-1.26-.05-.1-2.29-4.56-.07-.14-.05-.12h0l-.1-.21-.46.46c-7.82,7.43-31,10.11-35.66,12-.53.21-.81.41-.82.6a5.25,5.25,0,0,0,.06.6s0,.09,0,.14,0,.06,0,.1,0,.23.05.36.09.59.14.94a1.6,1.6,0,0,1,0,.23,1.57,1.57,0,0,1,0,.23c0,.2.06.4.09.62s.05.28.07.43l.09.57c.1.68.21,1.43.33,2.22l.06.46c.1.73.21,1.49.31,2.28,0,.25.07.51.1.78s.09.8.14,1.22l.07.57c0,.32.07.64.1,1,.07.6.12,1.2.18,1.8.08,1,.16,1.94.21,2.9,0,.49,0,1,.07,1.47s0,1,0,1.41c0,.09,0,.18,0,.27,0,.6,0,1.18,0,1.74,0,.14,0,.28,0,.42a23.28,23.28,0,0,1-.37,3.39c-.63,3.19-1.59,2.72-1.42,4-3-7.62-5.49-10.91-8.44-18.58a52.77,52.77,0,0,1-3.3-11.49,22.94,22.94,0,0,1-.23-4.51c.44-8,5.57-14.91,12.68-19.66a42.49,42.49,0,0,1,15.54-6.33h0a45.67,45.67,0,0,0,6.33-.7c15-2.8,17.14-12.53,17.14-12.53s11.37,13.51,5.9,23.64q.48.66.93,1.32t.84,1.32c.14.22.27.44.4.67s.26.44.38.66l.36.66c.3.57.58,1.13.84,1.69l.23.48c.11.25.22.5.32.75s.14.34.22.51l.21.54.21.54C2749.7,481.77,2749.77,482,2749.83,482.14Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M2735.7,479.71h0l-.57.24.46-.46Z" class="color2d1d2c svgShape"></path></g><line x1="2830.7" x2="3106.78" y1="425.06" y2="332.26" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2840.06" x2="3116.13" y1="452.98" y2="360.18" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2840.06" x2="3116.13" y1="452.98" y2="360.18" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2849.41" x2="3125.49" y1="480.9" y2="388.1" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2708.61" x2="3165.94" y1="662.57" y2="508.84" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2726.85" x2="3184.19" y1="717.02" y2="563.29" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2745.56" x2="3202.89" y1="772.85" y2="619.12" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2764.27" x2="3221.6" y1="828.69" y2="674.96" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2782.98" x2="3240.31" y1="884.52" y2="730.79" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><polygon fill="#ffffff" points="2062.23 1468.61 1492.6 1667.32 1229.44 909.81 1799.07 711.11 2062.23 1468.61" class="colorfff svgShape"></polygon><polygon fill="#ffffff" points="1474.54 1064.71 1353.28 1107.01 1295.45 940.55 1416.71 898.26 1474.54 1064.71" class="colorfff svgShape"></polygon><polygon fill="var(--primary-bg-color)" points="1474.54 1064.71 1353.28 1107.01 1295.45 940.55 1416.71 898.26 1474.54 1064.71" opacity=".08" class="color1f60e5 svgShape"></polygon><g clip-path="url(#f)" fill="#000000" class="color000 svgShape"><polygon fill="#319bc1" points="1362.88 1016.08 1372.74 1068.12 1431.91 1043.37 1410.5 999.47 1362.88 1016.08" opacity=".71" class="color003fc3 svgShape"></polygon><polygon fill="#ffffff" points="1416.18 1047.9 1387.38 1057.86 1385.62 1051.19 1382.03 1037.6 1378.24 1023.2 1400.08 1011.35 1406.45 1025.81 1412.6 1039.76 1416.18 1047.9" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M1489,1088l-133.73,46.27-12.38-43.41a29.63,29.63,0,0,1,10.2-31.65c.57-.45,1.16-.87,1.77-1.27l5-3.28,8.13-5.33,4.34-2.84,9.21-6,.34-.22.22.87,1.17,4.72,2.65-.29,19.84-2.14,7-.76-3.09-10.89-.74-2.63,1.69-.15,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0c9.6,1.34,16.67,8.22,21.94,17.59Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1489,1088l-133.73,46.27-12.38-43.41a29.63,29.63,0,0,1,10.2-31.65c.57-.45,1.16-.87,1.77-1.27l5-3.28,8.13-5.33,4.34-2.84,9.21-6,.34-.22.22.87,1.17,4.72,2.65-.29,19.84-2.14,7-.76-3.09-10.89-.74-2.63,1.69-.15,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0c9.6,1.34,16.67,8.22,21.94,17.59Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1408.64,987.62a36.3,36.3,0,0,1,1,13.55h0c-.06.64-.11,1.26-.19,1.88-.42,3.83-2.39,7.11-3.84,10.7-.65,1.6-1.37,3.23-2.19,4.82-2.54,4.94-6.05,9.47-11.37,11.31-4.07,1.41-8.26.94-12.31-.48-5.9-2.07-11.52-6.16-16.12-9.49-1.33-1-2.52-1.84-3.61-2.72a21.6,21.6,0,0,1-7.26-10.12,35.73,35.73,0,0,1-1.76-6.89c-.72-4.47-.85-9.08-1.39-13.54q-1.14-9.31-2.27-18.63l33.2-23.65,12.87,17q4.59,7.58,9.19,15.13c.88,1.44,1.84,2.88,2.76,4.34A28.82,28.82,0,0,1,1408.64,987.62Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M1405.59,1023.33c-2.56,5.19-6.15,10.05-11.7,12-4.26,1.48-8.65.9-12.88-.68l-1.29-5.2c4,1.42,8.24,1.89,12.31.48,5.32-1.84,8.83-6.37,11.37-11.31Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M1352.17 999.17l-5.23 4.47a4.49 4.49 0 00-.8 5.85h0a15.21 15.21 0 009.09 6.52l6.46 1.61zM1415.29 985.38a12.21 12.21 0 01-.35 8.25.73.73 0 010 .12c-.05.11-.11.2-.17.31a14.13 14.13 0 01-1.12 1.76l-3.71 5-.27.36h0l-4.33-20.31h.15l6.43.11.12 0A7 7 0 011415.29 985.38z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M1390.46 961.59c-1.15-2.13-2-3.81-2.37-4.59zM1392 964.34c-.27-.47-.52-.93-.77-1.38C1391.44 963.41 1391.69 963.87 1392 964.34zM1398 950.59c-.31-.44-.62-.89-1-1.33C1397.33 949.7 1397.65 950.14 1398 950.59z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M1399.52 976.39c-6-4-14.78-13.59-14.78-13.59-3.79 5-29.79 10.31-29.79 10.31a49.18 49.18 0 01-2 17c-.29-8.36-2.43-18.85-2.44-19.92 0-.2.29-.41.82-.63 4.79-1.95 29.18-5 36.52-13l.11.22c.3.61 1.21 2.43 2.5 4.86l.06.11A127.44 127.44 0 001399.52 976.39zM1444.12 1069.3l-11.15 2.57 8.85 7.29-8.55 28.09-10.17 33.41L1397 1119.81l-23.67-18.89 3.28-19.9-9.06 3.13-9.56-27.76 1.85-1.75 8.13-5.33 4.34-2.84 9.21-6 .56.65 3.82 4.43 13.72 15.9 6.12-18 4-11.65.95-2.78 5.8-.52 6.29-.57 14.38-1.31a25.39 25.39 0 015.19.16l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1444.12,1069.3l-11.15,2.57,8.85,7.29-8.55,28.09-10.17,33.41L1397,1119.81l-23.67-18.89,3.28-19.9-9.06,3.13-9.56-27.76,1.85-1.75,8.13-5.33,4.34-2.84,9.21-6,.56.65,3.82,4.43,13.72,15.9,6.12-18,4-11.65.95-2.78,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M1408.74,1029.11l-1.38,2.05a20,20,0,0,1-22.4,8l-2.82-.85-.14,3.28,32.1,71.1,2.06-47.32Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M1361.07 940.82a45.53 45.53 0 01-7.68 3.54A44 44 0 011361.07 940.82zM1387.64 956.7a3.45 3.45 0 00-.26.28c-4 3.9-12.12 6.61-19.72 8.56a155 155 0 0018.73-8.1A7.76 7.76 0 001387.64 956.7z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#319bc1" d="M1402.32,959c2.52,6.78,3.27,14,4.62,22.38.06.49.5,2.93-2.74.24-.43-.37-.88-.78-1.33-1.24s-.91-1-1.39-1.51c-.14-.18-.29-.37-.46-.56-.71-.88-1.43-1.82-2.16-2.84-.2-.28-.4-.56-.6-.86-.78-1.12-1.56-2.31-2.32-3.53a7.54,7.54,0,0,0-.45-.7c-.14-.24-.28-.48-.43-.72l-.48-.79c-.26-.45-.53-.89-.79-1.33-.14-.24-.26-.46-.41-.7-.32-.58-.67-1.18-1-1.75-.06-.08-.11-.19-.17-.29s-.17-.33-.27-.48c-.26-.46-.51-.93-.76-1.38s-.46-.84-.67-1.27l-.06-.1-2.37-4.59-.07-.14-.07-.13-.1-.17v0l-.2.19a7.76,7.76,0,0,1-1.25.74,155,155,0,0,1-18.73,8.1c-7.26,1.85-14.05,3.05-16.34,4l-.44.22c-.25.15-.37.27-.38.42a4.94,4.94,0,0,0,.06.59.41.41,0,0,0,0,.16.14.14,0,0,0,0,.1,1.5,1.5,0,0,0,0,.35c.06.29.1.6.16.95l0,.24a.59.59,0,0,1,0,.23,6.06,6.06,0,0,1,.12.64c0,.13,0,.27.07.43s.07.38.1.58c.09.68.23,1.44.35,2.26,0,.13,0,.29.08.45.11.74.21,1.5.33,2.3,0,.26.08.53.1.79s.11.83.17,1.24c0,.19,0,.39.08.58s.08.65.11,1c.07.6.14,1.21.19,1.83.11,1,.19,2,.26,2.93,0,.5.06,1,.08,1.49s0,1,0,1.44c0,.08,0,.18,0,.26,0,.62,0,1.19,0,1.77,0,.15,0,.29,0,.44a27.53,27.53,0,0,1-.35,3.43c-.6,3.24-1.58,2.79-1.4,4.08-3.17-7.71-5.7-11-8.76-18.77a53.82,53.82,0,0,1-3.48-11.62,22.89,22.89,0,0,1-.29-4.5c-7.09-6.82-2.39-18.87,7.54-19.85a31.41,31.41,0,0,0,7.17-1.6,45.53,45.53,0,0,0,7.68-3.54h0c.69-.38,1.4-.79,2.11-1.25a29.71,29.71,0,0,1,19.06-4.24,11.46,11.46,0,0,1,10.29,9.27,34.2,34.2,0,0,1,9.33,13.35c.09.17.15.36.23.53S1402.26,958.83,1402.32,959Z" opacity=".71" class="color003fc3 svgShape"></path><path fill="#319bc1" d="M1367.66 965.54a100.72 100.72 0 01-12.63 3.6 28.94 28.94 0 01-4.15.59l.44-.22C1353.61 968.59 1360.4 967.39 1367.66 965.54zM1387.84 956.51v0a.46.46 0 01-.21.14z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M1388,956.73h0l-.58.24.46-.47Z" class="color2d1d2c svgShape"></path></g><line x1="1483.77" x2="1762.95" y1="900.17" y2="802.79" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1493.57" x2="1772.75" y1="928.38" y2="831" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1493.57" x2="1772.75" y1="928.38" y2="831" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1503.37" x2="1782.55" y1="956.59" y2="859.21" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1362.47" x2="1824.94" y1="1142.55" y2="981.23" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1381.58" x2="1844.05" y1="1197.57" y2="1036.25" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1401.18" x2="1863.65" y1="1253.99" y2="1092.67" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1420.78" x2="1883.26" y1="1310.42" y2="1149.1" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="1440.39" x2="1902.86" y1="1366.84" y2="1205.52" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><polygon fill="#ffffff" points="3009.66 2091 2440.03 2289.7 2176.87 1532.19 2746.5 1333.49 3009.66 2091" class="colorfff svgShape"></polygon><polygon fill="#ffffff" points="2421.97 1687.1 2300.71 1729.39 2242.88 1562.94 2364.14 1520.64 2421.97 1687.1" class="colorfff svgShape"></polygon><polygon fill="var(--primary-bg-color)" points="2421.97 1687.1 2300.71 1729.39 2242.88 1562.94 2364.14 1520.64 2421.97 1687.1" opacity=".08" class="color1f60e5 svgShape"></polygon><g clip-path="url(#g)" fill="#000000" class="color000 svgShape"><polygon fill="#319bc1" points="2310.31 1638.47 2320.17 1690.5 2379.34 1665.75 2357.93 1621.86 2310.31 1638.47" opacity=".71" class="color003fc3 svgShape"></polygon><polygon fill="#ffffff" points="2363.61 1670.29 2334.81 1680.25 2333.05 1673.58 2329.46 1659.98 2325.67 1645.59 2347.51 1633.74 2353.88 1648.2 2360.03 1662.15 2363.61 1670.29" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M2436.38,1710.37l-133.73,46.27-12.38-43.41a29.61,29.61,0,0,1,10.2-31.65c.57-.45,1.16-.87,1.77-1.27l5-3.28,8.13-5.33,4.34-2.84,9.21-6,.34-.22.22.87,1.17,4.71,2.65-.28,19.84-2.14,7-.76-3.09-10.89-.74-2.63,1.69-.15,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0c9.6,1.34,16.67,8.22,21.94,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2436.38,1710.37l-133.73,46.27-12.38-43.41a29.61,29.61,0,0,1,10.2-31.65c.57-.45,1.16-.87,1.77-1.27l5-3.28,8.13-5.33,4.34-2.84,9.21-6,.34-.22.22.87,1.17,4.71,2.65-.28,19.84-2.14,7-.76-3.09-10.89-.74-2.63,1.69-.15,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0c9.6,1.34,16.67,8.22,21.94,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2356.07,1610a36.3,36.3,0,0,1,1,13.55h0c-.06.63-.11,1.26-.19,1.88-.42,3.83-2.39,7.11-3.85,10.7-.64,1.6-1.36,3.23-2.18,4.81-2.54,4.94-6,9.47-11.37,11.31-4.07,1.41-8.26,1-12.31-.48-5.9-2.06-11.52-6.16-16.12-9.48-1.33-1-2.52-1.85-3.61-2.72a21.6,21.6,0,0,1-7.26-10.12,35.92,35.92,0,0,1-1.76-6.89c-.72-4.47-.85-9.08-1.4-13.55q-1.12-9.3-2.26-18.62l33.19-23.66,12.88,17,9.19,15.13c.88,1.44,1.84,2.87,2.76,4.34A28.63,28.63,0,0,1,2356.07,1610Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2353,1645.71c-2.57,5.19-6.15,10-11.7,12-4.26,1.47-8.65.9-12.89-.68l-1.28-5.21c4,1.43,8.24,1.89,12.31.48,5.32-1.84,8.83-6.37,11.37-11.31Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2299.6 1621.56l-5.23 4.47a4.49 4.49 0 00-.8 5.85h0a15.26 15.26 0 009.09 6.52l6.46 1.61zM2362.72 1607.77a12.15 12.15 0 01-.36 8.25.31.31 0 01-.05.12 3.07 3.07 0 01-.16.31 15.27 15.27 0 01-1.12 1.75l-3.71 5-.27.37h0l-4.33-20.31h.14l6.44.11.12.06A7 7 0 012362.72 1607.77z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M2337.89 1584c-1.15-2.14-2-3.81-2.37-4.6zM2339.38 1586.73c-.26-.47-.51-.94-.76-1.38zM2345.38 1573c-.31-.45-.62-.89-1-1.33C2344.76 1572.09 2345.07 1572.53 2345.38 1573z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M2347 1598.78c-6-4-14.78-13.59-14.78-13.59-3.79 5-29.79 10.3-29.79 10.3a49.45 49.45 0 01-2 17c-.29-8.36-2.43-18.85-2.44-19.93 0-.19.29-.4.82-.62 4.79-2 29.18-5 36.52-13l.11.21c.29.61 1.2 2.44 2.5 4.87l.06.11A128.3 128.3 0 002347 1598.78zM2391.55 1691.69l-11.15 2.56 8.84 7.3-8.54 28.08L2370.53 1763l-26.13-20.85-23.67-18.88 3.28-19.9-9.06 3.13-9.56-27.76 1.85-1.75 8.13-5.33 4.34-2.84 9.21-6 .56.65 3.82 4.43 13.72 15.89 6.12-18 4-11.65.95-2.78 5.8-.52 6.29-.57 14.38-1.31a25.39 25.39 0 015.19.16l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2391.55,1691.69l-11.15,2.56,8.84,7.3-8.54,28.08L2370.53,1763l-26.13-20.85-23.67-18.88,3.28-19.9-9.06,3.13-9.56-27.76,1.85-1.75,8.13-5.33,4.34-2.84,9.21-6,.56.65,3.82,4.43,13.72,15.89,6.12-18,4-11.65.95-2.78,5.8-.52,6.29-.57,14.38-1.31a25.39,25.39,0,0,1,5.19.16l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M2356.17,1651.5l-1.38,2a20,20,0,0,1-22.4,8l-2.82-.86-.14,3.29,32.1,71.1,2.06-47.32Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2308.5 1563.21a45.53 45.53 0 01-7.68 3.54A43.3 43.3 0 012308.5 1563.21zM2335.06 1579.09l-.25.27c-4 3.91-12.12 6.61-19.72 8.56a153.46 153.46 0 0018.73-8.09A8 8 0 002335.06 1579.09z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#319bc1" d="M2349.75,1581.4c2.52,6.79,3.27,14,4.62,22.39.06.49.5,2.93-2.74.23-.43-.36-.88-.78-1.33-1.24s-.91-1-1.39-1.51c-.14-.17-.29-.37-.46-.55-.71-.88-1.43-1.82-2.16-2.85l-.6-.85c-.78-1.13-1.56-2.31-2.32-3.53a7.68,7.68,0,0,0-.45-.71l-.43-.71c-.15-.25-.32-.52-.48-.8l-.79-1.32c-.15-.24-.26-.47-.41-.7-.32-.59-.68-1.18-1-1.75l-.16-.29c-.09-.16-.17-.33-.27-.48-.26-.47-.51-.94-.76-1.38s-.46-.85-.67-1.27l-.06-.1-2.37-4.6-.07-.14-.07-.12-.1-.17,0,0-.2.19a8,8,0,0,1-1.24.74,153.46,153.46,0,0,1-18.73,8.09c-7.26,1.86-14.05,3.06-16.34,4l-.44.21c-.25.15-.37.28-.38.43a3.43,3.43,0,0,0,.06.59.37.37,0,0,0,0,.15.12.12,0,0,0,0,.1,1.53,1.53,0,0,0,0,.36c.06.29.1.6.16,1l0,.24a.59.59,0,0,1,0,.23c0,.21.08.4.12.63s0,.28.07.43.07.39.1.59c.09.68.23,1.43.35,2.26,0,.13,0,.29.07.44.12.74.22,1.51.33,2.31,0,.25.08.53.11.79.06.41.11.82.17,1.23,0,.2.05.39.08.59s.08.65.11,1c.07.59.14,1.2.19,1.82.11,1,.19,2,.25,2.93,0,.51.07,1,.09,1.49s0,1,0,1.45c0,.08,0,.18,0,.26,0,.61,0,1.19,0,1.77,0,.14,0,.29,0,.43a25.67,25.67,0,0,1-.34,3.43c-.6,3.25-1.58,2.79-1.4,4.08-3.17-7.7-5.7-11-8.76-18.76a53.73,53.73,0,0,1-3.48-11.63,22.84,22.84,0,0,1-.29-4.5c-7.09-6.81-2.39-18.87,7.54-19.84a32.52,32.52,0,0,0,7.17-1.6,45.53,45.53,0,0,0,7.68-3.54h0c.69-.38,1.4-.8,2.11-1.25a29.65,29.65,0,0,1,19.06-4.24A11.46,11.46,0,0,1,2340,1567a34.34,34.34,0,0,1,9.33,13.34c.09.18.15.36.23.54S2349.69,1581.22,2349.75,1581.4Z" opacity=".71" class="color003fc3 svgShape"></path><path fill="#319bc1" d="M2315.09 1587.92a100.76 100.76 0 01-12.63 3.61 28.85 28.85 0 01-4.15.58l.44-.21C2301 1591 2307.83 1589.78 2315.09 1587.92zM2335.26 1578.9l0 0a.64.64 0 01-.22.14z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M2335.38,1579.11h0l-.58.24c.16-.15.31-.31.46-.47Z" class="color2d1d2c svgShape"></path></g><line x1="2431.2" x2="2710.38" y1="1522.56" y2="1425.17" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2441" x2="2720.18" y1="1550.77" y2="1453.39" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2441" x2="2720.18" y1="1550.77" y2="1453.39" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2450.8" x2="2729.98" y1="1578.98" y2="1481.6" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2309.9" x2="2772.37" y1="1764.94" y2="1603.62" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2329.01" x2="2791.48" y1="1819.95" y2="1658.63" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2348.61" x2="2811.08" y1="1876.38" y2="1715.06" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2368.21" x2="2830.68" y1="1932.8" y2="1771.48" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2387.82" x2="2850.29" y1="1989.23" y2="1827.91" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line></g><path fill="#ffffff" d="M2734.26,1227.14,2171,1416.51,1919.78,666.88l370.28-124.47c19.93,14.32,40.17,28.19,60.89,41.3q8.28,5.24,16.68,10.31,16.83,10.18,34.06,19.61,17.89,9.86,36.2,18.9a987.09,987.09,0,0,0,113,47.44Z" class="colorfff svgShape"></path><rect width="126.5" height="173.72" x="2008.79" y="673.3" fill="#ffffff" transform="rotate(-18.58 2072.009 760.145)" class="colorfff svgShape"></rect><rect width="126.5" height="173.72" x="2008.79" y="673.3" fill="var(--primary-bg-color)" opacity=".08" transform="rotate(-18.58 2072.009 760.145)" class="color1f60e5 svgShape"></rect><g clip-path="url(#h)" fill="#000000" class="color000 svgShape"><polygon fill="#ffffff" points="2102.28 805.13 2073.8 814.62 2072.14 808.02 2068.75 794.58 2065.17 780.36 2086.81 768.92 2092.93 783.25 2098.84 797.07 2102.28 805.13" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M2173.54,845.46l-132.23,44.08-11.74-42.92A29.22,29.22,0,0,1,2040,815.53c.57-.43,1.15-.84,1.76-1.23l5-3.17,8.06-5.16,4.31-2.75,9.14-5.85.34-.21.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.94-.67L2096,789.11l-.71-2.6,1.66-.13,5.73-.45,6.2-.49,14.18-1.12a25.23,25.23,0,0,1,5.11.21l.21,0c9.44,1.43,16.34,8.29,21.42,17.58Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2173.54,845.46l-132.23,44.08-11.74-42.92A29.22,29.22,0,0,1,2040,815.53c.57-.43,1.15-.84,1.76-1.23l5-3.17,8.06-5.16,4.31-2.75,9.14-5.85.34-.21.2.86,1.1,4.66,2.62-.25,19.57-1.88,6.94-.67L2096,789.11l-.71-2.6,1.66-.13,5.73-.45,6.2-.49,14.18-1.12a25.23,25.23,0,0,1,5.11.21l.21,0c9.44,1.43,16.34,8.29,21.42,17.58Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2095.5,745.63a36,36,0,0,1,.82,13.37h0q-.09.94-.21,1.86c-.46,3.77-2.43,7-3.9,10.5-.66,1.57-1.38,3.17-2.2,4.72-2.56,4.84-6.07,9.27-11.32,11a18.15,18.15,0,0,1-12.13-.61c-5.79-2.11-11.29-6.21-15.78-9.54-1.3-1-2.46-1.84-3.53-2.72a21.41,21.41,0,0,1-7-10.06,34.72,34.72,0,0,1-1.66-6.81c-.66-4.41-.74-9-1.23-13.36-.67-6.13-1.36-12.26-2-18.38l32.95-22.94,12.5,16.93,8.9,15c.84,1.43,1.78,2.86,2.67,4.31A28.38,28.38,0,0,1,2095.5,745.63Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2092.12,780.79c-2.59,5.08-6.18,9.83-11.66,11.66-4.21,1.4-8.53.79-12.69-.82l-1.21-5.14a18.15,18.15,0,0,0,12.13.61c5.25-1.75,8.76-6.18,11.32-11Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2039.74 756.37l-5.2 4.35a4.44 4.44 0 00-.85 5.76h0a15 15 0 008.89 6.52l6.35 1.66zM2102.07 743.5a12 12 0 01-.43 8.13.39.39 0 01-.06.11 1.73 1.73 0 01-.16.3 14.09 14.09 0 01-1.12 1.72l-3.71 4.89-.27.35h0l-4.05-20.07h.14l6.34.18.11 0A6.92 6.92 0 012102.07 743.5z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M2077.86 719.77c-1.1-2.12-1.91-3.78-2.28-4.56zM2079.31 722.5c-.26-.47-.5-.93-.74-1.37C2078.81 721.57 2079.05 722 2079.31 722.5zM2085.36 709c-.3-.44-.6-.88-.93-1.32Q2084.93 708.35 2085.36 709z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M2086.63 734.46c-5.85-4.05-14.41-13.56-14.41-13.56-3.79 4.83-29.46 9.81-29.46 9.81a48.68 48.68 0 01-2.16 16.7c-.19-8.24-2.19-18.61-2.2-19.67 0-.19.29-.39.82-.6 4.74-1.88 28.81-4.62 36.12-12.41l.11.22c.28.6 1.16 2.41 2.41 4.82l.06.1A125.71 125.71 0 002086.63 734.46zM2129.58 826.54l-11 2.4 8.64 7.29-8.72 27.58-10.37 32.82-25.52-20.85-23.11-18.88 3.44-19.58-9 3-9.12-27.47 1.84-1.7 8.06-5.16 4.31-2.75 9.14-5.85.54.65 3.72 4.41 13.35 15.82 6.22-17.7 4-11.44.95-2.73 5.73-.45 6.2-.49 14.18-1.12a25.23 25.23 0 015.11.21l.21 0z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2129.58,826.54l-11,2.4,8.64,7.29-8.72,27.58-10.37,32.82-25.52-20.85-23.11-18.88,3.44-19.58-9,3-9.12-27.47,1.84-1.7,8.06-5.16,4.31-2.75,9.14-5.85.54.65,3.72,4.41,13.35,15.82,6.22-17.7,4-11.44.95-2.73,5.73-.45,6.2-.49,14.18-1.12a25.23,25.23,0,0,1,5.11.21l.21,0Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M2095.15,786.53l-1.38,2a19.64,19.64,0,0,1-22.15,7.64l-2.77-.87-.17,3.23L2099.54,869l2.54-46.61Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2089.57,717.37c2.42,6.71,3.07,13.85,4.31,22.12.07.48.47,2.88-2.69.19-.42-.36-.86-.78-1.3-1.24s-.89-1-1.34-1.5l-.45-.56c-.7-.87-1.4-1.82-2.1-2.81l-.58-.86c-.77-1.12-1.52-2.3-2.25-3.5l-.43-.7-.42-.71-.47-.79c-.26-.44-.51-.88-.76-1.32-.14-.23-.27-.46-.4-.69l-1-1.74-.16-.29c-.09-.16-.17-.32-.26-.47-.26-.47-.5-.93-.74-1.37s-.44-.85-.65-1.25l-.06-.11-2.28-4.56-.07-.14-.06-.12h0l-.11-.21-.46.46c-7.81,7.43-31,10.11-35.66,11.95-.53.21-.81.41-.82.6s0,.31.06.6a.78.78,0,0,0,0,.14s0,.06,0,.1,0,.23,0,.36.09.59.14.94a1.57,1.57,0,0,1,0,.23c0,.07,0,.15,0,.23s.06.4.09.62.05.28.07.43.06.38.09.57c.09.68.21,1.43.32,2.22,0,.15.05.31.07.46.1.73.2,1.49.31,2.28q0,.38.09.78l.15,1.22.06.57c0,.32.08.64.11,1,.06.6.12,1.2.17,1.8.09,1,.16,1.94.22,2.9,0,.49,0,1,.07,1.47s0,1,0,1.41v.28c0,.59,0,1.17,0,1.73,0,.14,0,.28,0,.42a23,23,0,0,1-.38,3.39c-.63,3.19-1.58,2.73-1.42,4-3-7.62-5.49-10.91-8.44-18.58a52.72,52.72,0,0,1-3.29-11.49,22.19,22.19,0,0,1-.23-4.51c.44-8,5.56-14.91,12.67-19.66a42.56,42.56,0,0,1,15.54-6.33h0a43.88,43.88,0,0,0,6.32-.7c15-2.79,17.14-12.53,17.14-12.53s11.38,13.51,5.9,23.64c.33.44.63.88.93,1.32s.58.88.85,1.33c.13.21.27.43.39.66s.26.44.38.66.25.44.36.67c.3.56.58,1.12.85,1.69.07.16.15.32.22.47s.23.5.33.75l.21.51.22.54c.07.18.13.36.21.54S2089.51,717.19,2089.57,717.37Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M2075.45,714.94h0l-.57.24.46-.46Z" class="color2d1d2c svgShape"></path></g><line x1="2367.63" x2="2170.44" y1="594.02" y2="660.29" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2401.69" x2="2179.79" y1="613.63" y2="688.21" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2401.69" x2="2179.79" y1="613.63" y2="688.21" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2437.89" x2="2189.17" y1="632.53" y2="716.13" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2048.36" x2="2505.69" y1="897.81" y2="744.08" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2066.6" x2="2523.93" y1="952.25" y2="798.52" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2085.31" x2="2542.64" y1="1008.08" y2="854.35" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2104.02" x2="2561.35" y1="1063.92" y2="910.19" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2122.72" x2="2580.06" y1="1119.76" y2="966.03" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><path fill="#ffffff" d="M2346.94,829.18a187,187,0,0,1-18.84,83.16c-.62,1.33-1.29,2.63-1.95,3.93-47.74,93-162.3,130-255.87,82.54-.14-.06-.26-.13-.39-.2-86.67-44.21-124.75-145.47-91.49-234.1a190.59,190.59,0,0,1,255-107.2c3.26,1.42,6.48,3,9.69,4.57a191.08,191.08,0,0,1,32.43,20.76A189.05,189.05,0,0,1,2346.94,829.18Z" opacity=".25" class="colorfff svgShape"></path><path fill="#ffffff" d="M2346.94,829.18a187,187,0,0,1-18.84,83.16c-.62,1.33-1.29,2.63-1.95,3.93-47.74,93-162.3,130-255.87,82.54-.14-.06-.26-.13-.39-.2-86.67-44.21-124.75-145.47-91.49-234.1a190.59,190.59,0,0,1,255-107.2c3.26,1.42,6.48,3,9.69,4.57a191.08,191.08,0,0,1,32.43,20.76A189.05,189.05,0,0,1,2346.94,829.18Z" class="colorfff svgShape"></path><path fill="#ffffff" d="M2173.63,838.86l-153,51.12L1978.4,764.51A189.36,189.36,0,0,1,2109,647.25Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2173.63,838.86l-44.55,14.88-30.2,10.11-14.74,4.93-38,12.69L2020.66,890l-13.2-39.19-29.06-86.28a191.19,191.19,0,0,1,8.86-20.09,189.46,189.46,0,0,1,53.82-64.26,190.36,190.36,0,0,1,68-32.91l62,183.87Z" opacity=".08" class="color1f60e5 svgShape"></path><polygon fill="#ffffff" points="2100.5 816.99 2064.17 829.03 2062.05 820.67 2057.73 803.62 2053.15 785.57 2080.77 771.07 2088.58 789.24 2096.11 806.77 2100.5 816.99" class="colorfff svgShape"></polygon><path fill="#ffffff" d="M2173.63,838.86l-44.55,14.88-30.2,10.11-14.74,4.93-38,12.69L2020.66,890l-13.2-39.19a36.43,36.43,0,0,1,13.54-20.6c.73-.55,1.47-1.08,2.25-1.56l6.31-4,10.31-6.55,5.48-3.49,11.66-7.42.44-.28.23,1,0,.14.41,1.71,1,4.2.83-.07.36,0,2.16-.21,25-2.39,7.32-.71,1.54-.14-2.36-8.69-1.36-5-.92-3.29,2.14-.16,7.3-.57L2109,792l18.09-1.44a34.86,34.86,0,0,1,6.52.27.86.86,0,0,0,.27,0c12,1.83,20.84,10.52,27.32,22.3l9.84,17.91Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2173.63,838.86l-44.55,14.88-30.2,10.11-14.74,4.93-38,12.69L2020.66,890l-13.2-39.19a36.43,36.43,0,0,1,13.54-20.6c.73-.55,1.47-1.08,2.25-1.56l6.31-4,10.31-6.55,5.48-3.49,11.66-7.42.44-.28.23,1,0,.14.41,1.71,1,4.2.83-.07.36,0,2.16-.21,25-2.39,7.32-.71,1.54-.14-2.36-8.69-1.36-5-.92-3.29,2.14-.16,7.3-.57L2109,792l18.09-1.44a34.86,34.86,0,0,1,6.52.27.86.86,0,0,0,.27,0c12,1.83,20.84,10.52,27.32,22.3l9.84,17.91Z" opacity=".47" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2091.85,741.52c1.58,5.39,1.59,11.35,1.05,17h0c-.09.8-.17,1.58-.27,2.35-.59,4.78-3.1,8.86-5,13.32-.83,2-1.75,4-2.8,6-3.27,6.14-7.75,11.75-14.45,14-5.14,1.71-10.39,1.07-15.47-.77-7.38-2.67-14.39-7.87-20.13-12.1-1.65-1.22-3.14-2.34-4.5-3.45a27.19,27.19,0,0,1-9-12.75,44.48,44.48,0,0,1-2.11-8.64c-.85-5.6-1-11.36-1.57-17q-1.29-11.66-2.59-23.31l42-29.1L2073,708.52l11.35,19c1.08,1.81,2.27,3.62,3.41,5.47A35.81,35.81,0,0,1,2091.85,741.52Z" class="colorfff svgShape"></path><path fill="var(--primary-bg-color)" d="M2087.53,786.12c-3.3,6.45-7.87,12.47-14.87,14.79-5.37,1.78-10.88,1-16.18-1l-1.55-6.52c5.08,1.84,10.33,2.48,15.47.77,6.7-2.22,11.18-7.83,14.45-14Z" opacity=".11" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2020.72 755.15l-6.63 5.51A5.6 5.6 0 002013 768h0a19.17 19.17 0 0011.34 8.28l8.1 2.1zM2100.23 738.82a15.15 15.15 0 01-.55 10.32.61.61 0 01-.07.14c-.06.13-.13.25-.2.38a20 20 0 01-1.44 2.18l-4.73 6.2-.34.45h0L2087.72 733h.19l8.09.22a.61.61 0 01.14.07A8.79 8.79 0 012100.23 738.82z" class="colorfff svgShape"></path><path fill="#2d1d2c" d="M2069.35 708.72c-1.41-2.68-2.44-4.79-2.91-5.78zM2071.2 712.18c-.33-.59-.65-1.18-.94-1.73C2070.56 711 2070.87 711.59 2071.2 712.18zM2078.91 695.08c-.38-.56-.77-1.12-1.18-1.68C2078.15 694 2078.54 694.52 2078.91 695.08z" class="color2d1d2c svgShape"></path><path fill="#ffffff" d="M2080.54 727.35c-7.46-5.13-18.39-17.2-18.39-17.2-4.83 6.13-37.58 12.46-37.58 12.46.57 7.51-1 15.29-2.76 21.18-.24-10.46-2.79-23.61-2.8-24.95 0-.25.37-.5 1-.77 6-2.38 36.74-5.86 46.07-15.74l.14.27c.36.77 1.48 3.06 3.08 6.12l.07.14A159.7 159.7 0 002080.54 727.35zM2121.28 847.19l7.8 6.55-30.2 10.11-14.74 4.93-38 12.69 4.18-23.65-11.43 3.79-11.64-34.85 2.34-2.14 10.31-6.55 5.48-3.49 11.66-7.42.64.77 0 .05 1.61 1.89 3.14 3.7 10.63 12.53 6.4 7.53 3.86-11 4.06-11.5 4.8-13.51 0-.07.32-.94 1.22-3.45 7.3-.57L2109 792l18.09-1.44a34.86 34.86 0 016.52.27.86.86 0 00.27 0l1.47 53.24z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2121.28,847.19l7.8,6.55-30.2,10.11-14.74,4.93-38,12.69,4.18-23.65-11.43,3.79-11.64-34.85,2.34-2.14,10.31-6.55,5.48-3.49,11.66-7.42.64.77,0,.05,1.61,1.89,3.14,3.7,10.63,12.53,6.4,7.53,3.86-11,4.06-11.5,4.8-13.51,0-.07.32-.94,1.22-3.45,7.3-.57L2109,792l18.09-1.44a34.86,34.86,0,0,1,6.52.27.86.86,0,0,0,.27,0l1.47,53.24Z" opacity=".5" class="color003fc3 svgShape"></path><path fill="#ffffff" d="M2100.25,838.86l-1.37,25-14.74,4.93-17.83-40.44-5.49-12.49-.89-2-1.82-4.13-.48-1.07,0-.69,0-.09.16-3.33.11,0,3.44,1.07a25.12,25.12,0,0,0,28.26-9.7l1.1-1.6.64-.93.83,4.2.05.22,2.45,12.65,1.54,7.94Z" class="colorfff svgShape"></path><path fill="#319bc1" d="M2089.24,735.54a1.65,1.65,0,0,1-1.06-.27,11,11,0,0,1-1.81-1.3c-.55-.46-1.1-1-1.68-1.57s-1.15-1.21-1.72-1.9c-.18-.23-.37-.45-.57-.71-.62-.75-1.22-1.57-1.86-2.44l-.81-1.12-.75-1.09c-1-1.44-1.93-2.92-2.85-4.43-.18-.32-.37-.62-.55-.91l-.55-.89-.6-1c-.32-.54-.64-1.11-1-1.66-.19-.3-.35-.6-.51-.89-.41-.73-.82-1.49-1.24-2.19a1.65,1.65,0,0,0-.2-.37c-.12-.2-.21-.41-.32-.61-.33-.6-.65-1.17-.95-1.74s-.57-1.07-.82-1.57l-.07-.14-.51-1-2.2-4.38-.21-.41v0l-.09-.18-.07-.14h0v0l-.14-.25a7.66,7.66,0,0,1-.57.57,15.16,15.16,0,0,1-2.16,1.73,9.42,9.42,0,0,1-1,.64,31.56,31.56,0,0,1-4.29,2.33c-.49.23-1,.46-1.5.66-.78.35-1.6.67-2.43,1-.48.19-.94.37-1.42.53-1.22.43-2.48.84-3.74,1.23-.6.18-1.2.37-1.79.53-1.79.54-3.61,1-5.4,1.46-.59.16-1.19.29-1.79.43s-1.51.37-2.27.55c-1,.23-2,.46-3,.66-6.77,1.48-12.51,2.53-14.78,3.42a3.77,3.77,0,0,0-.76.39.53.53,0,0,0-.21.21.28.28,0,0,0-.09.18,2.35,2.35,0,0,1,0,.39c0,.11,0,.23,0,.36a.47.47,0,0,0,0,.19v.11c0,.14,0,.3.07.46s.07.36.09.57.07.41.09.64a2.56,2.56,0,0,0,.05.27,1.45,1.45,0,0,1,0,.3c0,.25.09.52.12.79s.07.35.09.55.07.46.11.71c.09.62.19,1.28.3,2,.05.27.07.54.12.84a3.75,3.75,0,0,0,.09.57c.11.94.25,1.89.39,2.9,0,.32.07.64.11,1,.07.5.14,1,.19,1.55,0,.23.07.41.09.64v.09c0,.39.09.82.14,1.23.06.76.16,1.51.2,2.29,0,.16,0,.29,0,.45.09,1,.16,2.06.2,3.06a.32.32,0,0,1,0,.16c0,.62.07,1.26.09,1.87,0,.32,0,.66,0,1a7.22,7.22,0,0,1,0,.8v.34c0,.76,0,1.49,0,2.22a4.52,4.52,0,0,1,0,.52,29.36,29.36,0,0,1-.48,4.32,9.29,9.29,0,0,1-1.68,4.08,1.38,1.38,0,0,0-.11,1,5.64,5.64,0,0,1-.25-.64l-.07-.14c-3.72-9.1-6.8-13.32-10.47-22.79a66.5,66.5,0,0,1-4.2-14.56c-.09-.6-.14-1.19-.18-1.76a186.56,186.56,0,0,1,36.74-37,55.53,55.53,0,0,0,7.26-.85c19.09-3.53,21.87-15.88,21.87-15.88s14.5,17.12,7.53,30c.41.57.8,1.12,1.17,1.69s.73,1.12,1.08,1.67l.5.84a7.3,7.3,0,0,1,.48.85c.16.27.32.57.48.84.37.71.74,1.42,1.06,2.15a5.73,5.73,0,0,1,.3.61c.14.3.27.62.41.94l.28.64.27.68c.1.25.19.46.26.69s.18.45.25.68c3,8.33,3.88,17.19,5.41,27.41,0,.21.07.43.1.66S2090.06,735.45,2089.24,735.54Z" opacity=".63" class="color003fc3 svgShape"></path><path fill="#2d1d2c" d="M2066.27,702.6v0l-.72.29.58-.58Z" class="color2d1d2c svgShape"></path><polygon fill="none" points="2173.61 838.85 2020.65 889.98 1950.24 681.05 2103.21 629.92 2173.61 838.85"></polygon><line x1="2233.44" x2="2199.38" y1="657.31" y2="668.7" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2233.44" x2="2199.38" y1="657.31" y2="668.7" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2275.56" x2="2211.34" y1="682.64" y2="704.1" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2346.94" x2="2031.7" y1="829.18" y2="934.55" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><line x1="2328.1" x2="2069.89" y1="912.34" y2="998.61" fill="none" stroke="#289dca" stroke-miterlimit="10" stroke-width="2" class="colorStroke1f60e5 svgStroke"></line><path fill="var(--primary-bg-color)" d="M1279.67 888c-28.93-63.38-90.53-52.65-114.68 10-26.44 68.55 1.66 131.17-45.52 199.31-41.48 59.9-96.18 110.29-154.69 153.23-12.44 9.13-25.65 18.41-32.76 32.13-35.48 68.53 70 27.44 95.51 12.63 119.81-69.57 215.6-173.46 253.65-307.56C1290.45 955 1293.77 918.86 1279.67 888zM2670.75 614.09c45.21 4 118.35-4.3 149.72-42.25 48-58-32.88-62.13-74.62-55.54A409.92 409.92 0 012575.66 507c-25.56-6.91-90.18-44.22-115.24-38.74-32.65 7.15-16.6 39-4.81 54C2494.06 571.33 2611.47 608.86 2670.75 614.09z" class="color1f60e5 svgShape"></path><path fill="#ffffff" d="M2256.78,639.72C2151.45,583.53,2021,624.56,1966.58,730c-53.65,103.91-12.82,233,90.83,287.13a212.14,212.14,0,0,0,97.32,24.27l43.72,345.21a16.51,16.51,0,0,0,19.53,14.1l.33-.07a16.44,16.44,0,0,0,13.13-18.21L2188.21,1039a213.12,213.12,0,0,0,159-115.68C2398.55,820.46,2358.23,693.87,2256.78,639.72ZM2327,915.1c-48.11,94.33-163.57,131.79-257.9,83.68s-131.8-163.59-83.69-257.92S2149,609.07,2243.33,657.2,2375.13,820.77,2327,915.1Z" class="colorfff svgShape"></path><path fill="#ff9541" d="M2256.78,639.72C2151.45,583.53,2021,624.56,1966.58,730c-53.65,103.91-12.82,233,90.83,287.13a212.14,212.14,0,0,0,97.32,24.27l43.72,345.21a16.51,16.51,0,0,0,19.53,14.1l.33-.07a16.44,16.44,0,0,0,13.13-18.21L2188.21,1039a213.12,213.12,0,0,0,159-115.68C2398.55,820.46,2358.23,693.87,2256.78,639.72ZM2327,915.1c-48.11,94.33-163.57,131.79-257.9,83.68s-131.8-163.59-83.69-257.92S2149,609.07,2243.33,657.2,2375.13,820.77,2327,915.1Z" class="colorfe7101 svgShape"></path><path fill="url(#i)" d="M1993.38,816.06a156.57,156.57,0,0,1,41.73-90c17.34-18.39,48.07-4.21,45.23,20.9-.06.59-.13,1.19-.19,1.79-8.58,84.5,52.49,161.22,136.76,171.81a156.39,156.39,0,0,0,67.77-6.28,157.23,157.23,0,0,1-291.3-98.21Z" opacity=".52"></path><circle cx="1462.07" cy="618.19" r="141.1" fill="#ffffff" opacity=".91" class="colorfff svgShape"></circle><circle cx="2958.38" cy="2223.63" r="133.44" fill="#ffffff" opacity=".91" class="colorfff svgShape"></circle><circle cx="2139.37" cy="1521.59" r="29.94" fill="#ffffff" opacity=".65" transform="rotate(-75.79 2139.435 1521.59)" class="colorfff svgShape"></circle><circle cx="3705.17" cy="1071.8" r="19.59" fill="#ffffff" transform="rotate(-80.78 3705.295 1071.748)" class="colorfff svgShape"></circle><circle cx="1102.25" cy="1676.52" r="9.79" fill="#ffffff" opacity=".79" class="colorfff svgShape"></circle><circle cx="1219.13" cy="1553.23" r="91.36" fill="#ffffff" opacity=".53" transform="rotate(-45 1219.125 1553.222)" class="colorfff svgShape"></circle><circle cx="977.2" cy="1840.91" r="39.17" fill="#ffffff" opacity=".91" class="colorfff svgShape"></circle><path fill="#ffffff" d="M790.39,1908.58a9.79,9.79,0,1,1-9.79,9.79A9.79,9.79,0,0,1,790.39,1908.58Z" opacity=".79" class="colorfff svgShape"></path><path fill="#ffcdcd" d="M3415.58,841.56c-43.26,68.57-116,113.65-180.58,142.11a695.49,695.49,0,0,1-103.32,35.8A34.33,34.33,0,0,1,3091,998.61l-36.53-95a34.3,34.3,0,0,0-32-22,34.29,34.29,0,0,1-33.38-42.1L3009.59,752a34.2,34.2,0,0,0-3.41-24.47l-22.64-40.76a34.29,34.29,0,0,1-4.32-16.65V579.75a34.28,34.28,0,0,1,45.6-32.37c32.83,11.48,80.17,28.92,130.86,50.49C3299.61,659.18,3470.79,754,3415.58,841.56Z" class="colorf8bbc2 svgShape"></path><path fill="#ffcdcd" d="M3456.77,1040.82s-269.39,113.54-231.54,91.28c26.2-15.41,16.12-98,7.46-147.41-.11-.62-.23-1.25-.34-1.87-1.67-9.35-3.27-17.43-4.52-23.51-1.55-7.55-2.6-12-2.6-12s9.57-10.26,24.22-25.38c2.41-2.49,5-5.14,7.66-7.88,8.08-8.24,17.25-17.48,26.92-27,4.23-4.18,8.57-8.43,13-12.66,12.24-11.85,24.91-23.69,37-34.31.44-.4.87-.78,1.31-1.16,36.07-31.57,66.37-51.76,63.56-27.4-1.4,12.08.31,29.14,3.9,48.53q.43,2.4.93,4.83c.09.42.18.87.27,1.31,1.63,8.24,3.56,16.84,5.72,25.61,1.6,6.54,3.34,13.2,5.17,19.88,0,0,0,.09,0,.13,7.21,26.69,15.76,53.7,23.22,76.05C3448.46,1018.78,3456.77,1040.82,3456.77,1040.82Z" class="colorf8bbc2 svgShape"></path><path fill="#319bc1" d="M3492.39,1087.57l-307.23,113.54v-72.69a34.35,34.35,0,0,1,16.85-29.54c42.48-25.14,154.66-86,219.67-121,3.9-2.14,7.64-4.14,11.18-6.06q2.57-1.37,5-2.67A26.17,26.17,0,0,1,3476.05,988Z" class="color003fc3 svgShape"></path><path fill="#0063b1" d="M3492.39,1087.57l-307.23,113.54v-72.69a34.35,34.35,0,0,1,16.85-29.54c42.48-25.14,154.66-86,219.67-121,3.9-2.14,7.64-4.14,11.18-6.06q2.57-1.37,5-2.67A26.17,26.17,0,0,1,3476.05,988Z" opacity=".55" class="color04137a svgShape"></path><path fill="#319bc1" d="M3888.2,2312.87q-.43,24.68-1.62,48.29c-113.48,138.56-302.31,201.68-482.49,202.06h-1.85c-4.61,0-9.24,0-13.84-.11-.58,0-1.14,0-1.7,0-3.6-.06-7.19-.13-10.79-.24-3.86-.11-7.68-.25-11.51-.4-.34,0-.67,0-1-.05-2.6-.11-5.18-.22-7.77-.35s-5.16-.27-7.74-.43-5.17-.31-7.75-.46c-4.5-.29-9-.63-13.45-1-1.85-.14-3.67-.29-5.5-.45-1.42-.11-2.85-.24-4.27-.38-2.58-.22-5.17-.46-7.73-.71q-11.58-1.1-23.15-2.47c-2.56-.29-5.12-.6-7.7-.93-4-.49-8-1-12.07-1.56l-5.88-.8c-2.91-.43-5.81-.83-8.72-1.27-2.5-.36-5-.74-7.46-1.14-1.43-.2-2.85-.42-4.28-.67-2.45-.38-4.9-.78-7.34-1.18l-.63-.09c-2.45-.4-4.92-.82-7.37-1.24-1.35-.23-2.71-.45-4-.69l-6.17-1.09c-1.69-.29-3.38-.6-5.07-.92-2.56-.46-5.1-.93-7.66-1.42q-20.37-3.84-40.65-8.26l-6-1.34q-22.35-4.93-44.62-10.53l-14.43-3.67c-7.34-1.92-14.71-3.85-22.06-5.86-1.45-.37-2.89-.77-4.36-1.18s-3-.8-4.48-1.22c-2.51-.69-5-1.38-7.54-2.09q-21.15-5.88-42.22-12.18-11-3.24-21.88-6.59-20.48-6.28-40.85-12.78c-2.5-.78-5-1.58-7.46-2.38-5.7-1.83-11.38-3.65-17.08-5.5l-2.87-.94-9.84-3.2,46.11-213.91,69.7-323.5,33.84-157-27.2,23.42v0l-1.43,1.23L2789.81,2008a59.24,59.24,0,0,1-65.15,8.1l-14.42-7.21a59.49,59.49,0,0,1-21.09-17.68l-.84-1.13L2253,1403.44a33.28,33.28,0,0,1,2-42.1,32.68,32.68,0,0,1,9-7l102.12-55a58,58,0,0,1,68.17,9.69l34.46,33.84L2764.38,1633,2921,1416.51l84.49-116.82a103.86,103.86,0,0,1,34.13-30.14c26.11-14.43,74.54-43,120-70.24,13.54-8.08,26.81-16,39.18-23.49,38.92-23.4,68.71-41.5,68.71-41.5l242.33-47.64,56.2-11,4.56-.89a118.74,118.74,0,0,1,124.81,55.76l10.59,17.84c29.44,49.47,38.79,106.26,50,162.72,5.28,26.45,12.38,61.11,20.53,102C3819.77,1629.92,3893.08,2023.4,3888.2,2312.87Z" class="color003fc3 svgShape"></path><path fill="#ffcdcd" d="M2387.24,1292.72a57.58,57.58,0,0,0-21.17,6.59l-102.12,55a32.68,32.68,0,0,0-9,7c-14.05-6.46-30.48-11.49-47.18-15.43a515.76,515.76,0,0,0-51.52-9.1,55.85,55.85,0,0,1-48.66-55.42v-64.83a61.87,61.87,0,0,1,7.25-29.07l13.43-25.14a39.55,39.55,0,0,1,45.53-19.46l25.07,7,9.79-14.3a35.34,35.34,0,0,1,7.19-7.72,36.8,36.8,0,0,1,3.34-2.32,34.93,34.93,0,0,1,37.18.34l16.94,10.86a196.24,196.24,0,0,1,65.32,69.31l35.65,63.56,8,14.2Z" class="colorf8bbc2 svgShape"></path><path fill="#161c1d" d="M3488,748.1c-12.11,34.17-26.56,71.73-40.43,99.58-13.25,26.67-26,44.46-35.56,41.9-.91-.24-1.91-.49-3-.73-30.52-7-130.11-16.32-171.89-20.06a25.45,25.45,0,0,1-22.69-20.1l-1.83-8.67-4-18.83a42,42,0,0,1,3.59-27.65,41.12,41.12,0,0,1,8.52-11.53c9.91-9.46,23.67-32.33,27.92-53.41a60.08,60.08,0,0,0,1.34-12.34c0-13.55-5.82-24.91-21.62-29a22.18,22.18,0,0,0-10.71-.24c-5.17,1.13-9.75,4.09-13.8,7.92-.69.62-1.36,1.29-2,2a101.81,101.81,0,0,0-11.64,15.7c-9.24,14.67-13.63,24.2-28.74,26.14a46.62,46.62,0,0,1-4.79.33,22.25,22.25,0,0,1-3.58-5.48c2.76-11,5.85-23,7.86-34.95.6-3.59,1.11-7.17,1.46-10.71,2.36-22.57-.71-44-18.85-57.48-.49-.38-1-.74-1.49-1.07s-1.1-.76-1.65-1.11-1.4-.87-2.14-1.3-1.47-.82-2.23-1.22-1.55-.8-2.35-1.18-1.65-.74-2.5-1.09-1.71-.69-2.58-1q-.93-.36-1.89-.66c-1.18-.43-2.43-.83-3.7-1.21-34.75-10.26-71.8,3-107.11-9.59a59,59,0,0,1-10.55-5c-1.69-1-3.32-2.12-4.92-3.3a75.91,75.91,0,0,1-9.15-8,105.38,105.38,0,0,1-12.09-14.91c-.8-1.18-1.6-2.41-2.36-3.63a156.75,156.75,0,0,1-8.19-14.63c-3-6.1-5.79-12.51-8.33-19.08a350.33,350.33,0,0,1-13.91-46.89,73.86,73.86,0,0,1,48.73-86.73l201-66.39A209.8,209.8,0,0,1,3377,366.15l21.24,13.92a209.79,209.79,0,0,1,91,136l11.6,60.64A328.5,328.5,0,0,1,3488,748.1Z" class="color512d50 svgShape"></path><path fill="#161c1d" d="M3156.68,739c-.24,0-.49,0-.73,0a3.71,3.71,0,0,1-2.88-.78c-.82-.89-.57-2.31-.29-3.49.12-.4.21-.8.32-1.23A22.25,22.25,0,0,0,3156.68,739Z" class="color512d50 svgShape"></path><path fill="#e68888" d="M3161,698.61c-1-22.89-14.25-45.4-34.78-55.88-16-8.15-34.44-9.26-52.3-10.84-29.09-2.56-74.31-10.53-94.66-37.43V579.77c9.89,14.58,22,25.93,36.71,31.19,35.31,12.56,72.36-.67,107.11,9.59C3163.76,632.55,3166.54,665.44,3161,698.61Z" opacity=".3" class="colore8635d svgShape"></path><path fill="#e68888" d="M3225.08,708.9a37.21,37.21,0,0,1,4.5,15.58c.14,1.31.17,2.6.21,3.89s.09,2.55,0,3.88a36.82,36.82,0,0,1-1.05,7.68,34.68,34.68,0,0,1-6.62,13.3,31.52,31.52,0,0,1-11.66,8.94,41,41,0,0,0,9.59-10.47,36.77,36.77,0,0,0,3.21-6.24,40.15,40.15,0,0,0,2.91-13.88c.06-2.43,0-5,0-7.49A93.25,93.25,0,0,0,3225.08,708.9Z" opacity=".67" class="colore8635d svgShape"></path><path fill="#e68888" d="M3220.5,752.29a40.58,40.58,0,0,1-21.07-20,38.65,38.65,0,0,0,21.8,16.72,2.11,2.11,0,0,1,1.58,2.18,1.52,1.52,0,0,1-2,1.16l-.23-.08Z" opacity=".67" class="colore8635d svgShape"></path><path fill="#e68888" d="M3250 716.26a58.24 58.24 0 01-3.61-8.28c-5.52-15.16-28.12-14.11-44.53-11.11 7-7.37 15.72-12.49 26.52-9.66C3244.17 691.35 3249.94 702.71 3250 716.26zM3194.19 797.84a18.88 18.88 0 0111.74-4.68zM3212.43 790.58a23.53 23.53 0 00-2.07 2.69 24.41 24.41 0 00-4.43-.11zM3414.87 911.67A94.21 94.21 0 003383 897.4a110.89 110.89 0 00-11.44-2c-12.8-1.65-25.87-1.45-38.8-2.23-15.61-.95-31.08-3.36-46.53-5.76L3284 887c-10.85-1.69-21.64-3.38-32.46-5-8.75-1.36-17.86-2.87-25.14-7.92-12.29-8.55-16.14-24.72-19-39.41-2.72-13.94-4.85-29.94 2.92-41.39.62.07 1.22.16 1.85.27a42 42 0 00-3.59 27.65l5.79 27.5a25.45 25.45 0 0022.69 20.1c41.78 3.74 141.37 13.09 171.89 20.06C3410.79 896.35 3412.77 904 3414.87 911.67z" opacity=".3" class="colore8635d svgShape"></path><path fill="#f17684" d="M3414.91,911.8c-7.52,9.89-32.35,12.27-42.39,12.6-56.48,1.92-95,34.09-140.17,58.42a262,262,0,0,1-33.75,15.56,690.4,690.4,0,0,1-66.92,21.09,34.48,34.48,0,0,1-13.25.8c3.92-6.19,12.29-12,16.23-14.9A315.07,315.07,0,0,1,3197,970c9.19-3.9,21.06-6.17,30.85-10.69,6-2.76,11.18-6.34,14.59-11.64a43.67,43.67,0,0,0,7-25.74,36.58,36.58,0,0,0-1.78-9.24c-6.26-18.63-17.25-24.58-29.85-38.85-8.09-9.15-18.66-24.22-5.24-33.82l1.83,8.67a25.45,25.45,0,0,0,22.69,20.1c20,1.76,39.94,3.58,59.91,5.59s40.11,4.2,60.13,6.63c13.47,1.65,40.47.89,52.56,10.78,1.6,6.54,3.34,13.2,5.17,19.88C3414.89,911.71,3414.89,911.76,3414.91,911.8Z" opacity=".18" class="colorfe8796 svgShape"></path><path fill="#f17684" d="M3238,971.13c0,.2-.07.43-.12.63l-.06.33A6,6,0,0,1,3238,971.13Z" opacity=".18" class="colorfe8796 svgShape"></path><path fill="#f17684" d="M3238 971.13c0 .2-.07.43-.12.63l-.06.33A6 6 0 013238 971.13zM3156.68 739a46.62 46.62 0 004.79-.33c-.94 1.93-1.72 2.93-2.25 2.58A14.91 14.91 0 013156.68 739zM3161 698.61c-2 11.93-5.1 23.91-7.86 34.95-1.34-2.6-2.36-5.41-3.59-8-10.88-23.8-36.6-36.49-60.44-47.36a135.5 135.5 0 00-21.87-7.35c-13.69-3.58-27.42-6.32-39.91-13.62a118.76 118.76 0 01-46.4-50.14c-.56-1.15-1.13-2.33-1.67-3.51V579.77c9.89 14.58 22 25.93 36.71 31.19 35.31 12.56 72.36-.67 107.11 9.59C3163.76 632.55 3166.54 665.44 3161 698.61z" opacity=".18" class="colorfe8796 svgShape"></path><path fill="#020e49" d="M3168,661a108.8,108.8,0,0,1-5.57,26.94c3.08-29.32-3.05-56.64-39.38-67.35-34.75-10.26-71.8,3-107.11-9.59-14.71-5.26-26.82-16.61-36.71-31.19v0c-.8-1.18-1.6-2.41-2.36-3.63,13.14-1,30.72,14.31,42,17.7,18.77,5.61,38.81,6.3,58.18,4.36,20.41-2.07,42.09-6.79,60.66,2C3159.49,610.4,3169.66,636.94,3168,661Z" opacity=".71" class="color020e49 svgShape"></path><path fill="#020e49" d="M3217.66 687c-5.17 1.13-9.75 4.09-13.8 7.92-.69.62-1.36 1.29-2 2a101.81 101.81 0 00-11.64 15.7c-9.24 14.67-13.63 24.2-28.74 26.14a46.62 46.62 0 01-4.79.33 22.25 22.25 0 01-3.58-5.48c2.76-11 5.85-23 7.86-34.95.6-3.59 1.11-7.17 1.46-10.71 2.36-22.57-.71-44-18.85-57.48-.49-.38-1-.74-1.49-1.07s-1.1-.76-1.65-1.11a24.38 24.38 0 00-2.14-1.3c-.71-.44-1.47-.84-2.23-1.22s-1.55-.8-2.35-1.18-1.63-.74-2.5-1.09-1.69-.71-2.58-1q-.93-.36-1.89-.66c-1.18-.43-2.43-.83-3.7-1.21-34.75-10.26-71.8 3-107.11-9.59a59 59 0 01-10.55-5c-1.69-1-3.32-2.12-4.92-3.3a75.91 75.91 0 01-9.15-8 105.38 105.38 0 01-12.09-14.91c-.8-1.18-1.6-2.41-2.36-3.63a156.75 156.75 0 01-8.19-14.63c-3-6.1-5.79-12.51-8.33-19.08.83.69 1.67 1.49 2.54 2.34 14.76 14.6 29.59 25.4 50 31 23.73 6.52 48.78 6 73.31 4.21 27.3-2 56.55-5.26 80.44 8.15a76.15 76.15 0 0123.51 21.24C3208.49 634.11 3201.63 662.68 3217.66 687zM3447.11 847.92c-3.57 9.64-20.06 45.7-35.12 41.66-.91-.24-1.91-.49-3-.73-30.52-7-130.11-16.32-171.89-20.06a25.45 25.45 0 01-22.69-20.1l-1.83-8.67-4-18.83a42 42 0 013.59-27.65 41.12 41.12 0 018.52-11.53c9.91-9.46 23.67-32.33 27.92-53.41a44.69 44.69 0 011.74 5c2.87 10.05.23 17.78.17 27.47-.19 35.76 32.71 63.71 61.9 77.51a167.19 167.19 0 0056.95 15.35c14.1 1.22 31.84 1.51 45.72-1.37C3425.65 850.34 3436.16 843.6 3447.11 847.92z" opacity=".32" class="color020e49 svgShape"></path><path fill="#e68888" d="M2387.24,1292.72a57.58,57.58,0,0,0-21.17,6.59l-102.12,55a32.68,32.68,0,0,0-9,7c-14.05-6.46-30.48-11.49-47.18-15.43,5.7-1.45,11.73-2,17.86-3.16,36.22-6.83,70.68-20.48,104.28-35.29,17.52-7.7,34.84-15.8,52.34-23.62Z" opacity=".3" class="colore8635d svgShape"></path><path fill="#f17684" d="M2387.24 1292.72a57.58 57.58 0 00-21.17 6.59l-102.12 55a32.68 32.68 0 00-9 7c-14.05-6.46-30.48-11.49-47.18-15.43a515.76 515.76 0 00-51.52-9.1 55.34 55.34 0 01-32.81-16.41c17.12 5.36 34.75 9.88 52.56 8.57 12.4-.91 24.38-4.65 36.22-8.44q48.69-15.52 96.85-32.61c16.83-6 33.79-12.18 51.49-15.17 4.37-.73 9.24-2.24 13.72-3.11l8 14.2zM2226.59 1157.48c-4.45 5.74-10.91 9.59-17.48 12.73-7.45 3.58-15.89 6.48-23.88 4.36-11.25-3-16.26-13.91-25.41-19.83-5.23-3.39-9.84-5.77-12.37-10a39.47 39.47 0 0126.38-1.81l25.07 7 9.79-14.3a34.67 34.67 0 0110.53-10c4.88 2.74 9.22 6.33 11.27 11.42C2233.23 1143.74 2231.07 1151.73 2226.59 1157.48z" opacity=".18" class="colorfe8796 svgShape"></path><path fill="#e68888" d="M2200.37,1158.54c-6.53,3.61-15,3.88-21.27-.17-4.67-3-7.72-8.09-12.17-11.42-2.65-2-5.75-3.37-8.44-5.24a39.68,39.68,0,0,1,15.34,1.18l25.07,7,9.79-14.3a35.34,35.34,0,0,1,7.19-7.72C2218,1138.37,2208.11,1154.27,2200.37,1158.54Z" opacity=".3" class="colore8635d svgShape"></path><path fill="#006096" d="M2921,1416.51,2794.31,1670a38,38,0,0,1-63.73,6.74c-69.28-86.8-215.38-270.48-261.88-333.87L2764.38,1633Z" opacity=".18" class="color03157a svgShape"></path><path fill="#006096" d="M3206.74,1539.58a3.51,3.51,0,0,1,6.28,3l-285,927h0a3.51,3.51,0,0,1-2.37-3.92l35.77-214.13,101.34-470.26a3.51,3.51,0,0,0-5.72-3.4l0,0a3.51,3.51,0,0,1-5.21-4.6Z" opacity=".3" class="color03157a svgShape"></path><path fill="#006096" d="M3888.11 2317.6q-.43 21.65-1.47 42.44a3.46 3.46 0 01-.77 2c-113.56 138-302 200.81-481.78 201.19h-1.85c-4.61 0-9.24 0-13.84-.11-.58 0-1.14 0-1.7 0-3.6-.06-7.19-.13-10.79-.24-3.86-.11-7.68-.25-11.51-.4-.34 0-.67 0-1-.05-2.6-.11-5.18-.22-7.77-.35s-5.16-.27-7.74-.43-5.17-.31-7.75-.46c-4.5-.29-9-.63-13.45-1-1.85-.14-3.67-.29-5.5-.45-1.42-.11-2.85-.24-4.27-.38-2.58-.22-5.17-.46-7.73-.71q-11.58-1.1-23.15-2.47c-2.56-.29-5.12-.6-7.7-.93-4-.49-8-1-12.07-1.56l-5.88-.8c-2.91-.43-5.81-.83-8.72-1.27-2.5-.36-5-.74-7.46-1.14-1.43-.2-2.85-.42-4.28-.67-2.45-.38-4.9-.78-7.34-1.18l-.63-.09c-2.45-.4-4.92-.82-7.37-1.24-1.35-.23-2.71-.45-4-.69l-6.17-1.09c-1.69-.29-3.38-.6-5.07-.92-2.56-.46-5.1-.93-7.66-1.42q-20.37-3.84-40.65-8.26l-6-1.34q-22.35-4.93-44.62-10.53l-14.43-3.67c-7.34-1.92-14.71-3.85-22.06-5.86-1.45-.37-2.89-.77-4.36-1.18s-3-.8-4.48-1.22c-2.51-.69-5-1.38-7.54-2.09q-21.15-5.88-42.22-12.18-11-3.24-21.88-6.59-20.48-6.28-40.85-12.78c-2.5-.78-5-1.58-7.46-2.38-5.7-1.83-11.38-3.65-17.08-5.5-3.66-6.38-6.23-10.84-9.89-17.21l43.29-200.84L3031 1928.4a4.34 4.34 0 01.24-.72c95.14-203.71 177.34-379.85 181.56-388.92 17.61-37.72 51.28-64.3 77.59-94.76 9.42-10.9 25.25-19.17 38-12.45 12.36 6.51 14.8 22.86 15.49 36.81 4.19 85.5-12.93 165-18.66 249.84q-11.39 169.1-24.17 338.1c-12.38 166.32 119.24 308.06 286 308.06h42.15a639.37 639.37 0 00199.84-32l54.64-18A3.35 3.35 0 013888.11 2317.6zM3776.58 1413.12c-53.15-71.17-55.1-178.61-127.24-230.51-48.84-35.18-115.25-32.55-174.07-19.84-31.62 6.84-66.81 23.2-98.81 25.36-33.57 2.27-65.85-9.7-100.89-5-34.71 4.67-68.6 14.33-103.28 19.19-4.5.62-10.31.37-12.65-3 13.54-8.08 26.81-16 39.18-23.49 74-19.72 146.81-37.45 219.61-60.76 24.22-7.77 57.06-19.45 91.43-28.38a422.09 422.09 0 0156.2-11c27.74-3.25 53.92-2.23 74.64 6.72a118.24 118.24 0 0154.73 48.15l10.59 17.84c29.44 49.47 38.79 106.26 50 162.72C3761.33 1337.52 3768.43 1372.18 3776.58 1413.12zM3056.25 1762.08q-9.91 16.8-19.95 33.64L2789.81 2008a59.24 59.24 0 01-65.15 8.1l-14.42-7.21a59.49 59.49 0 01-21.09-17.68l-.84-1.13a124.3 124.3 0 0015.74-3.63c34.24-10.24 64.45-30.48 94.08-50.45Q2927.21 1849.07 3056.25 1762.08z" opacity=".18" class="color03157a svgShape"></path><circle cx="423.02" cy="2080.35" r="31.09" fill="var(--primary-bg-color)" opacity=".28" transform="rotate(-40.38 423.002 2080.32)" class="color1f60e5 svgShape"></circle><circle cx="490.37" cy="2341.39" r="26.18" fill="var(--primary-bg-color)" opacity=".57" transform="rotate(-5.01 489.982 2340.008)" class="color1f60e5 svgShape"></circle><circle cx="693.83" cy="2619.29" r="17.18" fill="#ffc107" opacity=".35" transform="rotate(-48.86 693.93 2619.415)" class="colorffb600 svgShape"></circle><circle cx="3819.09" cy="2673.01" r="17.18" fill="#ffc107" opacity=".72" transform="rotate(-84.55 3819.159 2673)" class="colorffb600 svgShape"></circle><circle cx="4101.29" cy="2538.54" r="18" fill="var(--primary-bg-color)" opacity=".28" transform="rotate(-47.2 4101.47 2538.566)" class="color1f60e5 svgShape"></circle><circle cx="4221.1" cy="2162.23" r="22.09" fill="#ffc107" opacity=".54" transform="rotate(-77.19 4220.987 2162.252)" class="colorffb600 svgShape"></circle><path fill="#ffffff" d="M4077.38 2037.94l-6.36 35.49a290.53 290.53 0 01-226.44 233.18l-13.42 2.81 8.48-40.82a290.55 290.55 0 01198.45-218.48zM3711.56 2369.3l32.42-6.25a268.58 268.58 0 01275 116.37l6.9 10.52-37.69 6.19a268.57 268.57 0 01-253.06-97.35z" class="colorfff svgShape"></path><path fill="#ffffff" d="M4077.38,2037.94l-6.36,35.49a290.53,290.53,0,0,1-226.44,233.18l-13.42,2.81,8.48-40.82a290.55,290.55,0,0,1,198.45-218.48Z" opacity=".54" class="colorfff svgShape"></path><path fill="#ffffff" d="M3711.56 2369.3l32.42-6.25a268.58 268.58 0 01275 116.37l6.9 10.52-37.69 6.19a268.57 268.57 0 01-253.06-97.35zM4303.26 2289l-30.7 18.91a290.55 290.55 0 01-324.76-13.48l-11-8.13 36.09-20.89a290.57 290.57 0 01295.14 2.41z" class="colorfff svgShape"></path><path fill="#ffffff" d="M4303.26 2289l-30.7 18.91a290.55 290.55 0 01-324.76-13.48l-11-8.13 36.09-20.89a290.57 290.57 0 01295.14 2.41zM4077.38 2037.94l-6.36 35.49a290.53 290.53 0 01-226.44 233.18l-13.42 2.81 8.48-40.82a290.55 290.55 0 01198.45-218.48zM3599.38 2396.5l3.73 40.11 11.21-7.42c53-35.09 93.37-85.72 116.87-143a.45.45 0 000-.19c19.47-47.45 27.33-99.44 21.18-150.83l-4.12-34.5-31.78 25.35a311.23 311.23 0 00-35.87 33.58C3622 2223.88 3591.47 2310.84 3599.38 2396.5zM3711.55 2369.3l23.57 29.48a269 269 0 00175 98.62 266.25 266.25 0 0078.1-1.27l37.69-6.19-6.9-10.52a268.63 268.63 0 00-176.31-116.84s0 0-.07 0a266.63 266.63 0 00-98.62.48z" class="colorfff svgShape"></path><path fill="#ff9541" d="M3509.4,2542.25c2.74.59,5.51,1.15,8.28,1.72A447.16,447.16,0,0,1,3566,2481.9c2.06-2.24,4.14-4.45,6.27-6.63a502.65,502.65,0,0,1,47.32-43.15,606.77,606.77,0,0,1,93.21-61.28c1.79-1,3.53-1.9,5.3-2.8,58.52-30.88,118.34-51.77,170.23-65.84,7.83-2.11,15.58-4.13,23.24-6q15-3.66,29.46-6.78h0c12.09-2.63,23.86-5,35.21-7,87.87-16,151.84-16.73,152.67-16.73a4,4,0,1,0,0-7.91c-.85,0-63.88.73-150.89,16.28-9.78,1.76-19.86,3.68-30.21,5.83-3,.6-6,1.26-9,1.91q-12.73,2.74-25.91,5.94t-26.43,6.77c-.06,0-.09,0-.14,0q-20,5.41-39.23,11.53c-61.15,19.35-116.53,43.77-165.06,72.81q-12.16,7.29-23.73,14.94-19.71,13-37.69,27.16-9,7-17.64,14.39a510.1,510.1,0,0,0-39.55,37.58c-2.12,2.24-4.2,4.47-6.24,6.75a460,460,0,0,0-47.59,62.15A2.13,2.13,0,0,0,3509.4,2542.25Z" opacity=".78" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M4076.19,2045.52l-6.35,35.49a290.56,290.56,0,0,1-226.44,233.18L3830,2317l8.47-40.83a290.57,290.57,0,0,1,198.46-218.47Z" opacity=".69" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M3599.38,2396.5l3.73,40.11,11.21-7.42c53-35.09,93.37-85.72,116.87-143a.45.45,0,0,0,0-.19,322.26,322.26,0,0,0,15-140.78l-4.41-37-34,27.14a332.6,332.6,0,0,0-27.13,24.2C3622,2223.88,3591.47,2310.84,3599.38,2396.5Z" opacity=".44" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M3724.75,2371.37l23.58,29.47a245.15,245.15,0,0,0,239.87,95.29l37.69-6.19-6.9-10.52a268.63,268.63,0,0,0-176.31-116.84s0,0-.07,0a266.42,266.42,0,0,0-85.42,2.54Z" opacity=".43" class="colorfe7101 svgShape"></path><path fill="#ffffff" d="M4303.26,2289l-30.7,18.91a290.55,290.55,0,0,1-324.76-13.48l-11-8.13,36.09-20.89a290.57,290.57,0,0,1,295.14,2.41Z" class="colorfff svgShape"></path><path fill="#ff9541" d="M4303.26,2289l-30.7,18.91a290.55,290.55,0,0,1-324.76-13.48l-11-8.13,36.09-20.89a290.57,290.57,0,0,1,295.14,2.41Z" opacity=".45" class="colorfe7101 svgShape"></path><path fill="#ffffff" d="M1285,2579.43q-6.95,1.2-13.89,2.24l-1.59-.71c-.49-.22-1-.42-1.51-.67a545.27,545.27,0,0,0-107.66-34.64c-11.78-2.45-24.07-4.58-36.74-6.16a413.65,413.65,0,0,0-58.73-3.26c-3,.07-6,.14-9.08.27v0a349.13,349.13,0,0,0-60.18,7.69c-10.08,2.22-20.28,4.94-30.5,8.25q-9.15,2.94-18.3,6.55c-4.39,1.74-8.82,3.61-13.22,5.57,0,0,0,0,0,0A311.86,311.86,0,0,0,905,2579.25c-31.26,18.14-61.8,43.19-90,77.18-.6.74-1.22,1.47-1.82,2.23a3.91,3.91,0,0,1-3.32,1.45.93.93,0,0,1-.24-.05,3.71,3.71,0,0,1-2-.84,3.53,3.53,0,0,1-1.18-1.67,3.93,3.93,0,0,1,.62-3.88c.92-1.11,1.81-2.2,2.74-3.29,25.45-30.5,54-55.46,85.29-74.67a313.57,313.57,0,0,1,58.67-28.08c3.71-1.33,7.48-2.58,11.26-3.78a325.3,325.3,0,0,1,34.15-8.75,352.56,352.56,0,0,1,51.9-6.41q4.54-.24,9.15-.38a420.25,420.25,0,0,1,64.63,3.36c9.33,1.16,18.45,2.61,27.32,4.28a548.56,548.56,0,0,1,112.54,34.3c2.44,1.05,4.78,2.07,7,3.05s4,1.81,5.87,2.65c2.72,1.25,5.17,2.41,7.37,3.45C1284.93,2579.4,1284.93,2579.43,1285,2579.43Z" class="colorfff svgShape"></path><path fill="#ffffff" d="M816.05 2648l-23.49 8.83A204.17 204.17 0 00660.5 2841.47l-.29 9.56 26.89-11a204.18 204.18 0 00125.38-163.59zM945.67 2554.15l-19 16.37a204.14 204.14 0 00-60.5 218.78l3 9.07 21.49-19.53a204.15 204.15 0 0061.47-196.72z" class="colorfff svgShape"></path><path fill="#ff9541" d="M945.67,2554.15l-19,16.37a204.14,204.14,0,0,0-60.5,218.78l3,9.07,21.49-19.53a204.15,204.15,0,0,0,61.47-196.72Z" opacity=".78" class="colorfe7101 svgShape"></path><path fill="#ffffff" d="M1452.32,2506.6c-.09,1.78-.22,3.56-.35,5.32-.18,2.1-.38,4.21-.61,6.28-.13,1.36-.26,2.72-.42,4.05-.33,3-.71,5.93-1.16,8.84-.08.71-.17,1.43-.31,2.12-.13,1-.29,1.91-.44,2.85-.11.69-.23,1.35-.36,2q-19.44,6.26-38.94,12l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38-.18-.58-.38-1.16-.6-1.76-1.09-3.18-2.18-6.54-3.29-10a437.53,437.53,0,0,1-19.35-100.16c-.47-6.86-.8-13.85-.91-21v0a355.7,355.7,0,0,1,4.87-65.75v0c.16-1.07.36-2.14.56-3.23v0a318.25,318.25,0,0,1,27.78-84.65q5.25-10.68,11.49-21.28v0a1.91,1.91,0,0,1,.16-.27c2.89-4.92,6-9.75,9.24-14.65v0a0,0,0,0,1,0,0c2.09-3.19,4.32-6.35,6.61-9.55,0,0,0,0,0,0q9.25-12.89,20.26-25.55a393.45,393.45,0,0,1,49.29-47.2s19.55,41.85,39.1,101.3c17,51.69,34,116.65,38.18,179,.38,5.54.67,11,.8,16.52C1453.12,2484.78,1453,2495.81,1452.32,2506.6Z" class="colorfff svgShape"></path><path fill="#ffc107" d="M1452.32,2506.6c-.09,1.78-.22,3.56-.35,5.32-.18,2.1-.38,4.21-.61,6.28-.13,1.36-.26,2.72-.42,4.05-.33,3-.71,5.93-1.16,8.84-.08.71-.17,1.43-.31,2.12-.13,1-.29,1.91-.44,2.85-.11.69-.23,1.35-.36,2q-19.44,6.26-38.94,12l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38-.18-.58-.38-1.16-.6-1.76-1.09-3.18-2.18-6.54-3.29-10a437.53,437.53,0,0,1-19.35-100.16c-.47-6.86-.8-13.85-.91-21v0a355.7,355.7,0,0,1,4.87-65.75v0c.16-1.07.36-2.14.56-3.23v0a318.25,318.25,0,0,1,27.78-84.65q5.25-10.68,11.49-21.28v0a1.91,1.91,0,0,1,.16-.27c2.89-4.92,6-9.75,9.24-14.65v0a0,0,0,0,1,0,0c2.09-3.19,4.32-6.35,6.61-9.55,0,0,0,0,0,0q9.25-12.89,20.26-25.55a393.45,393.45,0,0,1,49.29-47.2s19.55,41.85,39.1,101.3c17,51.69,34,116.65,38.18,179,.38,5.54.67,11,.8,16.52C1453.12,2484.78,1453,2495.81,1452.32,2506.6Z" opacity=".67" class="colorffb600 svgShape"></path><path fill="#ffc107" d="M1450.94,2522.25c-.33,3-.71,5.93-1.16,8.84-.08.71-.17,1.43-.31,2.12-.13,1-.29,1.91-.44,2.85-.11.69-.23,1.35-.36,2q-19.44,6.26-38.94,12l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38-.18-.58-.38-1.16-.6-1.76-1.09-3.18-2.18-6.54-3.29-10a437.53,437.53,0,0,1-19.35-100.16c-.47-6.86-.8-13.85-.91-21v0a355.7,355.7,0,0,1,4.87-65.75v0c.16-1.07.36-2.14.56-3.23v0a318.25,318.25,0,0,1,27.78-84.65q5.25-10.68,11.49-21.28v0a1.91,1.91,0,0,1,.16-.27c1.62,1.51,3.22,3,4.81,4.59.37.33.75.66,1.11,1q3.38,3.24,6.66,6.62c2.47,2.49,4.92,5,7.32,7.68,1,1,2,2,2.92,3.11a546.43,546.43,0,0,1,38.82,47.67q4.24,5.8,8.33,11.73c.73,1,1.4,2,2.11,3,1.81,2.62,3.54,5.23,5.33,7.86l0,0c2.51,3.74,5,7.5,7.48,11.33,1.76,2.76,3.54,5.5,5.25,8.28a1049.9,1049.9,0,0,1,56.31,102.82q2.7,5.57,5.29,11.08C1444.42,2507.94,1447.74,2515.15,1450.94,2522.25Z" opacity=".67" class="colorffb600 svgShape"></path><path fill="#ffffff" d="M1409.73,2550l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38q-30.12,4.54-60.15,6.64-7-5.31-14.32-11.07a265.72,265.72,0,0,1-33.79-32q-4.21-4.77-8.17-9.7c-116.57-145-49.05-373.67-49.05-373.67,1.27.24,2.58.49,3.87.76.83.18,1.7.38,2.52.58,1.27.29,2.54.57,3.81.91,2.53.64,5,1.31,7.54,2.07s5.1,1.58,7.62,2.45c1.11.4,2.2.78,3.29,1.2a11.7,11.7,0,0,1,1.2.45c.92.33,1.85.69,2.77,1.06.46.18.93.36,1.4.56.24.09.49.18.73.29.51.2,1,.42,1.52.65.93.37,1.87.78,2.8,1.18s1.87.82,2.81,1.24l2.78,1.29c.93.43,1.85.87,2.76,1.34,1.14.56,2.23,1.11,3.36,1.69,2.05,1.05,4.08,2.12,6.08,3.25l.33.18c1.29.73,2.61,1.45,3.9,2.2s2.6,1.52,3.9,2.3a0,0,0,0,1,0,0c2.65,1.6,5.27,3.25,7.88,5a0,0,0,0,1,0,0c3.92,2.58,7.79,5.3,11.65,8.12q9.67,7.15,19,15.23c2.49,2.16,5,4.34,7.39,6.59,1.24,1.14,2.47,2.27,3.69,3.43,2.43,2.29,4.83,4.61,7.24,7,1.2,1.2,2.38,2.41,3.58,3.61,3.48,3.52,6.88,7.12,10.27,10.8q10.14,11.05,19.88,23,4.85,6,9.55,12.11c3.16,4.12,6.3,8.28,9.37,12.51a0,0,0,0,0,0,0q4.25,5.82,8.33,11.74l2.11,3c1.81,2.63,3.54,5.21,5.33,7.86l0,0c2.51,3.77,5,7.53,7.48,11.36,10.11,15.67,19.75,31.81,28.87,48.09q5.88,10.48,11.47,21,3.7,7,7.32,14c2.41,4.67,4.77,9.35,7.08,14s4.59,9.33,6.82,14c11.84,24.56,22.48,48.6,31.85,71.11,1.1,2.65,2.19,5.28,3.25,7.88q1.21,2.94,2.39,5.83,3.49,8.65,6.74,16.95C1407.73,2544.87,1408.73,2547.48,1409.73,2550Z" class="colorfff svgShape"></path><path fill="#ff9541" d="M1285,2579.43q-6.95,1.2-13.89,2.24l-1.59-.71c-.49-.22-1-.42-1.51-.67a545.27,545.27,0,0,0-107.66-34.64c-11.78-2.45-24.07-4.58-36.74-6.16a413.65,413.65,0,0,0-58.73-3.26c-3,.07-6,.14-9.08.27v0a349.13,349.13,0,0,0-60.18,7.69c-10.08,2.22-20.28,4.94-30.5,8.25q-9.15,2.94-18.3,6.55c-4.39,1.74-8.82,3.61-13.22,5.57,0,0,0,0,0,0A311.86,311.86,0,0,0,905,2579.25c-31.26,18.14-61.8,43.19-90,77.18-.6.74-1.22,1.47-1.82,2.23a3.91,3.91,0,0,1-3.32,1.45.93.93,0,0,1-.24-.05,3.71,3.71,0,0,1-2-.84,3.53,3.53,0,0,1-1.18-1.67,3.93,3.93,0,0,1,.62-3.88c.92-1.11,1.81-2.2,2.74-3.29,25.45-30.5,54-55.46,85.29-74.67a313.57,313.57,0,0,1,58.67-28.08c3.71-1.33,7.48-2.58,11.26-3.78a325.3,325.3,0,0,1,34.15-8.75,352.56,352.56,0,0,1,51.9-6.41q4.54-.24,9.15-.38a420.25,420.25,0,0,1,64.63,3.36c9.33,1.16,18.45,2.61,27.32,4.28a548.56,548.56,0,0,1,112.54,34.3c2.44,1.05,4.78,2.07,7,3.05s4,1.81,5.87,2.65c2.72,1.25,5.17,2.41,7.37,3.45C1284.93,2579.4,1284.93,2579.43,1285,2579.43Z" opacity=".78" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M816.05,2648l-23.49,8.83A204.17,204.17,0,0,0,660.5,2841.47l-.29,9.56,26.89-11a204.18,204.18,0,0,0,125.38-163.59Z" opacity=".42" class="colorfe7101 svgShape"></path><path fill="#ffc107" d="M1409.73,2550l0,0c-24.18,7.08-48.38,13.47-72.6,19h0Q1311,2575,1285,2579.43h0q-6.95,1.2-13.89,2.24c-.83.14-1.67.27-2.5.38q-30.12,4.54-60.15,6.64-7-5.31-14.32-11.07a265.72,265.72,0,0,1-33.79-32q-4.21-4.77-8.17-9.7c-116.57-145-49.05-373.67-49.05-373.67,1.27.24,2.58.49,3.87.76.83.18,1.7.38,2.52.58,1.27.29,2.54.57,3.81.91,2.53.64,5,1.31,7.54,2.07s5.1,1.58,7.62,2.45c1.11.4,2.2.78,3.29,1.2a11.7,11.7,0,0,1,1.2.45c.92.33,1.85.69,2.77,1.06.46.18.93.36,1.4.56.24.09.49.18.73.29.51.2,1,.42,1.52.65.93.37,1.87.78,2.8,1.18s1.87.82,2.81,1.24l2.78,1.29c.93.43,1.85.87,2.76,1.34,1.14.56,2.23,1.11,3.36,1.69,2.05,1.05,4.08,2.12,6.08,3.25l.33.18c1.29.73,2.61,1.45,3.9,2.2s2.6,1.52,3.9,2.3a0,0,0,0,1,0,0c2.65,1.6,5.27,3.25,7.88,5a0,0,0,0,1,0,0c3.92,2.58,7.79,5.3,11.65,8.12q9.67,7.15,19,15.23c2.49,2.16,5,4.34,7.39,6.59,1.24,1.14,2.47,2.27,3.69,3.43,2.43,2.29,4.83,4.61,7.24,7,1.2,1.2,2.38,2.41,3.58,3.61,3.48,3.52,6.88,7.12,10.27,10.8q10.14,11.05,19.88,23,4.85,6,9.55,12.11c3.16,4.12,6.3,8.28,9.37,12.51a0,0,0,0,0,0,0q4.25,5.82,8.33,11.74l2.11,3c1.81,2.63,3.54,5.21,5.33,7.86l0,0c2.51,3.77,5,7.53,7.48,11.36,10.11,15.67,19.75,31.81,28.87,48.09q5.88,10.48,11.47,21,3.7,7,7.32,14c2.41,4.67,4.77,9.35,7.08,14s4.59,9.33,6.82,14c11.84,24.56,22.48,48.6,31.85,71.11,1.1,2.65,2.19,5.28,3.25,7.88q1.21,2.94,2.39,5.83,3.49,8.65,6.74,16.95C1407.73,2544.87,1408.73,2547.48,1409.73,2550Z" opacity=".67" class="colorffb600 svgShape"></path><path fill="#ffffff" d="M1409.71,2550.06c-24.18,7.08-48.38,13.47-72.6,19h0c-34.58-26.65-65.06-60.78-91.77-98.94-66.3-94.68-109.65-214.26-135.85-306.47,1.27.29,2.54.57,3.81.91,2.53.64,5,1.31,7.54,2.07s5.1,1.58,7.62,2.45c1.11.4,2.2.78,3.29,1.2a11.7,11.7,0,0,1,1.2.45c.92.33,1.85.69,2.77,1.06.46.18.93.36,1.4.56.24.09.49.18.73.29,1.45.58,2.87,1.18,4.32,1.83.94.4,1.87.82,2.81,1.24l2.78,1.29c.93.43,1.85.87,2.76,1.34,1.14.56,2.23,1.11,3.36,1.69s2.09,1.14,3.16,1.69l2.92,1.56.33.18c1.29.73,2.61,1.45,3.9,2.2s2.6,1.52,3.9,2.3a0,0,0,0,1,0,0c2.65,1.6,5.27,3.25,7.88,5a0,0,0,0,1,0,0c3.92,2.58,7.79,5.3,11.65,8.12q9.67,7.15,19,15.23c2.49,2.16,5,4.34,7.39,6.59,1.24,1.14,2.47,2.27,3.69,3.43,2.43,2.27,4.83,4.61,7.24,7,1.2,1.2,2.38,2.41,3.58,3.61,3.48,3.52,6.88,7.12,10.27,10.8q10.14,11.05,19.88,23,4.85,6,9.55,12.11c3.16,4.12,6.3,8.28,9.37,12.51a0,0,0,0,0,0,0q4.22,5.82,8.33,11.74l2.11,3c1.79,2.63,3.54,5.21,5.3,7.86h0l0,0c2.51,3.77,5,7.53,7.48,11.36,10.11,15.67,19.75,31.81,28.87,48.09q5.88,10.48,11.47,21,3.7,7,7.32,14c2.41,4.67,4.77,9.35,7.08,14s4.59,9.33,6.82,14c11.84,24.56,22.48,48.6,31.85,71.11,1.1,2.65,2.19,5.28,3.25,7.88q1.21,2.94,2.39,5.83c2.33,5.77,4.56,11.42,6.74,16.95C1407.71,2544.9,1408.71,2547.5,1409.71,2550.06Z" class="colorfff svgShape"></path><path fill="#ffc107" d="M1409.71,2550.06c-24.18,7.08-48.38,13.47-72.6,19h0c-34.58-26.65-65.06-60.78-91.77-98.94-66.3-94.68-109.65-214.26-135.85-306.47,1.27.29,2.54.57,3.81.91,2.53.64,5,1.31,7.54,2.07s5.1,1.58,7.62,2.45c1.11.4,2.2.78,3.29,1.2a11.7,11.7,0,0,1,1.2.45c.92.33,1.85.69,2.77,1.06.46.18.93.36,1.4.56.24.09.49.18.73.29,1.45.58,2.87,1.18,4.32,1.83.94.4,1.87.82,2.81,1.24l2.78,1.29c.93.43,1.85.87,2.76,1.34,1.14.56,2.23,1.11,3.36,1.69s2.09,1.14,3.16,1.69l2.92,1.56.33.18c1.29.73,2.61,1.45,3.9,2.2s2.6,1.52,3.9,2.3a0,0,0,0,1,0,0c2.65,1.6,5.27,3.25,7.88,5a0,0,0,0,1,0,0c3.92,2.58,7.79,5.3,11.65,8.12q9.67,7.15,19,15.23c2.49,2.16,5,4.34,7.39,6.59,1.24,1.14,2.47,2.27,3.69,3.43,2.43,2.27,4.83,4.61,7.24,7,1.2,1.2,2.38,2.41,3.58,3.61,3.48,3.52,6.88,7.12,10.27,10.8q10.14,11.05,19.88,23,4.85,6,9.55,12.11c3.16,4.12,6.3,8.28,9.37,12.51a0,0,0,0,0,0,0q4.22,5.82,8.33,11.74l2.11,3c1.79,2.63,3.54,5.21,5.3,7.86h0l0,0c2.51,3.77,5,7.53,7.48,11.36,10.11,15.67,19.75,31.81,28.87,48.09q5.88,10.48,11.47,21,3.7,7,7.32,14c2.41,4.67,4.77,9.35,7.08,14s4.59,9.33,6.82,14c11.84,24.56,22.48,48.6,31.85,71.11,1.1,2.65,2.19,5.28,3.25,7.88q1.21,2.94,2.39,5.83c2.33,5.77,4.56,11.42,6.74,16.95C1407.71,2544.9,1408.71,2547.5,1409.71,2550.06Z" opacity=".29" class="colorffb600 svgShape"></path><path fill="#ffffff" d="M1089.41 2585.39c-3.07-.4-6.12-.82-9.19-1.29a454.33 454.33 0 00-24.47-47.58v0c-1.54-2.62-3.1-5.23-4.72-7.81a504.56 504.56 0 00-37-52.28 605.16 605.16 0 00-77.95-79.74l0 0c-1.54-1.33-3-2.58-4.56-3.85l0 0c-50.56-42.64-104.5-75.83-152.19-100.65q-10.82-5.61-21.44-10.85c-9.24-4.51-18.37-8.83-27.31-12.91h0c-11.24-5.16-22.24-10-32.9-14.36-17.28-7.21-33.69-13.53-48.83-19-57-20.77-96.11-29.79-96.73-29.92a4 4 0 01-3-4.75 3.94 3.94 0 014.74-3c.62.13 37.18 8.57 91.21 27.85 16.16 5.77 33.88 12.51 52.7 20.28 9.19 3.81 18.61 7.84 28.27 12.16 2.78 1.22 5.57 2.51 8.37 3.78q8 3.65 16.12 7.55c2.63 1.23 5.28 2.49 7.93 3.79q12 5.84 24.37 12.26s.07.07.12.07q18.36 9.51 35.77 19.59a.12.12 0 01.09 0q7.32 4.2 14.45 8.5c49.67 29.74 93.64 62.54 131.24 97.89q10.32 9.72 20 19.64a0 0 0 000 0q16.47 17 31 34.6 7.33 8.8 14.13 17.81l0 0a508.63 508.63 0 0130.61 45.15c1.58 2.65 3.16 5.28 4.65 7.92A465.61 465.61 0 011089.41 2585.39zM3930.74 2640.48a4.84 4.84 0 01-4-2.07 264.47 264.47 0 00-28.27-34c-78.33-79.5-194.81-92.79-278.78-89.91-91.36 3.11-164.89 25.44-165.62 25.67a4.84 4.84 0 11-2.85-9.26c.74-.23 75.5-22.94 168.14-26.1 85.86-2.89 205.22 10.8 286 92.8a274.26 274.26 0 0129.32 35.29 4.84 4.84 0 01-4 7.62z" class="colorfff svgShape"></path><path fill="#ffffff" d="M3717.31 2733.61s18.43-172.39-164.5-222.27C3552.81 2511.34 3512.39 2666.33 3717.31 2733.61zM3948.38 2403.14s-162.22-61.2-256.5 103.31C3691.88 2506.45 3831.72 2584.54 3948.38 2403.14zM3866.47 2599.75c4.23-13 178 47.14 123 223.06C3989.51 2822.81 3811.62 2769 3866.47 2599.75z" class="colorfff svgShape"></path><g opacity=".78" fill="#000000" class="color000 svgShape"><path fill="#ff9541" d="M3930.74,2640.48a4.84,4.84,0,0,1-4-2.07,264.47,264.47,0,0,0-28.27-34c-78.33-79.5-194.81-92.79-278.78-89.91-91.36,3.11-164.89,25.44-165.62,25.67a4.84,4.84,0,1,1-2.85-9.26c.74-.23,75.5-22.94,168.14-26.1,85.86-2.89,205.22,10.8,286,92.8a274.26,274.26,0,0,1,29.32,35.29,4.84,4.84,0,0,1-4,7.62Z" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M3717.31,2733.61s18.43-172.39-164.5-222.27C3552.81,2511.34,3512.39,2666.33,3717.31,2733.61Z" opacity=".61" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M3948.38,2403.14s-162.22-61.2-256.5,103.31C3691.88,2506.45,3831.72,2584.54,3948.38,2403.14Z" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M3866.47,2567.68c4.23-13,178,47.14,123,223.05C3989.51,2790.73,3811.62,2736.94,3866.47,2567.68Z" opacity=".42" class="colorfe7101 svgShape"></path></g><path fill="#ffffff" d="M3548.36,2489.7c-1.07,5.57-2.23,11.14-3.48,16.66-.37,1.73-.78,3.47-1.2,5.21-.8,3.4-1.65,6.79-2.51,10.15-2.76,10.55-5.9,20.82-9.47,30.61a767.81,767.81,0,0,1-127.61,10.89h-1.85c-4.61,0-9.24,0-13.84-.11-.45,0-.89,0-1.32,0h-.38c-3.6-.06-7.19-.13-10.79-.24-3.86-.11-7.68-.25-11.51-.4-.34,0-.67,0-1-.05-2.6-.11-5.18-.22-7.77-.35s-5.16-.27-7.74-.43-5.17-.31-7.75-.46c-4.5-.29-9-.63-13.45-1-1.85-.14-3.67-.29-5.5-.45-1.42-.11-2.85-.24-4.27-.38-2.58-.22-5.17-.46-7.73-.71-2.27-.22-4.58-.44-6.85-.69h-.11q-26.05-4.2-52-9.46c.45-1,.94-1.94,1.41-2.92,34.75-69.64,125.85-195.38,310-220.85,0,0,0,2,.06,5.79C3561.87,2350.8,3561.43,2421.42,3548.36,2489.7Z" class="colorfff svgShape"></path><path fill="#ffffff" d="M3548.36,2489.7c-1.07,5.57-2.23,11.14-3.48,16.66-.37,1.73-.78,3.47-1.2,5.21-.8,3.4-1.65,6.79-2.51,10.15-2.76,10.55-5.9,20.82-9.47,30.61a767.81,767.81,0,0,1-127.61,10.89h-1.85c-4.61,0-9.24,0-13.84-.11-.45,0-.89,0-1.32,0,59.22-94.19,126.68-177.5,174.61-232.58C3561.87,2350.8,3561.43,2421.42,3548.36,2489.7Z" opacity=".56" class="colorfff svgShape"></path><path fill="#ffc107" d="M3548.36,2489.7c-1.07,5.57-2.23,11.14-3.48,16.66-.37,1.73-.78,3.47-1.2,5.21-.8,3.4-1.65,6.79-2.51,10.15-2.76,10.55-5.9,20.82-9.47,30.61a767.81,767.81,0,0,1-127.61,10.89h-1.85c-4.61,0-9.24,0-13.84-.11-.45,0-.89,0-1.32,0h-.38c-3.6-.06-7.19-.13-10.79-.24-3.86-.11-7.68-.25-11.51-.4-.34,0-.67,0-1-.05-2.6-.11-5.18-.22-7.77-.35s-5.16-.27-7.74-.43-5.17-.31-7.75-.46c-4.5-.29-9-.63-13.45-1-1.85-.14-3.67-.29-5.5-.45-1.42-.11-2.85-.24-4.27-.38-2.58-.22-5.17-.46-7.73-.71-2.27-.22-4.58-.44-6.85-.69h-.11q-26.05-4.2-52-9.46c.45-1,.94-1.94,1.41-2.92,34.75-69.64,125.85-195.38,310-220.85,0,0,0,2,.06,5.79C3561.87,2350.8,3561.43,2421.42,3548.36,2489.7Z" opacity=".67" class="colorffb600 svgShape"></path><path fill="#ff9541" d="M3548.36,2489.7c-1.07,5.57-2.23,11.14-3.48,16.66-.37,1.73-.78,3.47-1.2,5.21-.8,3.4-1.65,6.79-2.51,10.15-2.76,10.55-5.9,20.82-9.47,30.61a767.81,767.81,0,0,1-127.61,10.89h-1.85c-4.61,0-9.24,0-13.84-.11-.45,0-.89,0-1.32,0,59.22-94.19,126.68-177.5,174.61-232.58C3561.87,2350.8,3561.43,2421.42,3548.36,2489.7Z" opacity=".5" class="colorfe7101 svgShape"></path><path fill="#ffffff" d="M651 1993.54l-1.38 36a290.54 290.54 0 00171.4 276.17l12.51 5.62.44-41.7a290.55 290.55 0 00-147.2-255.83zM937.61 2395.4l-30.33-13a268.6 268.6 0 00-293.53 54.93l-9 8.8 35.5 14.11a268.64 268.64 0 00268-41z" class="colorfff svgShape"></path><path fill="#ffffff" d="M651,1993.54l-1.38,36a290.54,290.54,0,0,0,171.4,276.17l12.51,5.62.44-41.7a290.55,290.55,0,0,0-147.2-255.83Z" opacity=".54" class="colorfff svgShape"></path><path fill="#ffffff" d="M937.61 2395.4l-30.33-13a268.6 268.6 0 00-293.53 54.93l-9 8.8 35.5 14.11a268.64 268.64 0 00268-41zM376.74 2190.51l25.95 25a290.54 290.54 0 00320.14 56.22l12.52-5.59-30.8-28.11a290.54 290.54 0 00-288.84-60.7z" class="colorfff svgShape"></path><path fill="#ffffff" d="M376.74 2190.51l25.95 25a290.54 290.54 0 00320.14 56.22l12.52-5.59-30.8-28.11a290.54 290.54 0 00-288.84-60.7zM651 1993.54l-1.38 36a290.54 290.54 0 00171.4 276.17l12.51 5.62.44-41.7a290.55 290.55 0 00-147.2-255.83zM1041.39 2446l-12.21 38.39-9.36-9.65c-44.29-45.6-72.9-103.69-83.64-164.62a.67.67 0 010-.2c-8.88-50.51-5.44-103 11.54-151.86l11.4-32.83 25.63 31.55a311.79 311.79 0 0127.86 40.47C1056.15 2272.47 1067.42 2364 1041.39 2446zM937.63 2395.41l-29.33 23.76a268.39 268.39 0 01-268 41l-35.51-14.09 9-8.81A268.67 268.67 0 01811 2360.82a.05.05 0 01.08 0 266.78 266.78 0 0196.24 21.54z" class="colorfff svgShape"></path><path fill="#ff9541" d="M1089.41,2585.39c-3.07-.4-6.12-.82-9.19-1.29a454.33,454.33,0,0,0-24.47-47.58v0c-1.54-2.62-3.1-5.23-4.72-7.81a504.56,504.56,0,0,0-37-52.28,605.16,605.16,0,0,0-77.95-79.74l0,0c-1.54-1.33-3-2.58-4.56-3.85l0,0c-50.56-42.64-104.5-75.83-152.19-100.65q-10.82-5.61-21.44-10.85c-9.24-4.51-18.37-8.83-27.31-12.91h0c-11.24-5.16-22.24-10-32.9-14.36-17.28-7.21-33.69-13.53-48.83-19-57-20.77-96.11-29.79-96.73-29.92a4,4,0,0,1-3-4.75,3.94,3.94,0,0,1,4.74-3c.62.13,37.18,8.57,91.21,27.85,16.16,5.77,33.88,12.51,52.7,20.28,9.19,3.81,18.61,7.84,28.27,12.16,2.78,1.22,5.57,2.51,8.37,3.78q8,3.65,16.12,7.55c2.63,1.23,5.28,2.49,7.93,3.79q12,5.84,24.37,12.26s.07.07.12.07q18.36,9.51,35.77,19.59a.12.12,0,0,1,.09,0q7.32,4.2,14.45,8.5c49.67,29.74,93.64,62.54,131.24,97.89q10.32,9.72,20,19.64a0,0,0,0,0,0,0q16.47,17,31,34.6,7.33,8.8,14.13,17.81l0,0a508.63,508.63,0,0,1,30.61,45.15c1.58,2.65,3.16,5.28,4.65,7.92A465.61,465.61,0,0,1,1089.41,2585.39Z" opacity=".78" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M650.58,2001.2l-1.38,36A290.56,290.56,0,0,0,820.59,2313.4L833.1,2319l.45-41.69a290.56,290.56,0,0,0-147.2-255.83Z" opacity=".42" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M1041.39,2446l-12.21,38.39-9.36-9.65c-44.29-45.6-72.9-103.69-83.64-164.62a.67.67,0,0,1,0-.2,322.49,322.49,0,0,1,15.46-140.73L963.84,2134l27.43,33.78a332,332,0,0,1,21.33,29.44C1056.15,2272.47,1067.42,2364,1041.39,2446Z" opacity=".17" class="colorfe7101 svgShape"></path><path fill="#ff9541" d="M924.29,2394.61,895,2418.36a268.89,268.89,0,0,1-178.67,59.77,266.41,266.41,0,0,1-76-17.93l-35.51-14.09,9-8.81A268.67,268.67,0,0,1,811,2360.82a.05.05,0,0,1,.08,0,266.71,266.71,0,0,1,82.9,20.73Z" opacity=".43" class="colorfe7101 svgShape"></path><path fill="#ffffff" d="M376.74,2190.51l25.95,25a290.54,290.54,0,0,0,320.14,56.22l12.52-5.59-30.8-28.11a290.54,290.54,0,0,0-288.84-60.7Z" class="colorfff svgShape"></path><path fill="#ff9541" d="M376.74,2190.51l25.95,25a290.54,290.54,0,0,0,320.14,56.22l12.52-5.59-30.8-28.11a290.54,290.54,0,0,0-288.84-60.7Z" opacity=".78" class="colorfe7101 svgShape"></path></g></svg></g></svg>
                            </div>
                            <h6 class="mt-3">Find out more !</h6>
                            <a href="mail-settings.html" class="btn btn-outline-primary btn-block">Mail Settings</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="side3">
                        <div class="p-3 border-bottom">
                            <h6>Notifications :</h6>
                            <div class="panel mt-2 tabs-style5">
                                <div class="panel-head">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item flex-1"><a class="nav-link active" data-bs-toggle="tab" href="#tab_chat">Home</a></li>
                                        <li class="nav-item flex-1"><a class="nav-link" data-bs-toggle="tab" href="#tab_tasks">Tasks</a></li>
                                        <li class="nav-item flex-1"><a class="nav-link" data-bs-toggle="tab" href="#tab_app">App</a></li>
                                    </ul>
                                </div>
                                <div class="panel-body p-0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_chat">
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Someone mentioned</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Someone Replies</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Allow All Notifications</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <label class="tx-muted mb-0">Notifications On</label>
                                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="radioChat" id="radio1">
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio1">In App</label>

                                                    <input type="radio" class="btn-check" name="radioChat" id="radio2" checked>
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio2">Email</label>

                                                    <input type="radio" class="btn-check" name="radioChat" id="radio3">
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio3">Both</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_tasks">
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Assigned a Task</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">If I Have More Than 24 Tasks</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Allow All Notifications</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <label class="tx-muted mb-0">Notifications On</label>
                                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="radioTasks" id="radio4" checked>
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio4">In App</label>

                                                    <input type="radio" class="btn-check" name="radioTasks" id="radio5">
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio5">Email</label>

                                                    <input type="radio" class="btn-check" name="radioTasks" id="radio6">
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio6">Both</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_app">
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Weekly Report</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Password Change</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Payment Success</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Website Score Drops Below 80</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Company Announcements</span>
                                                    <input type="checkbox" class="custom-switch-input">
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="mt-3">
                                                <label class="d-flex align-items-center justify-content-between">
                                                    <span class="tx-muted d-flex align-items-center">Allow All Notifications</span>
                                                    <input type="checkbox" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator float-end"></span>
                                                </label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <label class="tx-muted mb-0">Notifications On</label>
                                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="radioApp" id="radio7">
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio7">In App</label>

                                                    <input type="radio" class="btn-check" name="radioApp" id="radio8" >
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio8">Email</label>

                                                    <input type="radio" class="btn-check" name="radioApp" id="radio9" checked>
                                                    <label class="btn btn-sm btn-outline-primary mb-0" for="radio9">Both</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <h6>App :</h6>
                            <div class="panel mt-2 tabs-style5">
                                <div class="panel-head">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item flex-1"><a class="nav-link active" data-bs-toggle="tab" href="#tab_apps">Account</a></li>
                                        <li class="nav-item flex-1"><a class="nav-link" data-bs-toggle="tab" href="#tab_profile">Profile</a></li>
                                    </ul>
                                </div>
                                <div class="panel-body p-0">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_apps">
                                            <div class="mt-3">
                                                <p class="mb-0">Connected Apps</p>
                                                <div class="mt-3">
                                                    <label class="mb-0 d-flex align-items-center justify-content-between">
                                                            <span class="tx-muted">
                                                                <svg id="SvgjsSvg1018" class="mx-1" width="20px" height="20px"><defs id="SvgjsDefs1019"></defs><g id="SvgjsG1020" transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Ebene 1" viewBox="0 0 1024 1024" width="20px" height="20px"><path fill="var(--primary-bg-color)" d="M1024,512C1024,229.23016,794.76978,0,512,0S0,229.23016,0,512c0,255.554,187.231,467.37012,432,505.77777V660H302V512H432V399.2C432,270.87982,508.43854,200,625.38922,200,681.40765,200,740,210,740,210V336H675.43713C611.83508,336,592,375.46667,592,415.95728V512H734L711.3,660H592v357.77777C836.769,979.37012,1024,767.554,1024,512Z" class="color1877f2 svgShape"></path><path fill="#ffffff" d="M711.3,660,734,512H592V415.95728C592,375.46667,611.83508,336,675.43713,336H740V210s-58.59235-10-114.61078-10C508.43854,200,432,270.87982,432,399.2V512H302V660H432v357.77777a517.39619,517.39619,0,0,0,160,0V660Z" class="colorfff svgShape"></path></svg></g></svg>
                                                                    Facebook
                                                            </span>
                                                        <input type="checkbox" class="custom-switch-input" checked>
                                                        <span class="custom-switch-indicator float-end"></span>
                                                    </label>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="mb-0 d-flex align-items-center justify-content-between">
                                                            <span class="tx-muted">
                                                                <svg width="30px" height="30px"><defs ></defs><g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30"><g data-name="Layer 2" fill="#000000" class="color000 svgShape"><g data-name="Layer 3" fill="#000000" class="color000 svgShape"><rect width="24" height="24" fill="none"></rect><path fill="transparent" d="M1,12C1,4,4,1,12,1S23,4,23,12,20,23,12,23,1,20,1,12" class="colorfff svgShape"></path><path fill="#e3e3e5" d="M17.54,4.56H6.46A1.06,1.06,0,0,0,5.4,5.64V18.36a1.06,1.06,0,0,0,1.06,1.08H17.54a1.06,1.06,0,0,0,1.06-1.08V5.64A1.06,1.06,0,0,0,17.54,4.56ZM8.94,6.24a.48.48,0,0,1,0-1,.48.48,0,0,1,0,1Zm6.12,0a.48.48,0,0,1,0-1,.48.48,0,1,1,0,1Z" class="colord9d9d9 svgShape"></path><path fill="var(--primary-bg-color)" d="M4.85,18.23l.49-5.3H18.66l.49,5.3a1.07,1.07,0,0,1-1.06,1.18H5.91A1.07,1.07,0,0,1,4.85,18.23Z" class="color008dff svgShape"></path><path fill="var(--primary08)" d="M4.57,7.93l.77,5H18.66l.77-5a1.07,1.07,0,0,0-1.06-1.24H5.63A1.07,1.07,0,0,0,4.57,7.93Z" class="color0066e0 svgShape"></path><path fill="#ffffff" d="M11.68 16H7.93v-.38L10 13.34a5.45 5.45 0 00.71-1 1.61 1.61 0 00.2-.74 1.22 1.22 0 00-.33-.9 1.26 1.26 0 00-.92-.33 1.3 1.3 0 00-1 .39 1.36 1.36 0 00-.37 1H7.8A1.9 1.9 0 018 10.86a1.57 1.57 0 01.65-.65 1.9 1.9 0 011-.24 1.77 1.77 0 011.28.43 1.54 1.54 0 01.47 1.18 2.08 2.08 0 01-.26.92 7.26 7.26 0 01-.92 1.24L8.54 15.63h3.14zM13.69 12.78h.51a1.76 1.76 0 00.75-.15 1.14 1.14 0 00.48-.41 1.13 1.13 0 00.17-.6 1.19 1.19 0 00-.33-.9 1.26 1.26 0 00-.93-.33 1.33 1.33 0 00-.95.34 1.18 1.18 0 00-.37.89h-.49a1.58 1.58 0 01.24-.85 1.55 1.55 0 01.65-.59 2 2 0 01.92-.21 1.81 1.81 0 011.28.44 1.63 1.63 0 01.47 1.22 1.31 1.31 0 01-.27.8 1.7 1.7 0 01-.76.54 1.57 1.57 0 01.85.54 1.48 1.48 0 01.29.91 1.65 1.65 0 01-.5 1.24 1.9 1.9 0 01-1.34.46 2.24 2.24 0 01-1-.21 1.64 1.64 0 01-.7-.6 1.62 1.62 0 01-.24-.89h.49a1.22 1.22 0 00.4.93 1.49 1.49 0 001 .36 1.41 1.41 0 001-.33 1.21 1.21 0 00.36-1 1.1 1.1 0 00-.39-.91 1.73 1.73 0 00-1.13-.32h-.5z" class="colorfff svgShape"></path></g></g></svg></g></svg>
                                                                Google Calendar
                                                            </span>
                                                        <input type="checkbox" class="custom-switch-input">
                                                        <span class="custom-switch-indicator float-end"></span>
                                                    </label>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="mb-0 d-flex align-items-center justify-content-between">
                                                            <span class="tx-muted">
                                                                <svg id="SvgjsSvg1024" class="mx-1" width="22px" height="20px"><defs id="SvgjsDefs1025"></defs><g id="SvgjsG1026" transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" width="22px" height="20px" data-name="047-dropbox" viewBox="0 0 98.488 98.488"><path fill="var(--primary-bg-color)" d="M305.244,19.07,276.27,0,256,17.057l29.214,18.177Z" data-name="Path 115" transform="translate(-206.756)" class="color1e88e5 svgShape"></path><path fill="var(--primary-bg-color)" d="M28.974,0,0,19.064l20.036,16.17L49.244,17.057Z" data-name="Path 116" class="color1e88e5 svgShape"></path><path fill="var(--primary-bg-color)" d="M49.244,201.351l-20.27,17.057L0,199.338l20.03-16.17,29.214,18.183,29.208-18.183,20.036,16.17-28.974,19.07Z" data-name="Path 117" transform="translate(0 -147.934)" class="color1e88e5 svgShape"></path><path fill="var(--primary-bg-color)" d="M148.512,334.908a3.055,3.055,0,0,1-1.687.5,3.107,3.107,0,0,1-1.982-.72l-18.066-15.2-18.066,15.2a3.089,3.089,0,0,1-3.675.215L96,328.961v9.092l30.839,18.466,30.716-18.466v-9.1Z" data-name="Path 118" transform="translate(-77.534 -258.032)" class="color1e88e5 svgShape"></path></svg></g></svg>
                                                                Dropbox
                                                            </span>
                                                        <input type="checkbox" class="custom-switch-input" checked>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <p class="mb-0">Login & Security</p>
                                                <div class="mt-3">
                                                    <div class="form-group mb-0">
                                                        <p class="mb-2 d-flex align-items-center justify-content-between">
                                                            <label for="inputPassword" class="mb-0 tx-muted">Password</label>
                                                            <a href="javascript:void(0)" class="tx-11 tx-primary" id="changePassword">change</a>
                                                        </p>
                                                        <input type="password" class="form-control form-contron-sm radius-4" id="inputPassword" placeholder="Enter New Password" value="passwordzem">
                                                        <div class="mt-2 d-none" id="reEnterPassword">
                                                            <input type="password" class="form-control form-contron-sm radius-4" id="inputPasswordTwo" placeholder="Re-Enter Password">
                                                            <div class="btn-list mt-2 text-end">
                                                                <a href="javascript:void(0)" class="tx-danger" id="closePassword">Discard</a>
                                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary ms-3">Save Changes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="mb-0 d-flex align-items-center justify-content-between">
                                                        <span class="tx-muted d-flex align-items-center">Two Factor Authentication</span>
                                                        <input type="checkbox" class="custom-switch-input" checked>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="form-group mb-0">
                                                        <p class="mb-0 d-flex align-items-center justify-content-between">
                                                            <label for="inputPassword" class="mb-0 tx-muted">Remove Account</label>
                                                            <a href="javascript:void(0)" class="tx-11 tx-primary" id="changePassword2">know more</a>
                                                        </p>
                                                        <a href="javascript:void(0)" class="btn btn-block btn-outline-danger mt-2">Delete My Account</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_profile">
                                            <div class="mt-3">
                                                <div class="form-group">
                                                    <label class="tx-muted" for="inputName">Full Name</label>
                                                    <input type="text" class="form-control radius-4" id="inputName" placeholder="Enter Full Name" value="Json Taylor">
                                                </div>
                                                <div class="form-group">
                                                    <label class="tx-muted" for="inputMail">Email</label>
                                                    <input type="email" class="form-control radius-4" id="inputMail" placeholder="Enter Your Mail" value="nicktaylor@spruko.me">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputNumber" class="tx-muted d-flex align-items-center justify-content-between">
                                                        Mobile Number
                                                        <a href="javascript:void(0)" class="tx-11 tx-primary" data-bs-target="#country-selector" data-bs-toggle="modal">change country</a>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text br-ts-20 br-bs-20">+11</span>
                                                        <input type="number" class="form-control br-te-4 br-be-4" id="inputNumber" placeholder="Enter Your Number" value="1179360254">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <h6>Others :</h6>
                            <div class="mt-3">
                                <label class="d-flex align-items-center justify-content-between">
                                    <span class="tx-muted">Back to top</span>
                                    <input type="checkbox" class="custom-switch-input backToTopCheckbox" onchange="switchBackToTop()" checked>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="text-center">
                                <svg class="svg-find" width="150" height="150"><defs ></defs><g transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 506.21 506.72" width="150" height="150"><g data-name="Layer 2" fill="#000000" class="color000 svgShape"><g data-name="Layer 1" fill="#000000" class="color000 svgShape"><rect width="66.69" height="46.96" x="347.87" y="383.88" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" transform="rotate(149.83 381.216 407.343)" class="colorStroke008ef8 svgStroke"></rect><circle cx="405.4" cy="429.06" r="29.82" fill="var(--primary03)" class="colorc1e3f7 svgShape"></circle><path fill="var(--primary04)" d="M229.34,101.73,506.21,0,495.37,41.43a110.93,110.93,0,0,0-.06,55.89l2.58,10a111,111,0,0,1-2.37,63.54h0a111,111,0,0,0-.83,68.91l11.52,36.73L229.34,111.12Z" class="colorfff8e9 svgShape"></path><path fill="var(--primary-bg-color)" d="M259.05,499.8a253.7,253.7,0,0,1-89.9,4.24q-4.41-.59-8.81-1.32t-8.89-1.66q-2.92-.58-5.84-1.26l.18-2.65.54-7.66.31-4.44.74-10.7.75-10.71.5-7.19.34-4.9.78-11.23.82-11.72.82-11.78.84-12.1.78-11.24.82-11.72.73-10.52.84-12.1.79-11.25.81-11.72.85-12.13.75-10.79.73-10.58.6-8.61.76-10.86.69-9.91.7-10.12.84-12,.84-12.1.78-11.24h0l.81-11.72.25-3.57h73.44l17,243.93,2.53,36.32Z" class="color008ef8 svgShape"></path><path fill="#489ee0" d="M259.05,499.8a253.7,253.7,0,0,1-89.9,4.24q-4.41-.59-8.81-1.32t-8.89-1.66q-2.92-.58-5.84-1.26l.18-2.65.54-7.66.31-4.44.74-10.7.75-10.71.5-7.19q2.69.58,5.38,1.1c2.73.53,5.47,1,8.21,1.45s5.61.86,8.42,1.2A253.78,253.78,0,0,0,256,456.45l2.53,36.32Z" class="color489ee0 svgShape"></path><path fill="#1e3a73" d="M168.81 212.52a5.8 5.8 0 01-1.37 2.13 5.66 5.66 0 01-2.08 1.44 6.39 6.39 0 013.45-3.57zM178.87 213a107.64 107.64 0 01-14.33 14.83 93.21 93.21 0 016.8-7.76A95.06 95.06 0 01178.87 213zM178.87 223.42a118.84 118.84 0 01-15.11 15.64 103.44 103.44 0 017.19-8.17A105.6 105.6 0 01178.87 223.42zM178.87 234.64c-2.38 3-5 5.84-7.62 8.61s-5.39 5.43-8.33 7.91c2.37-3 5-5.84 7.61-8.61S175.93 237.12 178.87 234.64zM178.87 282.44c-1.48 1.83-3 3.58-4.61 5.32s-3.18 3.45-4.8 5.14-3.28 3.36-5 5L162 300.31c-.88.79-1.73 1.6-2.62 2.36.73-.92 1.51-1.8 2.26-2.7l2.35-2.62c1.56-1.75 3.18-3.45 4.8-5.14s3.27-3.36 5-5S177.09 284 178.87 282.44zM178.87 292.26c-1.54 1.89-3.16 3.71-4.79 5.51s-3.31 3.57-5 5.33-3.39 3.48-5.15 5.17l-2.63 2.53c-.91.81-1.79 1.65-2.71 2.45.76-.95 1.57-1.86 2.35-2.79l2.44-2.72c1.62-1.82 3.3-3.58 5-5.33s3.4-3.48 5.15-5.17S177 293.87 178.87 292.26zM178.87 302.27c-1.61 2-3.29 3.84-5 5.71s-3.43 3.7-5.17 5.52-3.52 3.61-5.34 5.36l-2.73 2.63c-.93.85-1.85 1.72-2.8 2.55.79-1 1.63-1.93 2.45-2.89l2.53-2.82c1.68-1.88 3.42-3.7 5.17-5.52s3.52-3.61 5.34-5.36S177 303.94 178.87 302.27zM178.87 313.53c-1.68 2-3.43 4-5.19 5.93s-3.57 3.84-5.39 5.74-3.66 3.75-5.55 5.58l-2.83 2.73c-1 .89-1.92 1.8-2.91 2.66.83-1 1.7-2 2.55-3l2.64-2.93c1.76-1.95 3.57-3.84 5.38-5.74s3.67-3.75 5.55-5.58S176.9 315.27 178.87 313.53zM178.87 324.41c-1.74 2.1-3.56 4.12-5.4 6.14s-3.7 4-5.58 5.95-3.8 3.89-5.76 5.79l-2.93 2.84c-1 .92-2 1.86-3 2.76.86-1.06 1.77-2.07 2.66-3.11l2.73-3c1.83-2 3.71-4 5.59-5.95s3.8-3.89 5.75-5.79S176.83 326.22 178.87 324.41zM178.87 334.84c-1.81 2.17-3.7 4.26-5.59 6.34s-3.84 4.12-5.79 6.16-3.93 4-6 6l-3 2.94c-1 1-2 1.94-3.11 2.87.89-1.09 1.84-2.14 2.75-3.21L161 352.8c1.89-2.09 3.84-4.12 5.78-6.16s3.93-4 5.95-6S176.76 336.72 178.87 334.84zM178.87 346.07c-1.88 2.24-3.84 4.41-5.8 6.56s-4 4.27-6 6.37-4.07 4.18-6.16 6.21l-3.14 3.05c-1.07 1-2.12 2-3.21 3 .93-1.13 1.91-2.21 2.86-3.32l2.94-3.24c2-2.16 4-4.27 6-6.37s4.07-4.18 6.16-6.21S176.69 348 178.87 346.07zM178.87 355.83c-1.94 2.3-4 4.53-6 6.75s-4.1 4.39-6.17 6.56-4.19 4.31-6.35 6.4l-3.23 3.15c-1.1 1-2.18 2.07-3.3 3.07 1-1.16 2-2.27 2.95-3.41l3-3.34c2-2.22 4.1-4.39 6.18-6.56s4.19-4.31 6.34-6.4S176.63 357.85 178.87 355.83zM178.87 366.7c-2 2.37-4.09 4.67-6.19 7s-4.24 4.54-6.38 6.78-4.33 4.44-6.55 6.61l-3.33 3.25c-1.14 1.06-2.25 2.14-3.41 3.18 1-1.19 2-2.34 3.05-3.52l3.14-3.44c2.09-2.3 4.23-4.54 6.38-6.78s4.33-4.44 6.55-6.61S176.56 368.79 178.87 366.7zM178.87 377.14c-2.07 2.44-4.22 4.81-6.39 7.16s-4.36 4.67-6.57 7-4.46 4.58-6.75 6.81l-3.43 3.35c-1.17 1.09-2.31 2.21-3.5 3.28 1-1.23 2.1-2.41 3.15-3.62l3.23-3.54c2.16-2.36 4.37-4.67 6.58-7s4.46-4.58 6.74-6.81S176.5 379.3 178.87 377.14zM178.87 388.36c-2.14 2.51-4.36 4.95-6.6 7.38s-4.5 4.82-6.78 7.2-4.6 4.72-7 7L155 413.43c-1.21 1.13-2.39 2.28-3.61 3.39 1.06-1.26 2.17-2.48 3.26-3.73l3.33-3.65c2.23-2.44 4.51-4.82 6.79-7.2s4.6-4.72 6.95-7S176.43 390.59 178.87 388.36zM178.87 399.3c-2.21 2.58-4.5 5.09-6.8 7.59s-4.64 5-7 7.41-4.74 4.86-7.16 7.24l-3.64 3.57c-1.24 1.16-2.45 2.35-3.71 3.49 1.1-1.3 2.24-2.55 3.36-3.83l3.44-3.76c2.29-2.51 4.64-5 7-7.41s4.73-4.86 7.16-7.24S176.36 401.6 178.87 399.3zM178.87 451.68c-2.54 2.92-5.16 5.77-7.79 8.61s-5.31 5.61-8 8.42-5.4 5.54-8.14 8.26l-4.13 4.08c-1.4 1.33-2.78 2.69-4.2 4 1.26-1.47 2.57-2.89 3.85-4.34l3.93-4.27c2.63-2.84 5.32-5.61 8-8.42s5.4-5.54 8.14-8.26S176 454.32 178.87 451.68zM145.79 497.15c1.3-1.5 2.64-3 4-4.45l4-4.38c2.7-2.91 5.46-5.76 8.19-8.64s5.54-5.68 8.35-8.48l4.24-4.19c1.43-1.37 2.85-2.76 4.31-4.11-1.3 1.51-2.64 3-4 4.45l-4 4.38c-2.69 2.91-5.45 5.76-8.18 8.64s-5.54 5.69-8.35 8.49S148.69 494.44 145.79 497.15zM151.45 501.06c.63-.75 1.28-1.49 1.93-2.22s1.28-1.48 2-2.2l4-4.34a.41.41 0 01.29-.13h0l-.31.13c3.14-3.38 6.36-6.7 9.6-10 1.62-1.65 3.28-3.26 4.93-4.88s3.33-3.2 5-4.77c-1.51 1.75-3 3.49-4.6 5.19s-3.11 3.42-4.7 5.09c-3.17 3.36-6.37 6.69-9.64 9.95h0a.46.46 0 01-.3.12h0l.31-.13-4.2 4.12c-.69.69-1.41 1.35-2.12 2S152.17 500.4 151.45 501.06zM160.34 502.72c1.39-1.74 2.87-3.41 4.36-5.06s3-3.27 4.54-4.88 3.11-3.18 4.72-4.71l2.42-2.3c.83-.74 1.63-1.51 2.49-2.23-.69.88-1.43 1.71-2.14 2.57l-2.22 2.49c-1.48 1.66-3 3.27-4.55 4.88s-3.1 3.18-4.71 4.71S162 501.27 160.34 502.72zM169.15 504a43 43 0 014.5-5.38 42.38 42.38 0 015.22-4.69A49.36 49.36 0 01169.15 504zM178.87 410.17c-2.28 2.66-4.64 5.24-7 7.8s-4.78 5.1-7.19 7.62-4.87 5-7.37 7.46l-3.74 3.67c-1.27 1.2-2.52 2.42-3.81 3.6 1.13-1.34 2.31-2.63 3.46-3.94l3.54-3.86c2.36-2.58 4.78-5.1 7.2-7.62s4.87-5 7.36-7.46S176.29 412.54 178.87 410.17zM178.87 420.6c-2.35 2.72-4.77 5.37-7.2 8s-4.91 5.23-7.39 7.82-5 5.14-7.56 7.66l-3.84 3.77c-1.3 1.23-2.59 2.49-3.91 3.7 1.16-1.37 2.37-2.69 3.56-4l3.64-4c2.42-2.65 4.9-5.24 7.39-7.82s5-5.14 7.56-7.66S176.23 423 178.87 420.6zM148.13 463.64c2.41-2.8 4.9-5.52 7.41-8.22s5-5.38 7.6-8 5.14-5.28 7.77-7.87l3.94-3.88c1.34-1.27 2.66-2.56 4-3.81-1.2 1.4-2.45 2.76-3.67 4.15L171.46 440c-2.5 2.72-5.05 5.38-7.6 8s-5.15 5.28-7.77 7.87S150.84 461.13 148.13 463.64zM147.38 474.35c2.47-2.86 5-5.64 7.59-8.41s5.2-5.48 7.79-8.22 5.28-5.4 8-8.06l4-4c1.38-1.3 2.72-2.62 4.12-3.9-1.23 1.44-2.51 2.83-3.76 4.24l-3.84 4.17c-2.57 2.76-5.2 5.47-7.79 8.21s-5.27 5.41-8 8.06S150.15 471.78 147.38 474.35zM178.87 275.22c-1.44 1.72-3 3.35-4.47 5s-3.08 3.22-4.65 4.79-3.17 3.13-4.82 4.63l-2.46 2.26c-.85.72-1.67 1.48-2.54 2.18.71-.87 1.46-1.68 2.19-2.53l2.27-2.45c1.52-1.64 3.08-3.22 4.66-4.79s3.17-3.13 4.81-4.63S177.14 276.64 178.87 275.22zM178.87 264.88c-1.37 1.67-2.82 3.27-4.28 4.85s-3 3.13-4.46 4.66-3 3-4.62 4.5l-2.38 2.19c-.81.71-1.6 1.44-2.44 2.12.67-.84 1.4-1.64 2.1-2.46l2.17-2.39c1.45-1.59 3-3.13 4.46-4.66s3.05-3 4.63-4.5S177.21 266.26 178.87 264.88zM178.87 255.7c-2.64 3.21-5.49 6.2-8.39 9.15s-5.91 5.79-9.1 8.44c2.63-3.21 5.48-6.21 8.39-9.15S175.67 258.35 178.87 255.7zM178.87 246.21c-2.52 3.1-5.26 6-8 8.83s-5.67 5.58-8.75 8.13c2.51-3.1 5.25-6 8-8.83S175.79 248.76 178.87 246.21z" class="color2428bb svgShape"></path><rect width="73.48" height="49.92" x="165.57" y="162.6" fill="var(--primary03)" class="colorc1e3f7 svgShape"></rect><rect width="54.9" height="40.44" x="174.86" y="122.16" fill="var(--primary-bg-color)" class="color008ef8 svgShape"></rect><rect width="35.28" height="40.86" x="184.67" y="81.3" fill="var(--primary03)" class="colorc1e3f7 svgShape"></rect><path fill="var(--primary-bg-color)" d="M225.75,89.31H178.86a43.66,43.66,0,0,1,6-22.07l17.46-29.78,17.45,29.78a43.66,43.66,0,0,1,6,22.07Z" class="color008ef8 svgShape"></path><path fill="var(--primary03)" d="M239.9 224.79a15.44 15.44 0 00-28.1 10.11l3.44 38.41 27.87-2.5zM245.59 306.53a15.41 15.41 0 00-12.28-4.45h0a15.44 15.44 0 00-14 16.76l3.44 38.4L249 354.9zM251.58 392.5a15.45 15.45 0 00-6.39-.78h0a15.44 15.44 0 00-14 16.76l3.44 38.4 20.6-1.84z" class="colorc1e3f7 svgShape"></path><rect width="9.39" height="9.39" x="219.95" y="101.73" fill="#6784e4" class="color0234c1 svgShape"></rect><path fill="#a0c2ea" d="M33.93 149.88a190.83 190.83 0 0029.41-22.75c2.26-2.12 4.44-4.33 6.61-6.54 1-1.14 2.16-2.24 3.16-3.4s2-2.37 2.93-3.59c3.77-4.91 7.34-10 10.92-15.08L97.7 83.28c1.8-2.53 3.59-5.08 5.46-7.57a47.66 47.66 0 016.2-7A32.73 32.73 0 01126.26 61 48.5 48.5 0 01144.81 62a49.31 49.31 0 00-18.47-.58 32.15 32.15 0 00-16.47 7.77 52.3 52.3 0 00-6 7c-1.84 2.49-3.61 5-5.4 7.59L87.77 99.09c-3.6 5.07-7.19 10.14-11 15.07-1 1.22-1.93 2.44-3 3.62s-2.14 2.27-3.21 3.41c-2.18 2.22-4.4 4.41-6.71 6.5A178 178 0 0149.49 139.6 174.28 174.28 0 0133.93 149.88zM103.77 111a54 54 0 014.46-12.14 44.24 44.24 0 017.59-10.53 38.77 38.77 0 0110.51-7.67 112.88 112.88 0 0112-4.86 114.62 114.62 0 0011.91-4.91 108.45 108.45 0 0011.21-6.33A110.27 110.27 0 00171.89 57c3.36-2.7 6.54-5.61 9.64-8.61A112.77 112.77 0 01161.9 65.2a103.1 103.1 0 01-23.19 11.54 114.07 114.07 0 00-12 4.73 40 40 0 00-10.38 7.4C110.22 94.86 106.16 102.74 103.77 111zM30.33 301.08A139.33 139.33 0 0058.11 288.7c4.38-2.56 8.59-5.39 12.71-8.37s8.22-6 12.06-9.26a64.52 64.52 0 005.46-5.25 31.51 31.51 0 004.47-6 15 15 0 002-7 13.66 13.66 0 00-2.1-7c-2.58-4.19-6.86-7.56-11.75-8.27a11.89 11.89 0 00-7.1 1.26 15 15 0 00-5.44 4.88A14.26 14.26 0 0066 250.48a14.51 14.51 0 00.21 3.66 17.61 17.61 0 001.13 3.52 18 18 0 0010.65 9.74c4.76 1.52 10 1 14.81-.22a70.51 70.51 0 0014.11-5.45A108.74 108.74 0 00119.92 254a77.92 77.92 0 0011.54-9.85A88.45 88.45 0 00148.41 219a88.76 88.76 0 01-16.6 25.46 78.11 78.11 0 01-11.53 10 110.65 110.65 0 01-13.07 7.93A68.87 68.87 0 0193 268a38.15 38.15 0 01-7.61 1.17 22.28 22.28 0 01-7.69-.92 19 19 0 01-11.24-10.22 18.48 18.48 0 01-1.21-3.73A15.58 15.58 0 0165 250.4a15.16 15.16 0 012.67-7.32 16 16 0 015.81-5.19 12.83 12.83 0 017.68-1.33 16.19 16.19 0 017.16 3 20.19 20.19 0 015.24 5.73 14.57 14.57 0 012.21 7.45 15.92 15.92 0 01-2.17 7.45c-2.56 4.53-6.33 8.12-10.19 11.44s-8 6.27-12.2 9.19a149.13 149.13 0 01-12.83 8.28A139 139 0 0130.33 301.08z" class="colora0c2ea svgShape"></path><path fill="#ff9c76" d="M273.68,24.92c.55,2.62.91,5.25,1.2,7.88s.49,5.28.65,7.92.22,5.29.21,7.94a79.17,79.17,0,0,1-.36,8c-.55-2.63-.91-5.26-1.2-7.89s-.49-5.28-.65-7.92-.22-5.29-.2-7.94A78.83,78.83,0,0,1,273.68,24.92Z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M290.39 39.92a78.74 78.74 0 01-7.89 1.21c-2.63.3-5.27.48-7.92.64s-5.29.23-7.94.21a79 79 0 01-8-.35 78.74 78.74 0 017.89-1.21c2.63-.3 5.27-.48 7.92-.64s5.29-.22 7.94-.21S287.72 39.65 290.39 39.92zM294.61 44.36a36.16 36.16 0 011.06 5.29c.24 1.78.42 3.55.51 5.33s.12 3.56.07 5.35a36.35 36.35 0 01-.49 5.38 36.2 36.2 0 01-1.07-5.29c-.24-1.78-.41-3.55-.51-5.33s-.11-3.56-.06-5.35A36.35 36.35 0 01294.61 44.36z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M305.86 54.46a36.29 36.29 0 01-5.3 1.06c-1.77.25-3.54.42-5.32.51s-3.57.12-5.35.07a36.61 36.61 0 01-5.39-.49 38 38 0 015.3-1.07c1.77-.24 3.55-.41 5.33-.5s3.56-.12 5.35-.07A36.35 36.35 0 01305.86 54.46zM33.26 309.23a78.74 78.74 0 011.21 7.89c.3 2.63.48 5.28.65 7.92s.22 5.29.2 7.94a76 76 0 01-.35 8 75.92 75.92 0 01-1.2-7.89c-.3-2.63-.49-5.27-.65-7.91s-.22-5.29-.2-7.95A78.93 78.93 0 0133.26 309.23z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M50 324.24c-2.62.55-5.25.91-7.89 1.2s-5.28.49-7.92.65-5.29.22-7.94.21-5.31-.08-8-.35a78.74 78.74 0 017.89-1.21c2.63-.3 5.27-.49 7.91-.65s5.29-.22 7.95-.2A79 79 0 0150 324.24zM54.2 328.67a38 38 0 011.06 5.3c.24 1.77.41 3.55.51 5.33s.12 3.56.07 5.35a36.35 36.35 0 01-.49 5.38 35.3 35.3 0 01-1.07-5.3c-.24-1.77-.42-3.55-.51-5.33s-.11-3.56-.06-5.35A36.47 36.47 0 0154.2 328.67z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M65.45 338.78a38 38 0 01-5.3 1.06c-1.77.24-3.55.41-5.33.51s-3.56.12-5.35.07a36.47 36.47 0 01-5.38-.49 35.3 35.3 0 015.3-1.07c1.77-.24 3.55-.42 5.33-.51s3.56-.11 5.35-.06A36.35 36.35 0 0165.45 338.78zM467.14 289.81c.55 2.62.91 5.26 1.2 7.89s.49 5.28.65 7.92.22 5.29.21 7.94a78.84 78.84 0 01-.36 8c-.55-2.62-.91-5.25-1.2-7.89s-.49-5.27-.65-7.91-.22-5.29-.2-8A79 79 0 01467.14 289.81z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M483.85 304.82c-2.62.55-5.25.91-7.89 1.2s-5.27.49-7.92.65-5.29.23-7.94.21a79 79 0 01-8-.35 78.74 78.74 0 017.89-1.21c2.63-.3 5.27-.49 7.92-.65s5.29-.22 7.94-.2A79 79 0 01483.85 304.82zM488.07 309.25a36.56 36.56 0 011.06 5.3c.24 1.77.42 3.55.51 5.33s.12 3.56.07 5.35a36.35 36.35 0 01-.49 5.38 36.6 36.6 0 01-1.07-5.3c-.24-1.77-.41-3.54-.51-5.32s-.11-3.57-.06-5.36A36.6 36.6 0 01488.07 309.25z" class="colorf46534 svgShape"></path><path fill="#ff9c76" d="M499.32,319.36a36.29,36.29,0,0,1-5.3,1.06c-1.77.24-3.54.42-5.32.51s-3.57.12-5.35.07a36.61,36.61,0,0,1-5.39-.49,36.6,36.6,0,0,1,5.3-1.07c1.77-.24,3.55-.42,5.33-.51s3.56-.11,5.35-.06A36.35,36.35,0,0,1,499.32,319.36Z" class="colorf46534 svgShape"></path><path fill="#ffe7b8" d="M329.28 440.33L349 474.23a31.14 31.14 0 01-3.56-1.88l-16.29-28A28.26 28.26 0 01329.28 440.33zM330 451.22l9.9 17A33.38 33.38 0 01330 451.22zM330.56 433.86l24.69 42.48c-1-.24-2-.52-3-.85l-22.5-38.69A22.27 22.27 0 01330.56 433.86zM332.67 428.54l28.24 48.58a19.48 19.48 0 01-2.61-.24l-26.72-46A20.6 20.6 0 01332.67 428.54zM335.3 424.12L366.05 477a23.42 23.42 0 01-2.39.14l-29.66-51c0-.09.11-.18.17-.29C334.52 425.24 334.91 424.67 335.3 424.12zM338.28 420.49l32.4 55.73c-.74.18-1.46.34-2.21.45l-31.68-54.5A19.86 19.86 0 01338.28 420.49zM341.54 417.44l33.39 57.45c-.68.27-1.35.51-2 .72l-33-56.73A17 17 0 01341.54 417.44zM345.22 414.82L379 473a17.14 17.14 0 01-1.91 1L343.43 416C344 415.58 344.61 415.18 345.22 414.82zM349.24 412.74l33.6 57.8c-.56.42-1.14.83-1.76 1.21l-33.77-58.09A17 17 0 01349.24 412.74zM353.61 411.16l32.76 56.36c-.51.52-1.06 1-1.61 1.48l-33.25-57.19C352.2 411.58 352.9 411.35 353.61 411.16zM358.25 410.19L389.5 464a19.15 19.15 0 01-1.44 1.77L356 410.58A20.54 20.54 0 01358.25 410.19zM363.3 409.89l29 49.81c-.28.54-.57 1.05-.87 1.55-.12.19-.25.39-.37.56l-30.16-51.88C361.67 409.88 362.47 409.86 363.3 409.89zM368.69 410.41l25.8 44.37a21.92 21.92 0 01-1 2.51L366 410A19.14 19.14 0 01368.69 410.41zM374.68 412.06L396 448.76a24.05 24.05 0 01-.66 3.12l-23.73-40.83A27.92 27.92 0 01374.68 412.06zM382.17 416l14.08 24.22a28.06 28.06 0 01.15 4.5l-18.06-31.06c.71.38 1.45.79 2.14 1.23S381.63 415.65 382.17 416zM394.66 432.84L387.78 421A33.46 33.46 0 01394.66 432.84z" class="colorffedc5 svgShape"></path><path fill="#bdbcbc" d="M163.43,432.16h76.06a74.06,74.06,0,0,1,74.06,74.06v0a0,0,0,0,1,0,0H89.37a0,0,0,0,1,0,0v0A74.06,74.06,0,0,1,163.43,432.16Z" class="colora3a3a3 svgShape"></path><path fill="#e2e2e2" d="M119 484.14a4.12 4.12 0 11-8.23 0c0-2.27 2.84-2.12 5.12-2.12S119 481.87 119 484.14zM158.54 460.35c0 4.31-4.49 5.8-8.79 5.8a7.8 7.8 0 010-15.6C154.05 450.55 158.54 456.05 158.54 460.35zM226.68 461.28a7.8 7.8 0 01-7.8 7.8c-4.3 0-6.8-1.49-6.8-5.8s2.5-9.8 6.8-9.8A7.8 7.8 0 01226.68 461.28zM299.21 488.86c0 4.31-4.49 5.8-8.8 5.8a7.8 7.8 0 01-7.8-7.8c0-4.3 4.5-5.79 8.8-5.79A7.8 7.8 0 01299.21 488.86zM186.71 491.13a7.8 7.8 0 01-7.8 7.8c-4.31 0-8.8-5.49-8.8-9.8a7.8 7.8 0 017.8-7.8C182.21 481.33 186.71 486.83 186.71 491.13zM248.66 490.42c0 2.15-1.74 1.74-3.9 1.74s-2.89.26-2.89-1.9a3.9 3.9 0 013.89-3.9C247.92 486.36 248.66 488.26 248.66 490.42zM268.38 449.59c0 2.15-.75 5.89-2.9 5.89a3.9 3.9 0 01-3.9-3.89c0-2.16.75-5.9 2.9-5.9A3.9 3.9 0 01268.38 449.59zM197.94 442.71c0 2.56-3.08 2.63-5.64 2.63a4.64 4.64 0 010-9.27C194.86 436.07 197.94 440.15 197.94 442.71z" class="color7f7f7f svgShape"></path><ellipse cx="64.99" cy="471.99" fill="none" stroke="#f7bb66" stroke-miterlimit="10" rx="19.68" ry="34.1" class="colorStrokeffcd52 svgStroke"></ellipse><path fill="#ffcd52" d="M81.87,487c2.8-6.46.69-10.42.69-15,0-9.63-3.22-20.54-9-27.38a52.9,52.9,0,0,0-2.45,15.14C71.14,469.37,76.13,480.14,81.87,487Z" class="colorffcd52 svgShape"></path><ellipse cx="95.27" cy="459.81" fill="#ffffff" rx="19.68" ry="34.1" class="colorfff svgShape"></ellipse><path fill="#ffcd52" d="M47,473.06c0,3.8-1.54,6.84.57,12,9-7.21,15.83-19.31,15.83-31.78a56.08,56.08,0,0,0-1.9-13C52.4,447.41,47,460.59,47,473.06Z" class="colorffcd52 svgShape"></path><ellipse cx="40.15" cy="451.31" fill="#ffffff" rx="19.68" ry="34.1" class="colorfff svgShape"></ellipse><line x1="64.99" x2="64.99" y1="506.09" y2="454.95" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="57.02" y1="474.98" y2="465.87" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="53.5" y1="485.86" y2="472.73" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="53.13" y1="497.07" y2="483.51" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="74.65" y1="475" y2="463.95" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="76.85" y1="485.88" y2="472.32" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><line x1="64.99" x2="76.85" y1="497.09" y2="483.53" fill="none" stroke="#f7bb66" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeffcd52 svgStroke"></line><ellipse cx="40.15" cy="451.31" fill="none" stroke="#008ef8" stroke-miterlimit="10" rx="19.68" ry="34.1" class="colorStroke008ef8 svgStroke"></ellipse><polyline fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" points="40.15 434.27 40.15 485.41 40.15 506.22"></polyline><line x1="40.15" x2="30.51" y1="454.3" y2="443.27" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><line x1="40.15" x2="28.29" y1="465.18" y2="451.62" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><line x1="40.15" x2="28.29" y1="476.39" y2="462.83" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><line x1="40.15" x2="49.82" y1="454.32" y2="443.27" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><line x1="40.15" x2="52.01" y1="465.2" y2="451.64" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><line x1="40.15" x2="52.01" y1="476.41" y2="462.85" fill="none" stroke="#008ef8" stroke-linecap="round" stroke-linejoin="round" class="colorStroke008ef8 svgStroke"></line><ellipse cx="95.27" cy="459.81" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" rx="19.68" ry="34.1" class="colorStrokeff5061 svgStroke"></ellipse><polyline fill="none" stroke="#ff5061" stroke-linecap="round" stroke-linejoin="round" points="95.27 442.77 95.27 493.91 95.27 506.22"></polyline><line x1="95.27" x2="85.62" y1="462.8" y2="451.77" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1="95.27" x2="83.41" y1="473.68" y2="460.12" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1="95.27" x2="83.41" y1="484.89" y2="471.33" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1="95.27" x2="104.94" y1="462.83" y2="451.77" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1="95.27" x2="107.13" y1="473.7" y2="460.14" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1="95.27" x2="107.13" y1="484.92" y2="471.36" fill="none" stroke="#ff5a6c" stroke-linecap="round" stroke-linejoin="round" class="colorStrokeff5061 svgStroke"></line><line x1=".5" x2="390.32" y1="506.22" y2="506.22" fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" class="colorStroke545454 svgStroke"></line></g></g></svg></g></svg>
                                <h6 class="mt-4">This Is Not You're Looking For?</h6>
                                <a href="settings.html" class="btn btn-block btn-outline-primary">Go To Full Settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/Sidebar-right-->
    <!--/Sidebar-right-->


    <!-- Message Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-right chatbox" role="document">
            <div class="modal-content chat radius-7 border-0">
                <div class="card overflow-hidden mb-0 border-0">
                    <!-- action-header -->
                    <div class="action-header clearfix flex-between">
                        <div class="float-start hidden-xs d-flex align-items-center flex-1">
                            <div class="avatar avatar-md rounded-circle">
                                <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                            </div>
                            <div class="ms-2 mt-0">
                                <p class="tx-20 text-white mb-0 font-weight-semibold">Sarah Syd</p>
                                <span class="me-3 text-white tx-11 op-8">active now</span>
                            </div>
                        </div>
                        <div class="btn-list">
                            <a href="javascript:void(0)" class="btn btn-sm btn-def white text-white" data-bs-toggle="modal" data-bs-target="#audioModal"><i class="fe fe-phone"></i></a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-def white text-white" data-bs-toggle="modal" data-bs-target="#videoModal"><i class="fe fe-video"></i></a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-def white text-white" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)" class="dropdown-item"><i class="fe fe-user me-1"></i> View profile</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-item"><i class="fe fe-user-plus me-1"></i>Add friends</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-item"><i class="fe fe-plus me-1"></i> Add to group</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-item"><i class="fe fe-minus me-1"></i> Clear chat</a></li>
                                <li><a href="javascript:void(0)" class="dropdown-item"><i class="fe fe-slash me-1"></i> Block</a></li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-sm btn-def white text-white" data-bs-dismiss="modal"><i class="fe fe-x-circle"></i></a>
                        </div>
                    </div>
                    <!-- action-header end -->

                    <!-- msg_card_body -->
                    <div class="card-body msg_card_body">
                        <div class="chat-box-single-line">
                            <span class="timestamp">Today</span>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>Hi there! How are you?</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">8:10 AM</span>
                                </div>
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span> Hey I'm Waiting for your reply.</span>
                                    </div>
                                    <div class="msg_cotainer-main">
                                        <span>I've to go to outside....</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">8:35 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end chat_block">
                            <div class="msg_block_send">
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main">
                                        <span>Hi, I am coming there in few minutes. Please wait!</span>
                                    </div>
                                    <span class="msg_time_send">8:38 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>Ok Thanks!</span>
                                    </div>
                                    <div class="msg_cotainer-main">
                                        <span>I'm waiting for your message.</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">8:39 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end chat_block">
                            <div class="msg_block_send">
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main">
                                        <span>Hey, I am at Coffee shop you said</span>
                                    </div>
                                    <div class="msg_cotainer_send-main">
                                        <span>I can't see you here.</span>
                                    </div>
                                    <div class="msg_cotainer_send-main">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-def white"><i class="fe fe-play-circle"></i></a>
                                            <span class="mx-2">
														<svg  width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
														<svg  class="chat_audio" width="20" height="20"><defs></defs><g  transform="matrix(1,0,0,1,0,0)"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 3" viewBox="0 0 24 24" width="20" height="20"><path d="M6 19a1 1 0 0 1-1-1V6A1 1 0 0 1 7 6V18A1 1 0 0 1 6 19zM12 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 12 18zM9 21a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0V20A1 1 0 0 1 9 21zM3 17a1 1 0 0 1-1-1V8A1 1 0 0 1 4 8v8A1 1 0 0 1 3 17zM21 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 21 16zM15 16a1 1 0 0 1-1-1V9a1 1 0 0 1 2 0v6A1 1 0 0 1 15 16zM18 18a1 1 0 0 1-1-1V7a1 1 0 0 1 2 0V17A1 1 0 0 1 18 18z" fill="#7987a1" class="color000 svgShape"></path></svg></g></svg>
													</span>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-def white"><i class="fe fe-download"></i></a>
                                        </div>
                                    </div>
                                    <span class="msg_time_send">9:15 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>I just went to vegetable store.</span>
                                    </div>
                                    <div class="msg_cotainer-main">
                                        <span>You can come here or wait for just 5 min</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">9:15 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end chat_block">
                            <div class="msg_block_send">
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main">
                                        <span>Ok then I'll wait...</span>
                                    </div>
                                    <div class="msg_cotainer_send-main">
                                        <span>just call me or come inside to coffee shop when you came by</span>
                                    </div>
                                    <span class="msg_time_send">9:15 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>Deal... Bye</span>
                                    </div>
                                    <div class="msg_cotainer-main">
                                        <span>Enjoy your coffee</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">9:16 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end chat_block">
                            <div class="msg_block_send">
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main">
                                        <span>Definitely and Bye...</span>
                                    </div>
                                    <span class="msg_time_send">9:17 AM</span>
                                </div>
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main media-files">
                                        <img src="../assets/img/ecommerce/30.jpg" alt="img">
                                    </div>
                                    <span class="msg_time_send">9:30 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>I'm in coffee shop..</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">9:45 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end chat_block">
                            <div class="msg_block_send">
                                <div class="msg_container_send">
                                    <div class="msg_cotainer_send-main">
                                        <span>come to 8th number table</span>
                                    </div>
                                    <span class="msg_time_send">9:46 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start chat_block">
                            <div class="me-1 d-flex align-items-end">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/users/6.jpg" class="rounded-circle" alt="img">
                                </div>
                            </div>
                            <div class="msg_block">
                                <div class="msg_container">
                                    <div class="msg_cotainer-main">
                                        <span>Ok.. coming...</span>
                                    </div>
                                    <span class="tx-10 tx-muted msg_time">9:46 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- msg_card_body end -->

                    <!-- card-footer -->
                    <div class="card-footer">
                        <div class="form-group mb-0 d-flex">
                            <div class="input-group pos-relative">
                                <input type="text" class="form-control radius-4" placeholder="Type something here...">
                                <div class="chat_input_icons">
                                    <a href="javascript:void(0)" class="tx-muted me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="emoji"><i class="ti-face-smile"></i></a>
                                    <a href="javascript:void(0)" class="tx-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="attach files"><i class="fe fe-paperclip"></i></a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-circle ms-2">
                                <i class="far fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div><!-- card-footer end -->
                </div>
            </div>
        </div>
    </div><!-- /modal -->

    <!--Video Modal -->
    <div id="videoModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body mx-auto text-center p-7">
                    <h5>Zem Video call</h5>
                    <img src="../assets/img/users/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
                    <h4 class="mb-1 font-weight-semibold">Daneil Scott</h4>
                    <h6>Calling...</h6>
                    <div class="flex-center mt-4 p-2">
                        <a class="btn btn-outline-primary rounded-circle ht-40 wd-40 flex-center" href="javascript:void(0);">
                            <i class="fas fa-volume-up"></i>
                        </a>
                        <a class="btn btn-danger rounded-circle ht-50 wd-50 flex-center mx-3" href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a class="btn btn-outline-primary rounded-circle ht-40 wd-40 flex-center" href="javascript:void(0);">
                            <i class="fas fa-microphone-slash"></i>
                        </a>
                    </div>
                </div><!-- modal-body -->
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!-- Audio Modal -->
    <div id="audioModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body mx-auto text-center p-7">
                    <h5>Zem Voice call</h5>
                    <img src="../assets/img/users/6.jpg" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
                    <h4 class="mb-1  font-weight-semibold">Daneil Scott</h4>
                    <h6>Calling...</h6>
                    <div class="flex-center mt-4 p-2">
                        <a class="btn btn-outline-primary rounded-circle ht-40 wd-40 flex-center" href="javascript:void(0);">
                            <i class="fas fa-volume-up"></i>
                        </a>
                        <a class="btn btn-danger rounded-circle ht-50 wd-50 flex-center mx-3" href="javascript:void(0);" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a class="btn btn-outline-primary rounded-circle ht-40 wd-40 flex-center" href="javascript:void(0);">
                            <i class="fas fa-microphone-slash"></i>
                        </a>
                    </div>
                </div><!-- modal-body -->
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->



</div>
<!-- End Page -->
</body>
<?php display_new_js(); ?>
</html>

