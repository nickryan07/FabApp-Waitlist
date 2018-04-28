<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$job_array = array();
$errorMsg = "";

if (isset($_GET["operator"])){
    if (Users::regexUSER ($_GET['operator'])){
        $operator = $_GET['operator'];
        if($result = $mysqli->query("
            SELECT trans_id
            FROM transactions
            WHERE transactions.operator = '$operator'
            ORDER BY t_start DESC
            Limit 1
        ")){
            if($resultWait = $mysqli->query("
                SELECT Q_id
                FROM wait_queue
                WHERE wait_queue.`Operator` = '$operator'
                Limit 1
            ")){
                if( $result->num_rows > 0 || $resultWait->num_rows > 0 ) {
                    // $row = $result->fetch_assoc();
                    // $ticket = new Transactions($row['trans_id']);
                } else {
                    $errorMsg = "No Transactions or wait tickets Found for ID# $operator";
                }
            }
            
        } else {
            $message = "Error - ID LookUp";
        }
    } else {
        $errorMsg = "Invalid Operator ID";
    }
} else {
    $errorMsg = "Search Parameter is Missing";
}

if ($errorMsg != ""){
    //$_SESSION['loc'] = "/index.php";
    echo "<script> alert('$errorMsg'); window.location.href='/index.php';</script>";
}

?>

    <div id="wrapper">



        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Student Homepage - <?php echo $operator ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Receive Alerts
                            </div>
                            <div class="panel-body" style="margin-top: 35px">
                                <form method="post">
                                <div class="form-group">
                                    <label><i class="fa fa-phone"></i> Phone Number</label>
                                    <input class="form-control" name="phone" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-envelope"></i> Email Address</label>
                                    <input class="form-control" name="email" placeholder="">
                                </div>
                                <div class="form-group" style="margin-top: 50px">
                                    <label><i class="fa fa-info-circle"></i> Disclaimer</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="disclaimer" value="">I have read and understand the <a href="http://fablab.uta.edu/policy" target="_blank">Fablab Wait Policies</a>.
                                        </label>
                                    </div>
                                </div>
                                <div style="text-align: center">
                                    <button type="submit" name="update-info" class="btn btn-default">Update</button>
                                </div>
                                    <?php
                                    if(isset($_POST['disclaimer'])) {
                                        if(isset($_POST['update-info']))
                                        {
                                            $phone = $_POST["phone"];
                                            $email = $_POST["email"];
                                            Transactions::insertContactInfo($operator, $phone, $email);
                                        }
                                    } else {
                                        echo ("You must accept the disclaimer.");
                                    }
                                    ?>
                                </form>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div>
                    <?php if ($result = $mysqli->query("
                            SELECT trans_id, device_desc, t_start, est_time, devices.dg_id, dg_parent, devices.d_id, url, operator, status_id
                            FROM devices
                            JOIN device_group
                            ON devices.dg_id = device_group.dg_id
                            JOIN (SELECT trans_id, t_start, t_end, est_time, d_id, operator, status_id FROM transactions WHERE transactions.operator = '$operator' AND transactions.status_id < 11 ORDER BY trans_id DESC) as t 
                            ON devices.d_id = t.d_id
                            WHERE public_view = 'Y'
                            ORDER BY dg_id, `device_desc`
                        ")){
                        while ( $panel = $result->fetch_assoc() ){ ?>
                    <?php   if($panel["t_start"]) {
                                $ticket = new Transactions($panel['trans_id']); ?>
                    <div class="col-lg-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <i class="fa fa-cog fa-spin fa-fw"></i>
                                <span class="sr-only">Loading...</span> Active Ticket -
                                <?php echo $ticket->getDevice()->getDevice_desc(); ?>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div id="job-info" style="margin-left: 25px;">
                                        <h6>
                                            Number
                                        </h6>
                                        <h3>
                                            #
                                            <?php echo ("$panel[trans_id]"); ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Est. Wait:</strong>
                                            <span class="pull-right text-muted">
                                                        <?php //echo("<div>".date( 'M d g:i a',strtotime($panel["t_start"]) )."</div>" );
                                                            if( $panel["status_id"] == 11) {
                                                                echo($ticket->getStatus()->getMsg());
                                                            } elseif (isset($panel["est_time"])) {
                                                                echo("<div id=\"est".$panel["trans_id"]."\">".$panel["est_time"]." </div>" );
                                                                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $panel["est_time"]);
                                                                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($panel["t_start"]) ) + $sv["grace_period"];
                                                                array_push($job_array, array($panel["trans_id"], $time_seconds, $panel["dg_parent"]));
                                                            } else 
                                                                echo("<div align=\"center\">-</div>"); 
                                                                      ?>
                                                        </span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width:
                                                <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($panel["est_time"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($panel["t_start"])) / ((strtotime("now") - strtotime($panel["t_start"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                            ">
                                                <span class="sr-only">55% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>
                    </div>
                    <?php       }
                            }
                        } ?>
                        <!-- ####### Wait Tickets ####### -->
                        <?php if ($result = $mysqli->query("
                            SELECT Q_id, estTime, Start_date, Dev_id, Devgr_id
                            FROM wait_queue
                            WHERE `Operator` = '$operator' AND `valid` = 'Y' AND `Devgr_id` IS NULL;
                        ")){
                        while ( $panel = $result->fetch_assoc() ){ ?>
                    <?php   if($panel["Start_date"]) {
                                $device = new Devices($panel['Dev_id']); ?>
                    <div class="col-lg-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fas fa-ticket-alt fa-spin fa-fw"></i>
                                <span class="sr-only">Loading...</span> Wait Ticket -
                                <?php echo $device->getDevice_desc(); ?>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div id="job-info" style="margin-left: 25px;">
                                        <h6>
                                            Number
                                        </h6>
                                        <h3>
                                            #
                                            <?php echo ("$panel[Q_id]"); ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Est. Wait:</strong>
                                            <span class="pull-right text-muted">
                                                        <?php //echo("<div>".date( 'M d g:i a',strtotime($panel["Start_date"]) )."</div>" );
                                                            if (isset($panel["estTime"])) {
                                                                echo("<div id=\"est".$panel["Q_id"]."\">".$panel["estTime"]." </div>" );
                                                                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $panel["est_time"]);
                                                                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($panel["Start_date"]) ) + $sv["grace_period"];
                                                                array_push($job_array, array($panel["Q_id"], $time_seconds, $device->getDg()));
                                                            } else 
                                                                echo("<div align=\"center\">No estimated time</div>"); 
                                                                      ?>
                                                        </span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width:
                                                <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($panel["estTime"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($panel["Start_date"])) / ((strtotime("now") - strtotime($panel["Start_date"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                            ">
                                                <span class="sr-only">55% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>
                    </div>
                    <?php       }
                            }
                        } ?>


                        <?php if ($result = $mysqli->query("
                            SELECT Q_id, estTime, Start_date, Dev_id, Devgr_id
                            FROM wait_queue
                            WHERE `Operator` = '$operator' AND `valid` = 'Y' AND `Dev_id` IS NULL;
                        ")){
                        while ( $panel = $result->fetch_assoc() ){ ?>
                    <?php   if($panel["Start_date"]) { 
                                $deviceGroup = new DeviceGroup($panel['Devgr_id']);?>
                    <div class="col-lg-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fas fa-ticket-alt fa-spin fa-fw"></i>
                                <span class="sr-only">Loading...</span> Wait Ticket -
                                <?php echo $deviceGroup->getDg_desc(); ?>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div id="job-info" style="margin-left: 25px;">
                                        <h6>
                                            Number
                                        </h6>
                                        <h3>
                                            #
                                            <?php echo ("$panel[Q_id]"); ?>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div style="margin-top: 15px">
                                        <p>
                                            <strong>Est. Wait:</strong>
                                            <span class="pull-right text-muted">
                                                        <?php //echo("<div>".date( 'M d g:i a',strtotime($panel["Start_date"]) )."</div>" );
                                                            if (isset($panel["estTime"])) {
                                                                echo("<div id=\"est".$panel["Q_id"]."\">".$panel["estTime"]." </div>" );
                                                                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $panel["estTime"]);
                                                                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                                                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds- (time() - strtotime($panel["Start_date"]) ) + $sv["grace_period"];
                                                                array_push($job_array, array($panel["Q_id"], $time_seconds, $deviceGroup->getDg_id()));
                                                            } else 
                                                                echo("<div align=\"center\">No estimated time</div>"); 
                                                                      ?>
                                                        </span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width:
                                                <?php 
                                                            // Est Time Percentage = (now - start) / ((now - start) + est) * 100
                                                            sscanf($panel["estTime"], "%d:%d:%d", $hours, $minutes, $seconds);
                                                            $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                                                            $percentage = (strtotime("now") - strtotime($panel["Start_date"])) / ((strtotime("now") - strtotime($panel["Start_date"])) + $time_seconds) * 100;

                                                            echo $percentage."%";
                                                        ?> 
                                            ">
                                                <span class="sr-only">55% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>
                    </div>
                    <?php       }
                            }
                        } ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
<?php
        //Standard call for dependencies
        include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
        ?>
    <!-- /#wrapper -->
<script>
<?php foreach ($job_array as $da) { ?>
	var time = <?php echo $da[1];?>;
	var display = document.getElementById('est<?php echo $da[0];?>');
	var dg_parent = <?php if ($da[2]) echo $da[2]; else echo "0";?>;
	startTimer(time, display, dg_parent);
	
<?php } ?>
</script>