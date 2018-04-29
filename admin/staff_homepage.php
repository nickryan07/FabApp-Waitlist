<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$device_array = array();
$number_of_status_tables = 0;

if (!$staff || $staff->getRoleID() < 7){
    //Not Authorized to see this Page
    header('Location: /index.php');
	exit();
}
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
                </div>
                <!-- /.row -->

                <div class="row">

                    <!-- Wait Queue -->
                    <div class="col-lg-13">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                                <i class="fas fa-ticket-alt fa-fw"></i>  Wait Queue

                                <input type="button" class="btn btn-sm btn-primary pull-right" value="New Wait Ticket" onclick="location.href = '/admin/wait_ticket.php'">

                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <ul class="nav nav-tabs">
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
                                                    <th><i class="fa fa-th-list"></i> Priority</th>
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
                                                            <td align="center"><?php echo($row['Q_id']) ?></td>

                                                            <!-- Priority Number -->
                                                            <td align="center"><?php echo($counter++) ?></td>

                                                            <!-- Operator ID --> 
                                                            <td>
                                                            <?php $user = Users::withID($row['Operator']);?>
                                                                <i class="<?php echo $user->getIcon()?> fa-lg" title="<?php echo($row['Operator']) ?>"></i>
                                                                <?php if (!empty($row['Op_phone'])) { ?> <i class="fas fa-mobile"   title="<?php echo ($row['Op_phone']) ?>"></i> <?php } ?>
                                                                <?php if (!empty($row['Op_email'])) { ?> <i class="fas fa-envelope" title="<?php echo ($row['Op_email']) ?>"></i> <?php } ?>
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
                                                                        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds - (time() - strtotime($row["Start_date"]) ) + $sv["grace_period"];
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
                                                                if (!empty($row['Op_phone']) || !empty($row['Op_email'])) {
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

                                    <!-- Device Wait Queue -->
                                    <div class="tab-pane fade in" id="device_tab">
                                    <table id="Device_Table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-th-list"></i> Queue #</th>
                                                <th><i class="fa fa-th-list"></i> Priority</th>
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
                                                        <td align="center"><?php echo($row['Q_id']) ?></td>
                                                    
                                                        <!-- Wait Queue Number -->
                                                        <td align="center"><?php echo($counter++) ?></td>
                                                    
                                                        <!-- Operator ID --> 
                                                        <td>
                                                            <?php $user = Users::withID($row['Operator']);?>
                                                            <i class="<?php echo $user->getIcon()?> fa-lg" title="<?php echo($row['Operator']) ?>"></i>
                                                            <?php if (!empty($row['Op_phone'])) { ?> <i class="fas fa-mobile"   title="<?php echo ($row['Op_phone']) ?>"></i> <?php } ?>
                                                            <?php if (!empty($row['Op_email'])) { ?> <i class="fas fa-envelope" title="<?php echo ($row['Op_email']) ?>"></i> <?php } ?>
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
                                                                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds - (time() - strtotime($row["Start_date"]) ) + $sv["grace_period"];
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
                                                            if (!empty($row['Op_phone']) || !empty($row['Op_email'])) {
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
                </div>



                <!-- Create a Ticket -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-print fa-fw"></i>Create Ticket
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="row">
                                <div class="col-lg-11">
                                <tr>
                                <td>Device</td>
                                <td>
                                    <select class="form-control" name="devGrp" id="devGrp" onChange="change_group()" >
                                        <option value="" > Select Group</option>
                                        <?php

                                            // Load all of the device groups that are being waited for - signified with a 'DG' in front of the value attribute
                                            if ($result = $mysqli->query("
                                                SELECT DISTINCT `device_desc`, `dg_id`, `d_id`
                                                FROM `devices` D JOIN `wait_queue` WQ on D.`dg_id` = WQ.`Devgr_id`
                                            ")) {
                                                while ( $rows = mysqli_fetch_array ( $result ) ) {
                                                    // Create value in the form of DG_dgID-dID
                                                    echo "<option value=". "DG_" . $rows ['dg_id'] . "-" . $rows ['d_id'].">" . $rows ['device_desc'] . "</option>";
                                                }
                                            } else die ("There was an error loading the device groups.");
                                            

                                            // Load all of the devices that are being waited for - signified with a 'D' in front of the value attribute
                                            if ($result = $mysqli->query("
                                                SELECT DISTINCT `device_desc`, `d_id`
                                                FROM `devices` D JOIN `wait_queue` W ON D.`d_id` = W.`Dev_id`
                                            ")) {
                                                while ( $rows = mysqli_fetch_array ( $result ) ) {
                                                    // Create value in the form of D_dID
                                                    echo "<option value=". "D_" . $rows ['d_id'] . ">" . $rows ['device_desc'] . "</option>";
                                                }
                                            } else die ("There was an error loading the devices.");
                                        ?> 
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td>
                                    <select class="form-control" name="deviceList" id="deviceList">
                                        <option value =""> Select Group First</option>
                                    </select>
                                </td>
                            </tr>
                            
                                </div>
                            </div>
                            
                            <button class="btn btn-primary" type="button" id="addBtn" onclick="newTicket()">Create Ticket</button>

                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                    <!-- Quotes -->
                    <div class="col-lg-13">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label><i class="fa fa-ticket fa-tag"></i>  Quotes</label>
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
                                        <h4>PolyPrinter Quote</h4>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <input id="polyprinter-input" class="form-control" onkeyup="polyPrinter()" onchange="polyPrinter()" type="number" min="0"
                                                        max="1000" step=".5" autocomplete="off" placeholder="Amount">
                                                    <label for="form1" class="">Grams</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <h2 id="polyprinter-output" class="font-medium text-center">
                                                    $0.00
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="vinyl">
                                        <h4>Vinyl Quote</h4>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <input id="vinyl-input" class="form-control" onkeyup="vinyl()" onchange="vinyl()" type="number" min="0" max="1000" step=".5"
                                                        autocomplete="off" placeholder="Amount">
                                                    <label for="form1" class="">Inches</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <h2 id="vinyl-output" class="font-medium text-center">
                                                    $0.00
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="uprint">
                                        <h4>uPrint Quote</h4>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <input id="uPrint-material-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000"
                                                        step=".5" autocomplete="off" placeholder="Amount">
                                                    <label for="form1" class="">Model in
                                                        <sup> 3</sup>
                                                    </label>
                                                </div>
                                                <div class="col-lg-13">
                                                    <div class="form-group">
                                                        <input id="uPrint-support-input" class="form-control" onkeyup="uPrint()" onchange="uPrint()" type="number" min="0" max="1000"
                                                            step=".5" autocomplete="off" placeholder="Amount">
                                                        <label for="form1" class="">Support in
                                                            <sup> 3</sup>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
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
                  <!-- /.col-lg-13 -->
                    
                <!-- Materials -->
                <div class="col-lg-13">
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
                <!-- /.col-lg-13 --> 

                </div>

                <!-- Equipment Status -->
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label>
                                <i class="fa fa-tasks"></i> Equipment Status
                            </label>
                        </div>
                        <!-- Tabs -->
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <!-- Have at least the 'All' tab which will have all devices -->
                                <li class="active">
                                    <a href="#all" data-toggle="tab" aria-expanded="false">All</a>
                                </li>

                                <!-- Load all device groups as a tab that have at least one device in that group -->
                            <?php 
                                if ($result = $mysqli->query("
                                    SELECT dg_id, dg_desc
                                    FROM device_group
                                    WHERE device_group.dg_id IN ( 
                                        SELECT dg_id
                                        FROM devices
                                        GROUP BY dg_id
                                        HAVING COUNT(*) > 1
                                    )
                                    ORDER BY dg_id;
                                ")) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?> 
                                        <li class="">
                                            <a <?php echo("href=\"#".$row["dg_id"]."\""); ?>  data-toggle="tab" aria-expanded="false"> <?php echo($row["dg_desc"]); ?> </a>
                                        </li>
                                        <?php
                                    }
                                }
                            ?> 
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                
                                <?php
                                if ($Tabresult = $mysqli->query("
                                    SELECT dg_id, dg_desc
                                    FROM device_group
                                    WHERE device_group.dg_id IN ( 
                                        SELECT dg_id
                                        FROM devices
                                        GROUP BY dg_id
                                        HAVING COUNT(*) > 1
                                    )
                                    ORDER BY dg_id;
                                    ")) {
                                    $isAllTable = true; // flag used to indicate that this is the 'All' tab

                                    do {
                                        global $tab;
                                        
                                        // Give all of the dynamic tables a name so they can be called when their tab is clicked
                                        if ($isAllTable) {
                                            ?> <div class="tab-pane active in" id="all"> <?php
                                        } else {
                                            ?> <div class="tab-pane fade" <?php echo("id=\"".$tab["dg_id"]."\"") ?> > <?php
                                        }                                      
                                    ?>                        
                                        <!-- Create the Table Header -->
                                        <table class="table table-striped table-bordered table-hover" <?php echo("id=\"indexTable_".$number_of_status_tables."\"") ?>>
                                        <thead>
                                            <tr class="tablerow">
                                                <th align="right">Ticket</th>
                                                <th>Device</th>
                                                <th>Start Time</th>
                                                <th>Est Time Left</th>
                                                <th>Progress </th>
                                                <?php if ($staff) {
                                            ?> <th>Action</th><?php
                                        } ?>
                                            </tr>
                                        </thead>
                                        <?php

                                        // Create the table for the specified tab, if it is the 'All' tab then it will display all of the devices instead of those associated in the device group
                                        if ($result = $mysqli->query("
                                            SELECT trans_id, device_desc, t_start, est_time, devices.dg_id, dg_parent, devices.d_id, url, operator, status_id
                                            FROM devices
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            LEFT JOIN (SELECT trans_id, t_start, t_end, est_time, d_id, operator, status_id FROM transactions WHERE status_id < 12 ORDER BY trans_id DESC) as t ON devices.d_id = t.d_id
                                            WHERE public_view = 'Y'" . (!$isAllTable ? " and devices.dg_id=".$tab["dg_id"] : ""). "
                                            ORDER BY dg_id, `device_desc`
                                        ")) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?> <tr class="tablerow"> <?php 
                                                
                                                // if there is a print for this device
                                                if ($row["t_start"]) {
                                                    //create a new transaction based off of the ID which will fill all of the fields of a transaction
                                                    $ticket = new Transactions($row['trans_id']);
                                    
                                                    // Print the Ticket Number?> <td align="right"> <?php
                                                    echo("<a href=\"pages/lookup.php?trans_id=$row[trans_id]\">$row[trans_id]</a>"); ?> </td>

                                                    <!-- Print the Device Name -->
                                                    <td>
                                                        <?php 
                                                        // Show Devices that have a URL attached to them that will give more information
                                                        if ($ticket->getDevice()->getUrl() && (preg_match($sv['ip_range_1'], getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'], getenv('REMOTE_ADDR')))) {
                                                            Devices::printDot($staff, $row['d_id'], $ticket->getDevice()->getD_id());
                                                            //echo ("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                                            echo("<a href=\"http://".$ticket->getDevice()->getUrl()."\">".$ticket->getDevice()->getDevice_desc()."</a>");
                                                        }

                                                    // Show Devices that do not have a URL attached to them
                                                    else {
                                                        Devices::printDot($staff, $ticket->getDevice()->getD_id());
                                                        echo $ticket->getDevice()->getDevice_desc();
                                                    } ?>
                                                    </td>
                                    
                                                    <!-- Show the Job Start Time --> 
                                                    <?php 
                                                    echo("<td>".date('M d g:i a', strtotime($row["t_start"]))."</td>");
                                    
                                                    //If the print has completed and the print needs to be moved
                                                    if ($row["status_id"] == 11) {
                                                        echo("<td align='center'>".$ticket->getStatus()->getMsg()."</td>"); // Status note for Est. Time
                                                        echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                                    }

                                                    // If the print is still printing
                                                    elseif (isset($row["est_time"])) {
                                                        echo("<td align='center'><div id=\"est".$row["trans_id"]."_".$number_of_status_tables."\">".$row["est_time"]." </div></td>");
                                                        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $row["est_time"]);
                                                        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($row["t_start"])) + $sv["grace_period"];
                                                        array_push($device_array, array($row["trans_id"]."_".$number_of_status_tables, $time_seconds, $row["dg_parent"])); ?>
                                                            <td> <div class="progress active">
                                                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                                            style="width:
                                                        <?php 
                                                        
                                                        // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                        // if the estimated time is greater than the current time then display a progress bar, else show 100%
                                                        if ($time_seconds > 0) {
                                                            $percentage = (1 - ($time_seconds / ((strtotime("now") - strtotime($row["t_start"])) + $time_seconds))) * 100;
                                                        } else {
                                                            $percentage = 100;
                                                        }
                                                    
                                                        echo $percentage."%"; ?> 
                                                    "/> </div> </td>
                                                    <?php
                                                    }

                                                    // There is no job printing for this device
                                                    else {
                                                        echo("<td align=\"center\">-</td>"); // Nothing for the Est Time Left
                                                    echo("<td align=\"center\">-</td>"); // Nothing for the progress bar
                                                    }
                                        
                                                    // Actions for Staff Members
                                                    if ($staff && ($staff->getRoleID() >= $sv['LvlOfStaff'] || $staff->getOperator() == $ticket->getUser()->getOperator())) {
                                                        ?>
                                                    <td align="center">
                                                        <button onclick="endTicket(<?php echo $row["trans_id"].",'".$row["device_desc"]."'"; ?>)">End Ticket</button>
                                                    </td>
                                                <?php
                                                    } elseif ($staff) {
                                                        echo("<td align='center'></td>");
                                                    }
                                                }

                                                // If there is no print for the device
                                                else {
                                                    ?>
                                                <td align="right"></td>
                                                <td>
                                            <?php 

                                                // Show Devices that have a URL attached to them that will give more information
                                                if ($row['url'] && (preg_match($sv['ip_range_1'], getenv('REMOTE_ADDR')) || preg_match($sv['ip_range_2'], getenv('REMOTE_ADDR')))) {
                                                    Devices::printDot($staff, $row['d_id']);
                                                    echo("<a href=\"http://".$row["url"]."\">".$row["device_desc"]."</a>");
                                                }

                                                    // Show Devices that do not have a URL attached to them
                                                    else {
                                                        Devices::printDot($staff, $row['d_id']);
                                                        echo $row['device_desc'];
                                                    } ?>
                                            </td>

                                            <!-- Show that there is NO Start Time -->
                                            <td align="center"> - </td>

                                            <!-- Show that there is NO End Time -->
                                            <td align="center"> - </td>

                                            <!-- Show that there is NO End Time Progress Bar -->
                                            <td align="center"> - </td>
                                    
                                            <!-- Allow a staff member to create a new ticket -->
                                            <?php 
                                            if ($row["url"] && $staff) {
                                                if ($staff->getRoleID() > 6) {
                                                    ?>
                                                    <td  align="center"><?php echo("<a href=\"http://".$row["url"]."\">New Ticket</a>"); ?></td>
                                                    <?php
                                                } else {
                                                    echo("<td align=\"center\">-</td>");
                                                }
                                            } elseif ($staff) {
                                                if ($staff->getRoleID() > 6) {
                                                    ?>
                                                    <td align="center"><div id="est"><a href="\pages\create.php?<?php echo("d_id=".$row["d_id"])?>">New Ticket</a></div></td>
                                                    <?php
                                                } else {
                                                    echo("<td align=\"center\">-</td>");
                                                }
                                            }
                                                } ?>
                                            </tr>
                                            <?php
                                            }
                                        } ?>
                                    </table>
                                </div>
                                <?php

                                $isAllTable = false;
                                $number_of_status_tables++;
                            } while ($tab = $Tabresult->fetch_assoc());
                        }
                        ?>
                        </div>
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
        var device_id = document.getElementById("devGrp").value;
        var o_id = document.getElementById("deviceList").value;
        
        if("D_" === device_id.substring(0,2)){
            device_id = device_id.substring(2);
        } else{
            if("-" === device_id.substring(4,5)){
            device_id = device_id.substring(5);
            } else{
            device_id = device_id.substring(6);
            }
        }
        
        device = "d_id=" + device_id + "&operator=" + o_id;

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
      
    function change_group(){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("deviceList").innerHTML = this.responseText;
            }
        };
        
        xmlhttp.open("GET","/admin/sub/getWaitQueueID.php?val="+ document.getElementById("devGrp").value, true);
        xmlhttp.send();
    }
     
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
     
    function changeTheVariable() 
     {
        a = document.getElementById("inputField").value || a;
        document.getElementById("result").innerText = parseFloat(a);
     } 
     
     function sendManualMessage(q_id, message)
     {
        window.location.href = "/pages/endWaitList.php?q_id=" + q_id + "&message=" + message;
     }

     function startTicket(d_id, dg_id, operator)
     {
         if (!operator) {
             confirm("Please enter a valid Operator Number");
             return;
         }

         if (d_id) {
             window.location.href = "/pages/create.php?d_id=" + d_id + "&operator=" + operator;
         }
         else if (dg_id) {
            window.location.href = "/pages/create.php?dg_id=" + dg_id + "&operator=" + operator;
         }
     }

    $('#Device_Group_Table').DataTable({
        "iDisplayLength": 25,
        "order": []
    });

    $('#Device_Table').DataTable({
        "iDisplayLength": 25,
        "order": []
    });

    
    $("#indexTable_0").DataTable({
            "iDisplayLength": 25,
            "order": []
            });   
</script>    
    
</body>
</html>
