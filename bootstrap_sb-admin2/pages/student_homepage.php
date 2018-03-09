<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$device_array = array();
$_SESSION['type'] = "home";

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <!-- Bootstrap Core CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Student Homepage</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Current Wait - 3D Printer
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <h6>
                                        Number
                                    </h6>
                                    <h2>
                                        #7
                                    </h2>
                                </div>
                                <div class="col-lg-8">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Est. Wait:</strong>
                                            <span class="pull-right text-muted">60 Minutes</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width: 55%">
                                                <span class="sr-only">55% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12" style="text-align: center">
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                        <div class="col-lg-13">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                Active Job - 3D Printer
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Polyprinter #4</strong>
                                            <span class="pull-right text-muted">40 Minute Wait</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                                <span class="sr-only">75% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>
                                        Started at ....
                                    </h6>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    
                    <!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Current Wait - Laser
                            </div>
                            <div class="panel-body">
                                  <div class="col-lg-4">
                                    <h6>
                                        Number
                                    </h6>
                                    <h2>
                                        #8
                                    </h2>
                                </div>
                                <div class="col-lg-8">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Est. Wait:</strong>
                                            <span class="pull-right text-muted">40 Minutes</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                                <span class="sr-only">75% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="text-align: center">
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                        <div class="col-lg-13">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                Active Job - Laser
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Laser #1</strong>
                                            <span class="pull-right text-muted">40 Minute Wait</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                                <span class="sr-only">75% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <h6>
                                        Started at ....
                                    </h6>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Receive Alerts
                            </div>
                            <div class="panel-body" style="margin-top: 35px">
                                <div class="form-group">
                                    <label><i class="fa fa-phone"></i> Phone Number</label>
                                    <input class="form-control" placeholder="Enter text">
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-envelope"></i> Email Address</label>
                                    <input class="form-control" placeholder="Enter text">
                                </div>
                                <div class="form-group" style="margin-top: 50px">
                                    <label><i class="fa fa-info-circle"></i> Disclaimer</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="">I have read and understand the <a>FERPA release policies</a>.
                                        </label>
                                    </div>
                                </div>
                                <div style="text-align: center">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

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
