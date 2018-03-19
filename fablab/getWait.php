<?php
/*
 *
 *  Jonathan Le, Super FabLabian
 *	FabLab @ University of Texas at Arlington
 
 *  version: 0.88 beta (2017-04-19)
 *
*/
session_start();
include_once (__DIR__.'/../connections/db_connect8.php');
require_once(__DIR__.'/../site_variables.php');

echo ("<table border='0' cellpadding='5' cellspacing='1' align='center' width='800'>\n");
echo ("	<tr>");
	if($sv["sNext"] != 0) {
		echo ("<td align='center' bgcolor='2b2b2b' style='width:150px'><p style='color:white'><b>3D Printers</b><br>Now Serving</p></td>\n");
	} if($sv["lNext"] != 0) {
		echo("<td align='center' bgcolor='4298f4' style='width:150px'><p style='color:white'><b>Lasers</b><br>Now Serving</p></td>\n");
	} if($sv["lNext"] != 0 || $sv["sNext"] != 0) {
		echo("<td rowspan='3'>");
		echo("<b>1.</b> When entering the FabLab, please check in with a FabLab staff member to be added to the waiting list for the equipment you wish to use and receive your number.\n");
		echo("<br><br><b>2.</b> Work with the FabLab staff to ensure that your files are clean and ready for machining. By properly preparing your designs before your number is called, you will help the staff to minimize lag time between machine uses.\n");
		echo("<br><br><b>3.</b> The times listed here are estimates and are subject to error; a printer may become available before the projected timespan has passed. More than one machine can become available within a short amount of time. Remain in the lab to ensure that you will not miss your number being called.\n");
		echo("<br><br><a href='http://fablab.uta.edu/policy/' style='color:blue'>UTA FabLab's Waiting List Policy</a>");
		echo("</td>");
	}
	echo("</tr>\n");
	echo("<tr>\n");
	if($sv["sNext"] != 0) {
		echo("<td bgcolor='2b2b2b' align='center' ><div id='serving' style=\"font-family: 'Raleway', sans-serif; color:red; font-size:800%;
			margin-top:-30px; margin-bottom:0px\">".$sv['serving']."</div></td>");
	} if($sv['lNext'] != 0) {
		echo("<td bgcolor='4298f4' align='center' ><div id='Lserving' style=\"font-family: 'Raleway', sans-serif; color:red; font-size:800%;
			margin-top:-30px; margin-bottom:-20px\">L".$sv['Lserving']."</div></td>");
	}
	echo("</tr>\n");
	echo("<tr>\n");
	if($sv["sNext"] != 0) {
		echo("<td bgcolor='2b2b2b'><p style='color:white'>Next Issuable<br>Number : ".($sv['sNext']+1)."</p></td>");
	} if($sv['lNext'] != 0) {
		echo("<td bgcolor='4298f4'><b>Next Issuable<br>Number : L".($sv['lNext']+1)."</b></td>");
	}
	echo("</tr>\n");
echo("</table>");
?>