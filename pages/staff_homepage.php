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
                            <i class="fa fa-ticket fa-fw"></i>View and Manage Quotes
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
                                <li><a href="#manage" data-toggle="tab">Manage</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="polyprinter">
                                    <h4>PolyPrinter Quote Tab</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input id="polyprinter-input" class="form-control" onkeyup="polyPrinter()" onchange="polyPrinter()" type="number" min="0" max="1000" step=".5" autocomplete="off" placeholder="Enter PolyPrinter Material">
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
                                                <input id="vinyl-input" class="form-control" onkeyup="vinyl()" onchange="vinyl()" type="number" min="0" max="1000" step=".5" autocomplete="off" placeholder="Enter Vinyl Material">
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
                                                <input id="uPrint-material-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000" step=".5" autocomplete="off" placeholder="Enter Model Material">
                                                <label for="form1" class="">Model in<sup> 3</sup></label>
                                            </div>
                                        <div class="col-lg-13">
                                            <div class="form-group">
                                                <input id="uPrint-support-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000" step=".5" autocomplete="off" placeholder="Enter Support Material">
                                                <label for="form1" class="">Support in<sup> 3</sup></label>
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
                                <div class="tab-pane fade" id="manage">
                                    <h4>Manage Quotes Tab</h4>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label>PolyPrinter (Grams)</label>
                                                <input class="form-control" type="number" min="0" max="1000" step=".05" id="inputField1" placeholder="New PolyPrinter Material Price">
                                                <button onclick="polyPrinter()" type="button" class="btn btn-primary btn-block" id="pushMe">Update</button>
                                                <!--<input class="form-control" placeholder="New PolyPrinter Material Price">
                                                <a href="#" class="btn btn-primary btn-block">Update</a>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label>Vinyl (In)</label>
                                                <input class="form-control" type="number" min="0" max="1000" step=".05" id="inputField2" placeholder="New Vinyl Material Price">
                                                <button onclick="vinyl()" type="button" class="btn btn-primary btn-block" id="pushMe">Update</button>
                                                <!--<input class="form-control" placeholder="New Vinyl Material Price">
                                                <a href="#" class="btn btn-primary btn-block">Update</a>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label>uPrint (In<sup> 3</sup>)</label>
                                                <input class="form-control" type="number" min="0" max="1000" step=".5" id="inputField3" placeholder="New uPrint Material Price">
                                                <button onclick="uPrint()" type="button" class="btn btn-primary btn-block" id="pushMe">Update</button>
                                                <!--<input class="form-control" placeholder="New uPrint Material Price">
                                                <a href="#" class="btn btn-primary btn-block">Update</a>-->
                                            </div>
                                        </div>
                                    </div>
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

                    <div class="col-lg-4">
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
                                            <?php if ($staff && $staff->getRoleID() >= $sv['LvlOfStaff']) {
                                        ?>
                                                    <th>Qty on Hand</th>
                                            <?php
                                    } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php //Display Inventory Based on device group
                                    if ($result = $mysqli->query("
                                        SELECT `m_name`, SUM(unit_used) as `sum`, `color_hex`, `unit`
                                        FROM `materials`
                                        LEFT JOIN `mats_used`
                                        ON mats_used.m_id = `materials`.`m_id`
                                        WHERE `m_parent` = 1
                                        GROUP BY `m_name`, `color_hex`, `unit`
                                        ORDER BY `m_name` ASC;
                                    ")) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($staff && $staff->getRoleID() >= $sv['LvlOfStaff']) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['m_name']; ?></td>
                                                    <td><div class="color-box" style="background-color: #<?php echo $row['color_hex']; ?>;"/></td>
                                                    <td><?php echo number_format($row['sum'])." ".$row['unit']; ?></td>
                                                </tr>
                                            <?php
                                            } else {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['m_name']; ?></td>
                                                    <td><div class="color-box" style="background-color: #<?php echo $row['color_hex']; ?>;"/></td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <tr><td colspan="3">None</td></tr>
                                    <?php
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    <!-- /#wrapper --> 

 <script type="text/javascript">

    var a = 0.05;
    function polyPrinter()
    {
        a = document.getElementById("inputField1").value || a;
        var rate = a;
        var volume = document.getElementById("polyprinter-input").value;
        var total = (volume * rate).toFixed(2);
        document.getElementById("polyprinter-output").innerHTML = "$ " + total;
    }
     
    var b = 0.05; 
    function vinyl()
    {
        b = document.getElementById("inputField2").value || b;
        var rate = b;
        var length = document.getElementById("vinyl-input").value;
        var total = (rate * length).toFixed(2);
        document.getElementById("vinyl-output").innerHTML = "$" + total;
    }
     
    var c = 0.5;
    function uPrint()
    {
        c = document.getElementById("inputField3").value || c;
        var conv_rate = 16.387
        var rate1 = c;
        var rate2 = c;
        var volume1 = document.getElementById("uPrint-material-input").value;
        var volume2 = document.getElementById("uPrint-support-input").value;
        var total = ((volume1 * conv_rate * rate1) + (volume2 * conv_rate * rate2)).toFixed(2);
        document.getElementById("uPrint-output").innerHTML = "$" + total;
    }
     
function changeTheVariable() 
     {
        a = document.getElementById("inputField").value || a;
        document.getElementById("result").innerText = parseFloat(a);
     }   
</script>    
    
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
