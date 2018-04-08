<?php 
 include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');

 echo ("<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>");
 echo ("NOW = ".strtotime("now")."<br/>");
 echo ("T_START = ".strtotime("2018-04-08 12:51:15")."<br/>");

 $estTime = "04:55:16";
 list($hours, $minutes, $seconds) = explode(":", $estTime);
 $estSeconds = ($hours * 3600 + $minutes * 60 + $seconds);
 echo ("2nd EST_TIME: ".$estSeconds."<br/>");

 $seconds = strtotime("2018-04-08 12:51:15") + $estSeconds - strtotime("now");
 echo ("REMAINING TIME: ".$seconds."<br/>");
 
 $rhours = floor($seconds / 3600);
 $rmins = floor($seconds / 60 % 60);
 $rsecs = floor($seconds % 60);
 $timeFormat = sprintf('%02d:%02d:%02d', $rhours, $rmins, $rsecs);
echo ("TIME FORMAT: ".$timeFormat."<br/>");


?>