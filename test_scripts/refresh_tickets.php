<?php 

include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
global $mysqli;

if ($result = $mysqli->query("
    DELETE FROM `wait_queue` WHERE Q_id IS NOT NULL")) { }

if ($result = $mysqli->query("
    DELETE FROM `transactions` WHERE `trans_id` IS NOT NULL")) { }

    header('Location: /test_scripts/make_tickets.php?dg_id=2');
?>