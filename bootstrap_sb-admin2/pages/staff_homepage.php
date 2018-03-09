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

    <!-- MetisMenu CSS -->

    <!-- Custom CSS -->

    <!-- Custom Fonts -->

    
    <link href="../css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper"></div>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Staff Homepage</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-print fa-fw"></i>Start Print
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-2">
                            <h1 class="text-center">#7</h1>
                        </div>
                         <div class="col-lg-5">
                            <div class="form-group">
                                <label>MavID</label>
                                <select class="form-control">
                                    <option>1001244463</option>
                                    <option>1001457294</option>
                                    <option>1001936203</option>
                                    <option>1001934034</option>
                                </select>
                            </div>
                         </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Equipment</label>
                                <select class="form-control">
                                    <option>PolyPrinter1</option>
                                    <option>PolyPrinter2</option>
                                    <option>PolyPrinter3</option>
                                    <option>PolyPrinter4</option>
                                </select>
                            </div>
                        </div>
                        </div>
                            <a href="#" class="btn btn-default btn-block">Start</a>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                  <div class="col-lg-13">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-ticket fa-fw"></i>Equipment Status
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img class="img-fluid m-2" src="../images/polyprinter.svg" alt="Card image cap" style="max-height:100px;">
                                </div>
                                <div class="col-sm-3">
                                    <img class="img-fluid" src="../images/laser.svg" alt="Card image cap" style="max-height:100px;">
                                </div>
                                <div class="col-sm-3">
                                    <img class="img-fluid" src="../images/sewing-machine.svg" alt="Card image cap" style="max-height:100px;">
                                </div>
                                <div class="col-sm-3">
                                    <img class="img-fluid" src="../images/uPrint.svg" alt="Card image cap" style="max-height:100px;">
                                </div>
                            </div>
                        </div>
                        </div>
                            <a href="#" class="btn btn-default btn-block">Manage</a>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                  </div>
                  <!-- /.col-lg-13 -->

                <div class="col-lg-13">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-print fa-fw"></i>Materials
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row text-center">
                                <img class="img-fluid m-2" src="../images/items.svg" alt="Card image cap" style="max-height:200px;">
                            </div>
                            <a href="#" class="btn btn-default btn-block">Manage</a>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-13 -->
                <div class="col-lg-13">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-ticket fa-fw"></i>Manage Quotes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#polyprinter" data-toggle="tab">PolyPrinter</a>
                                </li>
                                <li><a href="#vinyl" data-toggle="tab">Vinyl</a>
                                </li>
                                <li><a href="#uprint" data-toggle="tab">uPrint</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="polyprinter">
                                    <h4>PolyPrinter Quote Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="tab-pane fade" id="vinyl">
                                    <h4>Vinyl Quote Tab</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Vinyl Price</label>
                                                <input class="form-control" placeholder="Enter New Vinyl Price per Inch">
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-12">
                                        <a href="#" class="btn btn-default btn-block">Generate</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="uprint">
                                    <h4>uPrint Quote Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-13 -->
                </div>
                <!-- /.col-lg-6 -->

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-ticket fa-fw"></i>Make Ticket
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-12">
                            <h3 class="text-center">Next Issuable Ticket Number:</h3> 
                            <h3 class="text-center">#8</h3>
                        </div>
                        </div>
                        <div class="row">
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>MavID</label>
                                <input class="form-control" placeholder="Enter ID Number">
                            </div>
                         </div>
                        </div>
                            <a href="#" class="btn btn-default btn-block">Generate</a>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                <div class="col-lg-13">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-ticket fa-fw"></i>Currently Waiting Users
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ticket #</th>
                                            <th>MavID</th>
                                            <th>Time Left</th>
                                            <th>Cancel Wait</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1001346923</td>
                                            <td>01:12:02</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>1001946023</td>
                                            <td>02:52:15</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>1001929123</td>
                                            <td>02:59:23</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>1001948285</td>
                                            <td>03:31:14</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>1001935024</td>
                                            <td>03:45:46</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>1001935025</td>
                                            <td>04:14:32</td> <td><div style="text-align: center"><button class="btn btn-danger btn-circle" type="button"><i class="glyphicon glyphicon-remove"></i></button></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-13 -->
                </div>
                <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    <!-- /#wrapper --> 

</body>
<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</html>
