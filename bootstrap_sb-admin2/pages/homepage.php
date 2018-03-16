<!DOCTYPE html>
<html lang="en">

<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$device_array = array();
$_SESSION['type'] = "home";
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../dist/css/custom-styles.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#">
                                <i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="login.html">
                                <i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html">
                                <i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Charts
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html">
                                <i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html">
                                <i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-wrench fa-fw"></i> UI Elements
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level
                                        <span class="fa arrow"></span>
                                    </a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="active">
                            <a href="#">
                                <i class="fa fa-files-o fa-fw"></i> Sample Pages
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active" href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">

                    <!-- Overview-->
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label>
                                    <i class="fa fa-gears"></i> Overview </label>
                            </div>

                            <!-- PolyPrinter Status -->
                            <div class="panel-body">
                                <div class="row text-center">
                                    <div class="col-xs-12 col-sm-3">
                                        <h3>PolyPrinters</h3>
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <h3>#2</h3>
                                        <p>Now Serving</p>
                                    </div>

                                    <!-- Estimated Remaining Time -->
                                    <div class="col-xs-4 col-sm-3">
                                    <?php 
                                    
                                    // Returns the wait time (if any) as an overview
                                    if ($result = $mysqli->query("
                                        SELECT COUNT(*) AS NumFreeDevices
                                        FROM devices
                                        JOIN device_group ON devices.dg_id = device_group.dg_id
                                        WHERE device_group.dg_id = 2 AND
                                              devices.device_desc NOT IN (
                                          
                                            SELECT device_desc
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 2 AND
                                                   status_id < 12
                                        );
                                    "))
                                    {
                                        // If the number of free devices is greater than zero than there should be not wait
                                        if ($row  = $result->fetch_assoc() )
                                        {
                                            ?> 
                                                <h3> No Wait </h3>
                                                <p>Wait Time</p>
                                            <?php
                                        }

                                        // Since there are no open printers, find the least wait time
                                        else
                                        {
                                            if ($result = $mysqli->query("
                                            SELECT device_desc, t_start, est_time
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 2 AND
                                                   status_id < 12;
                                            "))
                                            {
                                                global $min_time;
                                                $row  = $result->fetch_assoc();
                                                if ($row["NumFreeDevices"] > 0 )
                                                {   
                                                    // If the device has a start time, then find the lowest wait time
                                                    if ($row["t_start"])
                                                    {
                                                        if (isset($min_time))
                                                        {
                                                            if ($min_time > $row["est_time"])
                                                                $min_time = $row["est_time"];
                                                        }
                                                        else
                                                        {
                                                            $min_time = $row["est_time"];
                                                        }
                                                    }   
                                                }

                                                // Display the wait time according to hours (if greater than 2) or minutes
                                                if (isset($min_time))
                                                {
                                                    sscanf($min_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                    // Display the time as hours only
                                                    if ($hours > 2)
                                                    {
                                                        ?> 
                                                            <h3> <?php echo $hours ?> </h3>
                                                            <p>Hour Wait</p>
                                                        <?php
                                                    }
                                                    // Display the time as minutes
                                                    else
                                                    {
                                                        ?> 
                                                            <h3> <?php echo ($hours * 60) + $minutes ?> </h3>
                                                            <p>Minute Wait</p>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }    
                                    }
                                    ?>  
                                    </div>
                                    <div class="col-sm-3">
                                        <h3>#3</h3>
                                        <p>Next Issuable Number</p>
                                    </div>
                                </div>

                                <!-- Laser Status -->
                                <div class="row text-center">
                                    <div class="col-xs-12 col-sm-3">
                                        <h3>Lasers</h3>
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <h3>#L2</h3>
                                        <p>Now Serving</p>
                                    </div>
                                    
                                    <!-- Estimated Remaining Time -->
                                    <div class="col-xs-4 col-sm-3">
                                    <?php 
                                    // Returns the wait time (if any) as an overview
                                    if ($result = $mysqli->query("
                                        SELECT COUNT(*) AS NumFreeDevices
                                        FROM devices
                                        JOIN device_group ON devices.dg_id = device_group.dg_id
                                        WHERE device_group.dg_id = 4 AND
                                              devices.device_desc NOT IN (
                                          
                                            SELECT device_desc
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 4 AND
                                                   status_id < 12
                                        );
                                    "))
                                    {
                                        // If the number of free devices is greater than zero than there should be not wait
                                        $row  = $result->fetch_assoc();
                                        if ($row["NumFreeDevices"] > 0 )
                                        {
                                            ?> 
                                                <h3> No Wait </h3>
                                                <p>Wait Time</p>
                                            <?php
                                        }

                                        // Since there are no open printers, find the least wait time
                                        else
                                        {
                                            // Get all of the used devices and their estimated times of completion
                                            if ($result = $mysqli->query("
                                            SELECT device_desc, t_start, est_time
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 4 AND
                                                   status_id < 12;
                                            "))
                                            {
                                                global $min_time;
                                                while ( $row = $result->fetch_assoc() )
                                                {   
                                                    // If the device has a start time, then find the lowest wait time
                                                    if ($row["t_start"])
                                                    {
                                                        if (isset($min_time))
                                                        {
                                                            if ($min_time > $row["est_time"])
                                                                $min_time = $row["est_time"];
                                                        }
                                                        else
                                                        {
                                                            $min_time = $row["est_time"];
                                                        }
                                                    }   
                                                }

                                                // Display the wait time according to hours (if greater than 2) or minutes
                                                if (isset($min_time))
                                                {
                                                    sscanf($min_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                    // Display the time as hours only
                                                    if ($hours > 2)
                                                    {
                                                        ?> 
                                                            <h3> <?php echo $hours ?> </h3>
                                                            <p>Hour Wait</p>
                                                        <?php
                                                    }
                                                    // Display the time as minutes
                                                    else
                                                    {
                                                        ?> 
                                                            <h3> <?php echo ($hours * 60) + $minutes ?> </h3>
                                                            <p>Minute Wait</p>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }    
                                    }
                                    ?>  
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <h3>#L0</h3>
                                        <p>Next Issuable Number</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quotes -->
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label><i class="fa fa-ticket fa-fw"></i>Quotes</label>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#polyprinter" data-toggle="tab">PolyPrinter</a>
                                    </li>
                                    <li>
                                        <a href="#vinyl" data-toggle="tab">Vinyl</a>
                                    </li>
                                    <li>
                                        <a href="#uprint" data-toggle="tab">uPrint</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="polyprinter">
                                        <h4>PolyPrinter Quote Tab</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input id="polyprinter-input" class="form-control" onkeyup="polyPrinter()" onchange="polyPrinter()" type="number" min="0"
                                                        max="1000" step=".5" autocomplete="off" placeholder="Enter PolyPrinter Material">
                                                    <label for="form1" class="">Grams</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h2 id="polyprinter-output" class="font-medium text-center">
                                                    $0.00
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="vinyl">
                                        <h4>Vinyl Quote Tab</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input id="vinyl-input" class="form-control" onkeyup="vinyl()" onchange="vinyl()" type="number" min="0" max="1000" step=".5"
                                                        autocomplete="off" placeholder="Enter Vinyl Material">
                                                    <label for="form1" class="">Inches</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h2 id="vinyl-output" class="font-medium text-center">
                                                    $0.00
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="uprint">
                                        <h4>uPrint Quote Tab</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input id="uPrint-material-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000"
                                                        step=".5" autocomplete="off" placeholder="Enter Model Material">
                                                    <label for="form1" class="">Model in
                                                        <sup> 3</sup>
                                                    </label>
                                                </div>
                                                <div class="col-lg-13">
                                                    <div class="form-group">
                                                        <input id="uPrint-support-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000"
                                                            step=".5" autocomplete="off" placeholder="Enter Support Material">
                                                        <label for="form1" class="">Support in
                                                            <sup> 3</sup>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h2 id="uPrint-output" class="font-medium text-center">
                                                    $0.00
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment Status -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label>
                                    <i class="fa fa-tasks"></i> Equipment Status</label>
                            </div>
                            <!-- Tabs -->
                            <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="">
                                        <a href="#all" data-toggle="tab" aria-expanded="false">All</a>
                                    </li>
                                    <li class="active">
                                        <a href="#polyprinters" data-toggle="tab" aria-expanded="true">PolyPrinters</a>
                                    </li>
                                    <li class="">
                                        <a href="#lasers" data-toggle="tab" aria-expanded="false">Lasers</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <!-- Equipment Status : All Devices -->
                                    <div class="tab-pane fade" id="all">
                                    <table class="table table-striped table-bordered table-hover" id="indexTable">
                        <thead>
                            <tr class="tablerow">
                                <th align="right">Ticket</td>
                                <th>Device</td>
                                <th>Start Time</td>
                                <th>Est Time Left</td>
                                <th>Progress </td>
                                <?php if ($staff) { ?> <th>Action</th><?php } ?>
                            </tr>
                        </thead>
                        <?php if ($result = $mysqli->query("
                            SELECT trans_id, device_desc, t_start, est_time, devices.dg_id, dg_parent, devices.d_id, url, operator, status_id
                            FROM devices
                            JOIN device_group
                            ON devices.dg_id = device_group.dg_id
                            LEFT JOIN (SELECT trans_id, t_start, t_end, est_time, d_id, operator, status_id FROM transactions WHERE status_id < 12 ORDER BY trans_id DESC) as t 
                            ON devices.d_id = t.d_id
                            WHERE public_view = 'Y'
                            ORDER BY dg_id, `device_desc`
                        ")){
                            while ( $row = $result->fetch_assoc() )
                            { ?>
                                <tr class="tablerow">
                                    <!-- if there is a print for this device -->
                                    <?php if($row["t_start"]) 
                                    {
                                        //create a new transaction based off of the ID which will fill all of the fields of a transaction
                                        $ticket = new Transactions($row['trans_id']); ?>
                                        
                                        <!-- Print the Ticket Number -->
                                        <td align="right">
                                            <?php
                                                echo ("<a href=\"pages/lookup.php?trans_id=$row[trans_id]\">$row[trans_id]</a>"); 
                                            ?>
                                        </td>

                                        <!-- Print the Device Name -->
                                        <td>
                                            <?php 
                                            // Show Devices that have a URL attached to them that will give more information
                                            if($ticket->getDevice()->getUrl() && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            {
                                                    Devices::printDot($staff, $row['d_id'], $ticket->getDevice()->getD_id());
                                                    //echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                                    echo ("<a href=\"http://".$ticket->getDevice()->getUrl()."\">".$ticket->getDevice()->getDevice_desc()."</a>");
                                            ?>
                                            
                                            <?php
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $ticket->getDevice()->getD_id());
                                                echo $ticket->getDevice()->getDevice_desc();
                                            } 
                                            ?>
                                        </td>
                                        
                                        <!-- Show the Job Start Time --> 
                                        <?php 
                                        
                                        echo("<td>".date( 'M d g:i a',strtotime($row["t_start"]) )."</td>" );
                                        
                                        //If the print has completed and the print needs to be moved
                                        if ( $row["status_id"] == 11) 
                                        {
                                            echo("<td align='center'>".$ticket->getStatus()->getMsg()."</td>"); // Status note for Est. Time
                                            echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                        } 

                                        // If the print is still printing
                                        elseif (isset($row["est_time"])) 
                                        {
                                            echo("<td align='center'><div id=\"est".$row["trans_id"]."\">".$row["est_time"]." </div></td>" );
                                            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["est_time"]);
                                            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($row["t_start"]) ) + $sv["grace_period"];
                                            array_push($device_array, array($row["trans_id"], $time_seconds, $row["dg_parent"]));

                                            //Estimated Time Remaining Progress Bar
                                            ?>
                                            <td> <div class="progress active">
                                                <div class="progress-bar  progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                     style="width:
                                                        <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($row["est_time"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($row["t_start"])) / ((strtotime("now") - strtotime($row["t_start"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                                        "/>
                                            </div> </td>
                                            <?php
                                        } 

                                        // There is no job printing for this device
                                        else 
                                        {
                                            echo("<td align=\"center\">-</td>"); // Nothing for the Est Time Left
                                            echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                        }
                                            

                                            
                                        // Actions for Staff Members
                                        if ($staff && ($staff->getRoleID() >= $sv['LvlOfStaff'] || $staff->getOperator() == $ticket->getUser()->getOperator())) 
                                        { 
                                            ?>
                                            <td align="center">
                                                <button onclick="endTicket(<?php echo $row["trans_id"].",'".$row["device_desc"]."'"; ?>)">End Ticket</button>
                                            </td>
                                        <?php 
                                        } 
                                        elseif ($staff) 
                                        {
                                            echo("<td align='center'></td>");
                                        }
                                    } 

                                    // If there is no print for the device
                                    else 
                                    {
                                        ?>
                                        <td align="right"></td>
                                        <td>
                                            <?php 

                                            // Show Devices that have a URL attached to them that will give more information
                                            if($row['url'] && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            { 
                                                Devices::printDot($staff, $row['d_id']);
                                                echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $row['d_id']);
                                                echo $row['device_desc'];
                                            } 
                                            ?>
                                        </td>

                                        <!-- Show that there is NO Start Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time Progress Bar -->
                                        <td align="center"> - </td>
                                        
                                        <!-- Allow a staff member to create a new ticket -->
                                        <?php 
                                        if($row["url"] && $staff)
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td  align="center"><?php echo ("<a href=\"http://".$row["url"]."\">New Ticket</a>"); ?></td>
                                                <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                        elseif($staff) 
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td align="center"><div id="est"><a href="\pages\create.php?<?php echo("d_id=".$row["d_id"])?>">New Ticket</a></div></td>
                                            <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                    } ?>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                </div>

                                    <!-- Equipment Status : PolyPrinters -->
                                    <div class="tab-pane active in" id="polyprinters">
                                    <table class="table table-striped table-bordered table-hover" id="indexTable">
                        <thead>
                            <tr class="tablerow">
                                <th align="right">Ticket</td>
                                <th>Device</td>
                                <th>Start Time</td>
                                <th>Est Time Left</td>
                                <th>Progress </td>
                                <?php if ($staff) { ?> <th>Action</th><?php } ?>
                            </tr>
                        </thead>
                        <?php if ($result = $mysqli->query("
                            SELECT trans_id, device_desc, t_start, est_time, devices.dg_id, dg_parent, devices.d_id, url, operator, status_id
                            FROM devices
                            JOIN device_group
                            ON devices.dg_id = device_group.dg_id
                            LEFT JOIN (SELECT trans_id, t_start, t_end, est_time, d_id, operator, status_id FROM transactions WHERE status_id < 12 ORDER BY trans_id DESC) as t 
                            ON devices.d_id = t.d_id
                            WHERE public_view = 'Y' AND 
                                  ( devices.dg_id = 2 OR devices.dg_id = 15)
                            ORDER BY dg_id, `device_desc`
                        ")){
                            while ( $row = $result->fetch_assoc() )
                            { ?>
                                <tr class="tablerow">
                                    <!-- if there is a print for this device -->
                                    <?php if($row["t_start"]) 
                                    {
                                        //create a new transaction based off of the ID which will fill all of the fields of a transaction
                                        $ticket = new Transactions($row['trans_id']); ?>
                                        
                                        <!-- Print the Ticket Number -->
                                        <td align="right">
                                            <?php
                                                echo ("<a href=\"pages/lookup.php?trans_id=$row[trans_id]\">$row[trans_id]</a>"); 
                                            ?>
                                        </td>

                                        <!-- Print the Device Name -->
                                        <td>
                                            <?php 
                                            // Show Devices that have a URL attached to them that will give more information
                                            if($ticket->getDevice()->getUrl() && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            {
                                                    Devices::printDot($staff, $row['d_id'], $ticket->getDevice()->getD_id());
                                                    //echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                                    echo ("<a href=\"http://".$ticket->getDevice()->getUrl()."\">".$ticket->getDevice()->getDevice_desc()."</a>");
                                            ?>
                                            
                                            <?php
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $ticket->getDevice()->getD_id());
                                                echo $ticket->getDevice()->getDevice_desc();
                                            } 
                                            ?>
                                        </td>
                                        
                                        <!-- Show the Job Start Time --> 
                                        <?php 
                                        
                                        echo("<td>".date( 'M d g:i a',strtotime($row["t_start"]) )."</td>" );
                                        
                                        //If the print has completed and the print needs to be moved
                                        if ( $row["status_id"] == 11) 
                                        {
                                            echo("<td align='center'>".$ticket->getStatus()->getMsg()."</td>");
                                        } 

                                        // If the print is still printing
                                        elseif (isset($row["est_time"])) 
                                        {
                                            echo("<td align='center'><div id=\"est".$row["trans_id"]."\">".$row["est_time"]." </div></td>" );
                                            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["est_time"]);
                                            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($row["t_start"]) ) + $sv["grace_period"];
                                            array_push($device_array, array($row["trans_id"], $time_seconds, $row["dg_parent"]));

                                            //Estimated Time Remaining Progress Bar
                                            ?>
                                            <td> <div class="progress active">
                                            <div class="progress-bar  progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                     style="width:
                                                        <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($row["est_time"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($row["t_start"])) / ((strtotime("now") - strtotime($row["t_start"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                                        "/>
                                            </div> </td>
                                            <?php
                                        } 

                                        // There is no job printing for this device
                                        else 
                                        {
                                            echo("<td align=\"center\">-</td>"); // Nothing for the Est Time Left
                                            echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                        }
                                            

                                            
                                        // Actions for Staff Members
                                        if ($staff && ($staff->getRoleID() >= $sv['LvlOfStaff'] || $staff->getOperator() == $ticket->getUser()->getOperator())) 
                                        { 
                                            ?>
                                            <td align="center">
                                                <button onclick="endTicket(<?php echo $row["trans_id"].",'".$row["device_desc"]."'"; ?>)">End Ticket</button>
                                            </td>
                                        <?php 
                                        } 
                                        elseif ($staff) 
                                        {
                                            echo("<td align='center'></td>");
                                        }
                                    } 

                                    // If there is no print for the device
                                    else 
                                    {
                                        ?>
                                        <td align="right"></td>
                                        <td>
                                            <?php 

                                            // Show Devices that have a URL attached to them that will give more information
                                            if($row['url'] && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            { 
                                                Devices::printDot($staff, $row['d_id']);
                                                echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $row['d_id']);
                                                echo $row['device_desc'];
                                            } 
                                            ?>
                                        </td>

                                        <!-- Show that there is NO Start Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time Progress Bar -->
                                        <td align="center"> - </td>
                                        
                                        <!-- Allow a staff member to create a new ticket -->
                                        <?php 
                                        if($row["url"] && $staff)
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td  align="center"><?php echo ("<a href=\"http://".$row["url"]."\">New Ticket</a>"); ?></td>
                                                <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                        elseif($staff) 
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td align="center"><div id="est"><a href="\pages\create.php?<?php echo("d_id=".$row["d_id"])?>">New Ticket</a></div></td>
                                            <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                    } ?>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                                    </div>

                                    <!-- Equipment Status : Lasers -->
                                    <div class="tab-pane fade" id="lasers">
                                    <table class="table table-striped table-bordered table-hover" id="indexTable">
                        <thead>
                            <tr class="tablerow">
                                <th align="right">Ticket</td>
                                <th>Device</td>
                                <th>Start Time</td>
                                <th>Est Time Left</td>
                                <th>Progress </td>
                                <?php if ($staff) { ?> <th>Action</th><?php } ?>
                            </tr>
                        </thead>
                        <?php if ($result = $mysqli->query("
                            SELECT trans_id, device_desc, t_start, est_time, devices.dg_id, dg_parent, devices.d_id, url, operator, status_id
                            FROM devices
                            JOIN device_group
                            ON devices.dg_id = device_group.dg_id
                            LEFT JOIN (SELECT trans_id, t_start, t_end, est_time, d_id, operator, status_id FROM transactions WHERE status_id < 12 ORDER BY trans_id DESC) as t 
                            ON devices.d_id = t.d_id
                            WHERE public_view = 'Y' AND devices.dg_id = 4
                            ORDER BY dg_id, `device_desc`
                        ")){
                            while ( $row = $result->fetch_assoc() )
                            { ?>
                                <tr class="tablerow">
                                    <!-- if there is a print for this device -->
                                    <?php if($row["t_start"]) 
                                    {
                                        //create a new transaction based off of the ID which will fill all of the fields of a transaction
                                        $ticket = new Transactions($row['trans_id']); ?>
                                        
                                        <!-- Print the Ticket Number -->
                                        <td align="right">
                                            <?php
                                                echo ("<a href=\"pages/lookup.php?trans_id=$row[trans_id]\">$row[trans_id]</a>"); 
                                            ?>
                                        </td>

                                        <!-- Print the Device Name -->
                                        <td>
                                            <?php 
                                            // Show Devices that have a URL attached to them that will give more information
                                            if($ticket->getDevice()->getUrl() && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            {
                                                    Devices::printDot($staff, $row['d_id'], $ticket->getDevice()->getD_id());
                                                    //echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                                    echo ("<a href=\"http://".$ticket->getDevice()->getUrl()."\">".$ticket->getDevice()->getDevice_desc()."</a>");
                                            ?>
                                            
                                            <?php
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $ticket->getDevice()->getD_id());
                                                echo $ticket->getDevice()->getDevice_desc();
                                            } 
                                            ?>
                                        </td>
                                        
                                        <!-- Show the Job Start Time --> 
                                        <?php 
                                        
                                        echo("<td>".date( 'M d g:i a',strtotime($row["t_start"]) )."</td>" );
                                        
                                        //If the print has completed and the print needs to be moved
                                        if ( $row["status_id"] == 11) 
                                        {
                                            echo("<td align='center'>".$ticket->getStatus()->getMsg()."</td>");
                                        } 

                                        // If the print is still printing
                                        elseif (isset($row["est_time"])) 
                                        {
                                            echo("<td align='center'><div id=\"est".$row["trans_id"]."\">".$row["est_time"]." </div></td>" );
                                            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["est_time"]);
                                            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($row["t_start"]) ) + $sv["grace_period"];
                                            array_push($device_array, array($row["trans_id"], $time_seconds, $row["dg_parent"]));

                                            //Estimated Time Remaining Progress Bar
                                            ?>
                                            <td> <div class="progress active">
                                            <div class="progress-bar  progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                     style="width:
                                                        <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($row["est_time"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($row["t_start"])) / ((strtotime("now") - strtotime($row["t_start"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                                        "/>
                                            </div> </td>
                                            <?php
                                        } 

                                        // There is no job printing for this device
                                        else 
                                        {
                                            echo("<td align=\"center\">-</td>"); // Nothing for the Est Time Left
                                            echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                        }
                                            

                                            
                                        // Actions for Staff Members
                                        if ($staff && ($staff->getRoleID() >= $sv['LvlOfStaff'] || $staff->getOperator() == $ticket->getUser()->getOperator())) 
                                        { 
                                            ?>
                                            <td align="center">
                                                <button onclick="endTicket(<?php echo $row["trans_id"].",'".$row["device_desc"]."'"; ?>)">End Ticket</button>
                                            </td>
                                        <?php 
                                        } 
                                        elseif ($staff) 
                                        {
                                            echo("<td align='center'></td>");
                                        }
                                    } 

                                    // If there is no print for the device
                                    else 
                                    {
                                        ?>
                                        <td align="right"></td>
                                        <td>
                                            <?php 

                                            // Show Devices that have a URL attached to them that will give more information
                                            if($row['url'] && (preg_match($sv['ip_range_1'],getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'],getenv('REMOTE_ADDR'))) )
                                            { 
                                                Devices::printDot($staff, $row['d_id']);
                                                echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                            } 

                                            // Show Devices that do not have a URL attached to them
                                            else 
                                            {
                                                Devices::printDot($staff, $row['d_id']);
                                                echo $row['device_desc'];
                                            } 
                                            ?>
                                        </td>

                                        <!-- Show that there is NO Start Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time -->
                                        <td align="center"> - </td>

                                        <!-- Show that there is NO End Time Progress Bar -->
                                        <td align="center"> - </td>
                                        
                                        <!-- Allow a staff member to create a new ticket -->
                                        <?php 
                                        if($row["url"] && $staff)
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td  align="center"><?php echo ("<a href=\"http://".$row["url"]."\">New Ticket</a>"); ?></td>
                                                <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                        elseif($staff) 
                                        {
                                            if ($staff->getRoleID() > 6)
                                            {
                                                ?>
                                                <td align="center"><div id="est"><a href="\pages\create.php?<?php echo("d_id=".$row["d_id"])?>">New Ticket</a></div></td>
                                            <?php 
                                            }
                                            else
                                                echo("<td align=\"center\">-</td>");
                                        }
                                    } ?>
                                </tr>
                            <?php }
                        } ?>
                    </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                    <!-- Materials -->
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label>
                                    <i class="fa fa-suitcase"></i> Inventory </label>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th><i class="fas fa-paint-brush fa-fw"></i></th>
                                            <?php if ($staff && $staff->getRoleID() >= $sv['LvlOfStaff']){?>
                                                    <th>Qty on Hand</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php //Display Inventory Based on device group
                                    if($result = $mysqli->query("
                                        SELECT `m_name`, SUM(unit_used) as `sum`, `color_hex`, `unit`
                                        FROM `materials`
                                        LEFT JOIN `mats_used`
                                        ON mats_used.m_id = `materials`.`m_id`
                                        WHERE `m_parent` = 1
                                        GROUP BY `m_name`, `color_hex`, `unit`
                                        ORDER BY `m_name` ASC;
                                    ")){
                                        while ($row = $result->fetch_assoc()){
                                            if ($staff && $staff->getRoleID() >= $sv['LvlOfStaff']){ ?>
                                                <tr>
                                                    <td><?php echo $row['m_name']; ?></td>
                                                    <td><div class="color-box" style="background-color: #<?php echo $row['color_hex'];?>;"/></td>
                                                    <td><?php echo number_format($row['sum'])." ".$row['unit']; ?></td>
                                                </tr>
                                            <?php } else {?>
                                                <tr>
                                                    <td><?php echo $row['m_name']; ?></td>
                                                    <td><div class="color-box" style="background-color: #<?php echo $row['color_hex'];?>;"/></td>
                                                </tr>
                                            <?php }
                                        }
                                    } else { ?>
                                        <tr><td colspan="3">None</td></tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <script type="text/javascript">
        function polyPrinter() {
            var rate = 0.05;
            var volume = document.getElementById("polyprinter-input").value;
            var total = (volume * rate).toFixed(2);
            document.getElementById("polyprinter-output").innerHTML = "$ " + total;
        }

        function vinyl() {
            var rate = 0.05;
            var length = document.getElementById("vinyl-input").value;
            var total = (rate * length).toFixed(2);
            document.getElementById("vinyl-output").innerHTML = "$" + total;
        }
        function uPrint() {
            var conv_rate = 16.387
            var rate1 = 0.5;
            var rate2 = 0.5;
            var volume1 = document.getElementById("uPrint-material-input").value;
            var volume2 = document.getElementById("uPrint-support-input").value;
            var total = ((volume1 * conv_rate * rate1) + (volume2 * conv_rate * rate2)).toFixed(2);
            document.getElementById("uPrint-output").innerHTML = "$" + total;
        }
    </script>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>