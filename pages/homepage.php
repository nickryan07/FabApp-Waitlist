<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$device_array = array();
$number_of_status_tables = 0;
$_SESSION['type'] = "home";
?>


    <div id="wrapper">

       
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Homepage</h1>
                    </div>
                </div>
                
                <div class="row">
                    
                    <!-- Equipment Status -->
                    <div class="col-md-8">
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
                                        
                                        if (!$isAllTable) {
                                            ?> 
                                                                                <!-- PolyPrinter Status -->
                                    <div class="row text-center">
                                        <div class="col-xs-4 col-sm-6">
                                            <h3>#2</h3>
                                            <p>Now Serving</p>
                                        </div>

                                        <!-- Estimated Remaining Time -->
                                        <div class="col-xs-6">
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
                                        ")) {
                                            // If the number of free devices is greater than zero than there should be not wait
                                            if ($row  = $result->fetch_assoc()) {
                                                ?> 
                                                    <h3> No Wait </h3>
                                                    <p>Wait Time</p>
                                                <?php
                                            }

                                            // Since there are no open printers, find the least wait time
                                            else {
                                                if ($result = $mysqli->query("
                                                SELECT device_desc, t_start, est_time
                                                FROM devices
                                                JOIN transactions ON transactions.d_id = devices.device_id
                                                JOIN device_group ON devices.dg_id = device_group.dg_id
                                                WHERE device_group.dg_id = 2 AND
                                                    status_id < 12;
                                                ")) {
                                                    global $min_time;
                                                    $row  = $result->fetch_assoc();
                                                    if ($row["NumFreeDevices"] > 0) {
                                                        // If the device has a start time, then find the lowest wait time
                                                        if ($row["t_start"]) {
                                                            if (isset($min_time)) {
                                                                if ($min_time > $row["est_time"]) {
                                                                    $min_time = $row["est_time"];
                                                                }
                                                            } else {
                                                                $min_time = $row["est_time"];
                                                            }
                                                        }
                                                    }

                                                    // Display the wait time according to hours (if greater than 2) or minutes
                                                    if (isset($min_time)) {
                                                        sscanf($min_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                        // Display the time as hours only
                                                        if ($hours > 2) {
                                                            ?> 
                                                                <h3> <?php echo $hours ?> </h3>
                                                                <p>Hour Wait</p>
                                                            <?php
                                                        }
                                                        // Display the time as minutes
                                                        else {
                                                            ?> 
                                                                <h3> <?php echo($hours * 60) + $minutes ?> </h3>
                                                                <p>Minute Wait</p>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>  
                                            </div>
                                        </div>
                                                    
                                                    
                                                    
                                                    <?php
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
                   
                    <!-- Overview-->
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label>
                                    <i class="fa fa-th"></i> Overview</label>
                            </div>

                            
                            <div class="panel-body">
                            
                                <!-- PolyPrinter Status -->
                                <div class="row text-center">
                                    <div class="col-xs-12">
                                        <h3>PolyPrinters</h3>
                                    </div>
                                    <div class="col-xs-4 col-sm-6">
                                        <h3>#2</h3>
                                        <p>Now Serving</p>
                                    </div>

                                    <!-- Estimated Remaining Time -->
                                    <div class="col-xs-6">
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
                                    ")) {
                                        // If the number of free devices is greater than zero than there should be not wait
                                        if ($row  = $result->fetch_assoc()) {
                                            ?> 
                                                <h3> No Wait </h3>
                                                <p>Wait Time</p>
                                            <?php
                                        }

                                        // Since there are no open printers, find the least wait time
                                        else {
                                            if ($result = $mysqli->query("
                                            SELECT device_desc, t_start, est_time
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 2 AND
                                                   status_id < 12;
                                            ")) {
                                                global $min_time;
                                                $row  = $result->fetch_assoc();
                                                if ($row["NumFreeDevices"] > 0) {
                                                    // If the device has a start time, then find the lowest wait time
                                                    if ($row["t_start"]) {
                                                        if (isset($min_time)) {
                                                            if ($min_time > $row["est_time"]) {
                                                                $min_time = $row["est_time"];
                                                            }
                                                        } else {
                                                            $min_time = $row["est_time"];
                                                        }
                                                    }
                                                }

                                                // Display the wait time according to hours (if greater than 2) or minutes
                                                if (isset($min_time)) {
                                                    sscanf($min_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                    // Display the time as hours only
                                                    if ($hours > 2) {
                                                        ?> 
                                                            <h3> <?php echo $hours ?> </h3>
                                                            <p>Hour Wait</p>
                                                        <?php
                                                    }
                                                    // Display the time as minutes
                                                    else {
                                                        ?> 
                                                            <h3> <?php echo($hours * 60) + $minutes ?> </h3>
                                                            <p>Minute Wait</p>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>  
                                    </div>
                                </div>

                                <!-- Laser Status -->
                                <div class="row text-center">
                                    <div class="col-xs-12">
                                        <h3>Lasers</h3>
                                    </div>
                                    <div class="col-xs-6">
                                        <h3>#L2</h3>
                                        <p>Now Serving</p>
                                    </div>
                                    
                                    <!-- Estimated Remaining Time -->
                                    <div class="col-xs-6">
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
                                    ")) {
                                        // If the number of free devices is greater than zero than there should be not wait
                                        $row  = $result->fetch_assoc();
                                        if ($row["NumFreeDevices"] > 0) {
                                            ?> 
                                                <h3> No Wait </h3>
                                                <p>Wait Time</p>
                                            <?php
                                        }

                                        // Since there are no open printers, find the least wait time
                                        else {
                                            // Get all of the used devices and their estimated times of completion
                                            if ($result = $mysqli->query("
                                            SELECT device_desc, t_start, est_time
                                            FROM devices
                                            JOIN transactions ON transactions.d_id = devices.device_id
                                            JOIN device_group ON devices.dg_id = device_group.dg_id
                                            WHERE device_group.dg_id = 4 AND
                                                   status_id < 12;
                                            ")) {
                                                global $min_time;
                                                while ($row = $result->fetch_assoc()) {
                                                    // If the device has a start time, then find the lowest wait time
                                                    if ($row["t_start"]) {
                                                        if (isset($min_time)) {
                                                            if ($min_time > $row["est_time"]) {
                                                                $min_time = $row["est_time"];
                                                            }
                                                        } else {
                                                            $min_time = $row["est_time"];
                                                        }
                                                    }
                                                }

                                                // Display the wait time according to hours (if greater than 2) or minutes
                                                if (isset($min_time)) {
                                                    sscanf($min_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                    // Display the time as hours only
                                                    if ($hours > 2) {
                                                        ?> 
                                                            <h3> <?php echo $hours ?> </h3>
                                                            <p>Hour Wait</p>
                                                        <?php
                                                    }
                                                    // Display the time as minutes
                                                    else {
                                                        ?> 
                                                            <h3> <?php echo($hours * 60) + $minutes ?> </h3>
                                                            <p>Minute Wait</p>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quotes -->
                    <div class="col-lg-4">
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

                    <!-- Materials -->
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
            </div>
        </div>
</div>

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
<?php
        //Standard call for dependencies
        include_once($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
        ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
<script>
<?php foreach ($device_array as $da) {
            ?>
	var time = <?php echo $da[1]; ?>;
	var display = document.getElementById('est<?php echo $da[0]; ?>');
	var dg_parent = <?php if ($da[2]) {
                echo $da[2];
            } else {
                echo "0";
            } ?>;
	startTimer(time, display, dg_parent);
	
<?php
        }  ?>

            $("#indexTable_0").DataTable({
            "iDisplayLength": 25,
            "order": []
            });      
</script>