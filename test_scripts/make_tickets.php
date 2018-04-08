<?php 

include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');

$d_id = isset($_GET["d_id"]) ? $_GET["d_id"] : NULL;
$dg_id = isset($_GET["dg_id"]) ? $_GET["dg_id"] : NULL;

if (!isset($d_id) && !isset($dg_id))
{
    echo ("Enter parameters: d_id for device id <br/>or dg_id for device group id");
    return;
}

$device_group = $dg_id;
global $mysqli;



// Make as many transaction tickets for the device group as possible




    // Make as many wait tickets for the device groups as they can 
if ($result = $mysqli->query("
    SELECT `devices`.`d_id`,`devices`.`dg_id`
    FROM `devices` JOIN `device_group` ON `devices`.`dg_id` = `device_group`.`dg_id`
    LEFT JOIN (SELECT `trans_id`, `t_start`, `t_end`, `est_time`, `d_id`, `operator`, `status_id` FROM `transactions` WHERE `status_id` < 12 ORDER BY `trans_id` DESC) as t 
    ON `devices`.`d_id` = `t`.`d_id`
    WHERE `public_view` = 'Y' AND `device_group`.`dg_id` = $device_group AND `devices`.`d_id` NOT IN (

        SELECT `d_id`
        FROM `service_call`
        WHERE `solved` = 'N'
    )
    ")) { 
        $startID = 1000000000;
        while ($row = $result->fetch_assoc())
        {
            $estTime = "0".rand(0,4).":".rand(10,59).":".rand(10,59);
           
            if ($mysqli->query("
                INSERT INTO transactions 
                (`operator`,`d_id`,`t_start`,`status_id`,`p_id`,`est_time`,`staff_id`) 
                VALUES
                    (".$startID++.",".$row['d_id'].",CURRENT_TIMESTAMP,'10','1','$estTime','1000000010');
            ")){ }

            if ($mysqli->query("
                INSERT INTO wait_queue 
                (`operator`,`devgr_id`,`start_date`) 
                VALUES
                    (".$startID++.",".$row['dg_id'].", CURRENT_TIMESTAMP);
            ")){ }
        }
        Wait_queue::calculateWaitTimes();

}




?>