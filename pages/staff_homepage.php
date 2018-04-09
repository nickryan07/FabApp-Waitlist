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
                    <!-- Wait Queue -->
                    <div class="col-lg-13">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-ticket fa-fw"></i>Currently Waiting Users
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                <ul class="nav nav-tabs">
                                        <!-- Have at least the 'All' tab which will have all devices -->
                                        <li class="active">
                                            <a href="#device_group_tab" data-toggle="tab" aria-expanded="false">Device Groups</a>
                                        </li>
                                        <li class="">
                                            <a href="#device_tab" data-toggle="tab" aria-expanded="false">Devices</a>
                                        </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="device_group_tab">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><i class="fa fa-th-list"></i> Queue #</th>
                                                    <th><i class="far fa-user"></i> MavID</th>
                                                    <th><i class="fa fa-th-large"></i> Device Group</th>
                                                    <th><i class="far fa-calendar-alt"></i> Start</th>
                                                    <th><i class="far fa-clock"></i> Time Left</th>
                                                    <th><i class="far fa-flag"></i> Alerts</th>
                                                    <th><i class="fa fa-times"></i> Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 
                                                
                                                // Display all of the students in the wait queue for a device group
                                                if ($result = $mysqli->query("
                                                    SELECT *
                                                    FROM wait_queue WQ JOIN device_group DG ON WQ.devgr_id = DG.dg_id
                                                    WHERE valid = 'Y'
                                                    ORDER BY Q_id;
                                                ")) {
                                                    $counter = 1;
                                                    Wait_queue::calculateWaitTimes();
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <!-- Wait Queue Number -->
                                                            <td><?php echo($counter++) ?></td>
                                                            <!-- Operator ID --> 
                                                            <td><?php echo($row['Operator']) ?></td>
                                                            <!-- Device Group -->
                                                            <td><?php echo($row['dg_desc']) ?></td>
                                                            <!-- Start Time -->
                                                            <td><?php echo( date($sv['dateFormat'],strtotime($row['Start_date'])) ) ?></td>
                                                            <!-- Estimated Time Left -->
                                                            <?php
                                                            echo("<td id=\"est".$row["Q_id"]."\">".$row["estTime"]." </td>" );
                                                                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["estTime"]);
                                                                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                                                    array_push($device_array, array($row["Q_id"], $time_seconds, 1));
                                                            ?>
                                                            <!-- Send an Alert -->
                                                            <td>Send Alert</td>
                                                            <!-- Remove From Wait Queue -->
                                                            <td> 
                                                                <div style="text-align: center">
                                                                    <button class="btn btn-danger btn-circle" data-target="#removeModal" data-toggle="modal" 
                                                                            onclick="removeFromWaitlist(<?php echo $row["Q_id"].", ".$row["Operator"].", undefined, ".$row["Devgr_id"]; ?>)">
                                                                            <i class="glyphicon glyphicon-remove"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }                                        
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade in" id="device_tab">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-th-list"></i> Queue #</th>
                                                <th><i class="far fa-user"></i> MavID</th>
                                                <th><i class="fa fa-th-large"></i> Device</th>
                                                <th><i class="far fa-calendar-alt"></i> Start</th>
                                                <th><i class="far fa-clock"></i> Time Left</th>
                                                <th><i class="far fa-flag"></i> Alerts</th>
                                                <th><i class="fa fa-times"></i> Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                            
                                            // Display all of the students in the wait queue for a device

                                            if ($result = $mysqli->query("
                                                SELECT Q_id, Operator, Start_date, device_desc, Dev_id
                                                FROM wait_queue WQ JOIN devices D ON WQ.Dev_id = D.device_id
                                                WHERE valid = 'Y'
                                                ORDER BY Q_id;
                                            ")) {
                                                $counter = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                
                                                    <tr>
                                                        <!-- Wait Queue Number -->
                                                        <td><?php echo($counter++) ?></td>
                                                        <td><?php echo($row['Operator']) ?></td>
                                                        <td><?php echo($row['device_desc']) ?></td>
                                                        <td><?php echo( date($sv['dateFormat'],strtotime($row['Start_date'])) ) ?></td>
                                                        <td><?php echo($row['estTime']) ?></td>
                                                        <td>Send Alert</td>
                                                        <td> 
                                                            <div style="text-align: center">
                                                                <button class="btn btn-danger btn-circle" data-target="#removeModal" data-toggle="modal" 
                                                                        onclick="removeFromWaitlist(<?php echo $row["Q_id"].", ".$row["Operator"].", ".$row['Dev_id'].", undefined"; ?>)">
                                                                        <i class="glyphicon glyphicon-remove"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }                                        
                                            ?>
                                        </tbody>
                                    </table>                                
                                    </div>
                                </div>
                                </div>
                                <!-- /.table-responsive -->
                            </div>

                    </div>
                <!-- /.col-lg-13 -->
                
                </div>
                <!-- /.col-lg-6 -->
                </div>
                
                <!-- /.col-lg-13 -->
                </div>
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

                <!-- /.row -->


                    <div class="col-lg-6">
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
    <?php
        //Standard call for dependencies
        include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
        ?>
    <!-- /#wrapper -->
<script>
<?php foreach ($device_array as $da) { ?>
	var time = <?php echo $da[1];?>;
	var display = document.getElementById('est<?php echo $da[0];?>');
	var dg_parent = <?php if ($da[2]) echo $da[2]; else echo "0";?>;
	startTimer(time, display, dg_parent);
	
<?php } ?>
</script>

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
</html>
