<?php 

include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');

global $mysqli;

// Find all of the device groups that are being waited for
if ($result= $mysqli->query("
    SELECT DISTINCT Dev_id
    FROM wait_queue
    WHERE Dev_id IS NOT NULL;
")) {

    // For each group find how many devices are in the group and their current wait times
    while ($row = $result->fetch_assoc())
    {
        $device_id = $row['Dev_id'];
        echo ("This device ID is $device_id<br/>");
        if ($result2 = $mysqli->query("
            SELECT `devices`.`d_id`, `t_start`, `est_time`, `t_end`
            FROM `devices` JOIN `device_group` ON `devices`.`dg_id` = `device_group`.`dg_id`
                LEFT JOIN (SELECT `trans_id`, `t_start`, `t_end`, `est_time`, `d_id`, `operator`, `status_id` FROM `transactions` WHERE `status_id` < 12 ORDER BY `trans_id` DESC) as t 
                ON `devices`.`d_id` = `t`.`d_id`
            WHERE `public_view` = 'Y' AND `devices`.`d_id` = $device_id AND `devices`.`d_id` NOT IN 
            (
                SELECT `d_id`
                FROM `service_call`
                WHERE `solved` = 'N'
            )
            ORDER BY `device_group`.`dg_id`, `device_desc`
        ")) {
            // Create an array with size equal to the number of devices in that group that holds the number of seconds to wait 
            global $estTimes;

            // Set the remaining time of the current job on the device
            while ($row2 = $result2->fetch_assoc())
            {
                echo ("t_start is ".$row2['t_start']."<br/>");
                if (!isset($row2['t_start']))
                {
                    // Free Device because the start time is not set
                    echo ("Setting a time of zero<br/>");
                    $estTimes = 0;
                }
                elseif (isset($row2['t_start']) && isset($row2['est_time']) && !isset($row2['t_end']))
                {
                    list($hours, $minutes, $seconds) = explode(":", $row2['est_time']);
                    $estSeconds = ($hours * 3600 + $minutes * 60 + $seconds);
                    $timeLeft = strtotime($row2['t_start']) + $estSeconds - strtotime("now");

                    // The estimated time has expired but the print has not been ended by the staff
                    if ($timeLeft <= 0) {
                        echo ("Setting a time of zero but t_start and est_time is set<br/>");
                        $estTimes = 0;
                    }

                    // The print is ongoing so log the time
                    else {
                        $estTimes = $timeLeft;
                        echo ("Setting a time of $estTimes<br/>");
                    }
                }
            }

            // Assign estimated wait times to those in the wait queue
            // if the number of devices in the queue is greater than the number of devices in the group, then do not estimate times for those customers
            if ($result2 = $mysqli->query("
                SELECT Q_id
                FROM wait_queue WQ JOIN devices D ON WQ.Dev_id = D.d_id
                WHERE valid = 'Y' AND WQ.Dev_id = $device_id
                ORDER BY Q_id;
            ")) {
                
                // For each person waiting in this device
                $count = 0;
                while ($row2 = $result2->fetch_assoc())
                {
                    echo ("    ".$row2['Q_id']."<br/>");
                    // If they are the first person waiting, then assign them an estimated wait time
                    if ($count < 1) {
                        $rhours = floor($estTimes / 3600);
                        $rmins = floor($estTimes / 60 % 60);
                        $rsecs = floor($estTimes % 60);
                        $timeFormat = sprintf('%02d:%02d:%02d', $rhours, $rmins, $rsecs);

                        if ($result3 = $mysqli->query("
                            UPDATE wait_queue
                            SET estTime = '$timeFormat'
                            WHERE Q_id = ".$row2['Q_id']."
                        ")) {
                            echo ("Set the time: $timeFormat!<br/>");
                        }
                    }

                    // If they are NOT the first person waiting, then do not give them an estimated wait time
                    else {
                        if ($result3 = $mysqli->query("
                            UPDATE `wait_queue`
                            SET `estTime` = NULL
                            WHERE `Q_id` = ".$row2['Q_id']."
                        ")) { echo ("set time to null<br/>"); }
                    }

                    $count++;
                }
            }
        }
    }
}



?>
