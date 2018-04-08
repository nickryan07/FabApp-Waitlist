<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2018
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');


$queueID = $_REQUEST["q_id"];

try {
    $queueItem = new Wait_queue($queueID);
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    $_SESSION['type'] = "error";
}

// Delete the user from the waitlist
echo ("Removing from Queue #" + $queueItem->getQ_ID());
Wait_queue::deleteFromWaitQueue($queueItem);



?>