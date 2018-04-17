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
    <title>Waitlist Staff Homepage</title>
    
    <link href="/css/style.css" rel="stylesheet">
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
                                        <table id="Device_Group_Table" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr align="center">
                                                    <th><i class="fa fa-th-list"></i> Queue #</th>
                                                    <th><i class="far fa-user"></i> MavID</th>
                                                    <th><i class="fa fa-th-large"></i> Device Group</th>
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
                                                                       LEFT JOIN operator_info OI ON WQ.Operator = OI.Op_id
                                                    WHERE valid = 'Y'
                                                    ORDER BY Q_id;
                                                ")) {
                                                    $counter = 1;
                                                    Wait_queue::calculateWaitTimes();
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <!-- Wait Queue Number -->
                                                            <td align="center"><?php echo($counter++) ?></td>
                                                            <!-- Operator ID --> 
                                                            <td>
                                                                <i class="fab fa-grav fa-spin fa-lg" title="<?php echo($row['Operator']) ?>"></i>
                                                                <?php if (isset($row['Op_phone'])) { ?> <i class="fas fa-mobile"   title="<?php echo ($row['Op_phone']) ?>"></i> <?php } ?>
                                                                <?php if (isset($row['Op_email'])) { ?> <i class="fas fa-envelope" title="<?php echo ($row['Op_email']) ?>"></i> <?php } ?>
                                                            </td>
                                                            <!-- Device Group -->
                                                            <td align="center"><?php echo($row['dg_desc']) ?></td>
                                                            <!-- Start Time, Estimated Time, Last Contact Time -->
                                                            <td>
                                                                <!-- Start Time -->
                                                                <i class="far fa-calendar-alt" align="center" title="Started @ <?php echo( date($sv['dateFormat'],strtotime($row['Start_date'])) ) ?>"></i>
                                                                
                                                                <!-- Estimated Time -->
                                                                <?php
                                                                    if (isset($row['estTime']))
                                                                    {
                                                                        echo("<span align=\"center\" id=\"est".$row["Q_id"]."\">"."  ".$row["estTime"]."  </span>" );
                                                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["estTime"]);
                                                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                                                        array_push($device_array, array($row["Q_id"], $time_seconds, 1));
                                                                    }
                                                                ?>

                                                                <!-- Last Contact Time -->
                                                                <?php if (isset($row['last_contact'])) {
                                                                    ?> <i class="far fa-bell" align="center" title="Last Alerted @ <?php echo(date($sv['dateFormat'], strtotime($row['last_contact']))) ?>"></i> <?php
                                                                } ?>
                                                            </td>
                                                            <!-- Send an Alert -->
                                                            <td> 
                                                                <?php 
                                                                if (isset($row['Op_phone']) || isset($row['Op_email'])) {
                                                                    ?> 
                                                                    <div style="text-align: center">
                                                                        <button class="btn btn-xs btn-primary" data-target="#removeModal" data-toggle="modal" 
                                                                                onclick="sendManualMessage(<?php echo $row["Q_id"]?>, 'The FabLab is waiting for you to start your print!')">
                                                                                Send Alert
                                                                        </button>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
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
                                    <table id="Device_Table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-th-list"></i> Queue #</th>
                                                <th><i class="far fa-user"></i> MavID</th>
                                                <th><i class="fa fa-th-large"></i> Device</th>
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
                                                FROM wait_queue WQ JOIN devices D ON WQ.Dev_id = D.device_id
                                                                   LEFT JOIN operator_info OI ON WQ.Operator = OI.Op_id
                                                WHERE valid = 'Y'
                                                ORDER BY Q_id;
                                            ")) {
                                                $counter = 1;
                                                Wait_queue::calculateDeviceWaitTimes();
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <!-- Wait Queue Number -->
                                                        <td align="center"><?php echo($counter++) ?></td>
                                                        <!-- Operator ID --> 
                                                        <td>
                                                            <i class="fab fa-grav fa-spin fa-lg" title="<?php echo($row['Operator']) ?>"></i>
                                                            <?php if (isset($row['Op_phone'])) { ?> <i class="fas fa-mobile"   title="<?php echo ($row['Op_phone']) ?>"></i> <?php } ?>
                                                            <?php if (isset($row['Op_email'])) { ?> <i class="fas fa-envelope" title="<?php echo ($row['Op_email']) ?>"></i> <?php } ?>
                                                        </td>
                                                        <!-- Device Name -->
                                                        <td align="center"><?php echo($row['device_desc']) ?></td>
                                                        <!-- Start Time, Estimated Time, Last Contact Time -->
                                                        <td>
                                                            <!-- Start Time -->
                                                            <i class="far fa-calendar-alt" align="center" title="Started @ <?php echo( date($sv['dateFormat'],strtotime($row['Start_date'])) ) ?>"></i>
                                                            
                                                            <!-- Estimated Time -->
                                                            <?php
                                                                if (isset($row['estTime']))
                                                                {
                                                                    echo("<span align=\"center\" id=\"est".$row["Q_id"]."\">"."  ".$row["estTime"]."  </span>" );
                                                                    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["estTime"]);
                                                                    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                                                    array_push($device_array, array($row["Q_id"], $time_seconds, 1));
                                                                }
                                                            ?>

                                                            <!-- Last Contact Time -->
                                                            <?php if (isset($row['last_contact'])) {
                                                                ?> <i class="far fa-bell" align="center" title="Last Alerted @ <?php echo(date($sv['dateFormat'], strtotime($row['last_contact']))) ?>"></i> <?php
                                                            } ?>
                                                        </td>
                                                        <!-- Send an Alert -->
                                                        <td> 
                                                            <?php 
                                                            if (isset($row['Op_phone']) || isset($row['Op_email'])) {
                                                                ?> 
                                                                <div style="text-align: center">
                                                                    <button class="btn btn-xs btn-primary" data-target="#removeModal" data-toggle="modal" 
                                                                            onclick="sendManualMessage(<?php echo $row["Q_id"]?>, 'The FabLab is waiting for you to start your print!')">
                                                                            Send Alert
                                                                    </button>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <!-- Remove From Wait Queue -->
                                                        <td> 
                                                            <div style="text-align: center">
                                                                <button class="btn btn-danger btn-circle" data-target="#removeModal" data-toggle="modal" 
                                                                        onclick="removeFromWaitlist(<?php echo $row["Q_id"].", ".$row["Operator"].", ".$row['device_id'].", undefined" ?>)">
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
                            <i class="fa fa-print fa-fw"></i>Create Ticket
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-4">
                        <label>Equipment: </label>
                        <div class="col-lg-13">
                            <label>MavID: </label>
                        </div>
                            
                        </div>
                                <tr>
                            <form name="Form" id="Form" autocomplete="off" method="post" action="">
                                <select name="d_id" id="d_id" onchange="selectDevice(this)" tabindex="1">
                                    <option disabled hidden selected value="">Device</option>
                                    <?php if($result = $mysqli->query("
                                        SELECT d_id, device_desc
                                        FROM devices
                                        ORDER BY device_desc
                                    ")){
                                        while($row = $result->fetch_assoc()){
                                            echo("<option value='".$row["d_id"]."'>".$row["device_desc"]."</option>");
                                        }echo $d_id;
                                    } else {
                                        echo ("Device list Error - SQL ERROR");
                                    }?>
                                </select> 
                                </form>
                                </tr>


                                <tr>
                                    <select name="Operator" id="Operator" onchange="" tabindex="1">
                                        <option disabled hidden selected value="">MavID</option>
                                        <?php if($result = $mysqli->query("
                                            SELECT `Operator`, `Q_id`
                                            FROM `wait_queue`
                                            WHERE `valid` = 'Y'
                                            ORDER BY `Q_id`
                                        ")){
                                            while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[Q_id]'>$row[Operator]</option>");
                                            }
                                        } else {
                                            echo ("Device list Error - SQL ERROR");
                                        }?>
                                    </select>
                                </tr>
                        </div>
                        
    
                            
                            <button type="button" id="addBtn" onclick="newTicket()">Create Ticket</button>
                            
                    

                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
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

    var device = "";

    function newTicket(){
        if (device  != ""){
            var dest = "/pages/create.php?";
            dest = dest.concat(device);
            console.log(dest);
            window.location.href = dest;
        } else {
            message = "Please select a device.";
            var answer = alert(message);
        }
    }   
         
    
    function selectDevice(element){

    }   
     
     
    function polyPrinter()
    {
        var a = 0.05;
        a = document.getElementById("inputField1").value || a;
        var rate = a;
        var volume = document.getElementById("polyprinter-input").value;
        var total = (volume * rate).toFixed(2);
        document.getElementById("polyprinter-output").innerHTML = "$ " + total;
    }
     

    function vinyl()
    {
        var b = 0.05; 
        b = document.getElementById("inputField2").value || b;
        var rate = b;
        var length = document.getElementById("vinyl-input").value;
        var total = (rate * length).toFixed(2);
        document.getElementById("vinyl-output").innerHTML = "$" + total;
    }
     
    function uPrint()
    {
        var c = 0.5;
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
     
     function sendManualMessage(q_id, message)
     {
        var dest = "/pages/endWaitList.php?q_id=" + q_id + "&message=" + message;
        window.location.href = dest;
        //window.location.href = "/pages/staff_homepage.php";
     }

    $('#Device_Group_Table').DataTable({
        "iDisplayLength": 25,
        "order": []
    });

    $('#Device_Table').DataTable({
        "iDisplayLength": 25,
        "order": []
    });
</script>    
    
</body>
</html>
