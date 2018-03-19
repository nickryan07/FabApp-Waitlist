<?php
date_default_timezone_set('America/Chicago');
require_once("connections/db_connect8.php");
require_once("fablab/wait.php");
require_once("site_variables.php");
session_start();

//Pull uPrint material Price
if ($result = $mysqli->query("
	SELECT device_materials.m_id, price
	FROM materials
	LEFT JOIN device_materials
	ON materials.m_id = device_materials.m_id
	WHERE dg_id = 7
")){
	while( $row = $result->fetch_assoc() ) {
		$mats[$row["m_id"]] = $row["price"];
	}
		$result->close();
}

//When the user hits the submit button the page will reload and the request method is post
//I removed this user_name requirement for testing purposes
//if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_name"])) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//3D Numbers
    if( isset($_POST['sBtn']) ){
		$serving = $_POST["serving"];
		if (preg_match("/^\d{1,3}$/",$serving) == 0) {
			echo ("3D - Invalid Number");
		} else {
			if ($result = $mysqli->query("
			  UPDATE site_variables
			  SET value = $serving
			  WHERE site_variables.name = 'serving';
			")){
				header("Location:tools.php");
			} else {
				echo("SQL Error");
			}
		}
	}
	//print new wait tab and advance the number
    if( isset($_POST['sPrint']) ){
		$i = $sv['sNext']+1;
		
		//calls function that prints out the wait tab
//Disabled for testing this would call the thermal printer
		//wait($i);
		
		if ($result = $mysqli->query("
		  UPDATE site_variables
		  SET value = $i
		  WHERE site_variables.name = 'sNext';
		")){
			header("Location:tools.php");
		} else {
			echo("SQL Error");
		}
	}
	
	//Laser Numbers
    if( isset($_POST['lBtn']) ){
		$Lserving = $_POST["Lserving"];
		if (preg_match("/^\d{1,3}$/",$Lserving) == 0) {
			echo ("3D - Invalid Number");
		} else {
			if ($result = $mysqli->query("
			  UPDATE site_variables
			  SET value = $Lserving
			  WHERE site_variables.name = 'Lserving';
			")){
				header("Location:tools.php");
			} else {
				echo("SQL Error");
			}
		}
	}
	//Burn new wait tab and advance the number
    if( isset($_POST['lPrint']) ){
		$i = $sv['lNext']+1;
		
		//calls function that prints out the wait tab
//Disabled for testing this would call the thermal printer
		//wait("L".$i);
		
		if ($result = $mysqli->query("
		  UPDATE site_variables
		  SET value = $i
		  WHERE site_variables.name = 'lNext';
		")){
			header("Location:tools.php");
		} else {
			echo("SQL Error");
		}
	}
	
	//Reset the System
	if( isset($_POST['resetBtn']) ){
		if (strcmp("super", $_POST['resetStr']) == 0){
			//reset 3D Issue Number
			if ($result = $mysqli->query("
			  UPDATE site_variables
			  SET value = '0'
			  WHERE site_variables.name = 'sNext' OR site_variables.name = 'lNext'
			  OR site_variables.name = 'serving' OR site_variables.name = 'Lserving';
			")){
			} else {
				echo("SQL Error");
			}
			
			header("Location:tools.php");
		} else {
			echo("<script>alert('You must have the password to reset the count.');</script>");
		}
	}
}
?>
<html>
<head>
	<link rel="shortcut icon" href="images/FabLab_Favicon.png" type="image/png">
	<title>FabLab Tools</title>
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<div class="main">
<?php 
//Removed requirement to login
//if( isset($_SESSION["user_name"]) ) {
if( true ) {
?>
<form id="tform" name="tform" method="post" action=""> 
	<table border="0" cellpadding="10" cellspacing="1" align="center" width="400">
		<tr>
			<td align="center" bgcolor="2b2b2b" style="width:2000px"><p style="color:white">3D Printer</p></td>
			<td align="center" bgcolor="4298f4" style="width:2000px"><b>Laser</b></td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b"><p style="color:white">Now Serving : <?php echo $sv['serving'];?></p></td>
			<td bgcolor="4298f4"><b>Now Serving : L<?php echo $sv['Lserving'];?></b></td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b"><p style="color:white">Enter Number</p><input type="number" name="serving" value="<?php echo $sv['serving'];?>" min="0" max="999" style="width: 4em" ><input type="submit" name="sBtn" value="Update"></td>
			<td bgcolor="4298f4"><b>Enter Number</b><br><input type="number" name="Lserving" value="<?php echo $sv['Lserving'];?>" min="0" max="999" style="width: 4em" ><input type="submit" name="lBtn" value="Update"></td>
		</tr>
		<tr>
        	<td colspan="2">Wait-Tab: Prints out a thermal paper of the next number for a specific wait-line.</td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b"><p style="color:white">Next Issuable<br>Number : <?php echo $sv['sNext']+1;?></p></td>
			<td bgcolor="4298f4"><b>Next Issuable<br>Number : L<?php echo $sv['lNext']+1;?></b></td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b" align="center"><input type="submit" name="sPrint" value="Print"></td>
			<td bgcolor="4298f4" align="center"><input type="submit" name="lPrint" value="Print"></td>
		</tr>
		<tr>
        	<td align="center" colspan="2">Resets Both Counting Systems (No Undos)<br><input type="password" size="5" maxlength="5" name="resetStr"><input type="submit" name="resetBtn" value="Reset"></td>
		</tr>
	</table>
</form>

<?php } else {?>
	<table border="0" cellpadding="10" cellspacing="1" align="center" width="400">
		<tr>
			<td align="center" bgcolor="2b2b2b" style="width:2000px"><p style="color:white">3D Printer</p></td>
			<td align="center" bgcolor="4298f4" style="width:2000px"><b>Laser</b></td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b"><p style="color:white">Now Serving : <?php echo $sv['serving'];?></p></td>
			<td bgcolor="4298f4"><b>Now Serving : L<?php echo $sv['Lserving'];?></b></td>
		</tr>
		<tr>
			<td bgcolor="2b2b2b"><p style="color:white">Next Issuable<br>Number : <?php echo $sv['sNext']+1;?></p></td>
			<td bgcolor="4298f4"><b>Next Issuable<br>Number : L<?php echo $sv['lNext']+1;?></b></td>
		</tr>
	</table>
<?php } ?>
    <table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
        <tr class="tableheader">
            <td align="center" colspan="2"><h1>Cost Estimation</h1></td>
        </tr>
		<tr class="tablerow" >
			<td align="Center"id="poly-1">PolyPrinter</td>
			<td id="poly-2"><input type="number" id="volume2" autocomplete="off" min="0" max="1000" step=".5" tabindex="2" onchange="polyPrinter()" onkeyup="polyPrinter()"> grams
			<div><div id="poly-3" style="float:left">$ 0.00 </div></div></td>
		</tr>
		<tr class="tablerow" >
			<td align="Center"id="vinyl-1">Vinyl</td>
			<td id="vinyl-2"><input type="number" id="volume3" autocomplete="off" min="0" max="1000" step=".5" tabindex="3" onchange="vinyl()" onkeyup="vinyl()"> inches
			<div><div id="vinyl-3" style="float:left">$ 0.00 </div></div></td>
		</tr>
		<tr class="tableheader">
			<td align="center" colspan=2>uPrint Cost<div id="uprint" style="float:right">$ 0.00 </div></td>
		</tr>
		<tr class="tablerow">
			<td align="center">Model Material</td>
			<td><input type="number" id="v1" autocomplete="off" min="0" max="1000" step=".01" tabindex="2" onchange="uPrint()" onkeyup="uPrint()"> in^3<div class="message"></div></td>
		</tr>
		<tr class="tablerow">
			<td align="center">Support Material</td>
			<td><input type="number" id="v2" autocomplete="off" min="0" max="1000" step=".01" tabindex="3" onchange="uPrint()" onkeyup="uPrint()"> in^3</td>
		</tr>
        <tr class="tableheader">
		<?php if( isset($_SESSION["user_name"]) ) { ?>
            <td align="center" colspan="2"><a href="home.php">Home</a></td>
		<?php } else { ?>
            <td align="center"><a href="home.php">Home</a></td>
            <td align="center"><a href="login.php">Login</a></td>
		<?php } ?>
        </tr>
    </table>
</div>
<script type="text/javascript">
setTimeout(function(){window.location.reload(1)}, 301000);

function resetForm() {
		document.getElementById("form").reset();
	}

function uPrint () {
	var conv_rate = <?php echo $sv['uprint_conv'];?>;
	var rate1 = <?php echo $mats['27'];?>;
	var rate2 = <?php echo $mats['32'];?>;
	var volume1 = document.getElementById("v1").value;
	var volume2 = document.getElementById("v2").value;
	var total = ( (volume1 * conv_rate * rate1)+(volume2 * conv_rate * rate2) ).toFixed(2);
	document.getElementById("uprint").innerHTML = "$ " + total;
}
function polyPrinter() {
	var rate = .05;
	var volume = document.getElementById("volume2").value;
	var total = (volume * rate).toFixed(2);
	document.getElementById("poly-3").innerHTML = "$ " + total;
}
function vinyl() {
	var rate = .25;
	var volume = document.getElementById("volume3").value;
	var total = (volume * rate).toFixed(2);
	document.getElementById("vinyl-3").innerHTML = "$ " + total;;
}
	
</script>
</body>
</html>