<?php
 
include_once ($_SERVER ['DOCUMENT_ROOT'] . '/connections/db_connect8.php');
include_once ($_SERVER ['DOCUMENT_ROOT'] . '/class/all_classes.php');



if (!empty($_GET["val"])) {
    $value = $_GET["val"];

    if (strpos($value, 'DG') !== false) {
        $dg_id = str_replace("DG_","",$value);
        echo ("dg_id = $dg_id");

        if ($dg_id !="" && DeviceGroup::regexDgID($dg_id)) {
            // Select all of the MAV IDs that are waiting for this device group
            $result = $mysqli->query ( "
                SELECT `Operator`
                FROM `wait_queue`
                WHERE `Devgr_id` = $dg_id AND `Valid` = 'Y'
                ORDER BY `Q_id` ASC
            " );
	
            echo "<select>";
            while($row = mysqli_fetch_array($result))
            {
                echo '<option value="'.$row["Operator"].'">'; echo $row["Operator"]; echo "</option>";
            }
            echo "</select>";
        
        }
    }

    elseif (strpos($value, 'D') !== false) {
        $d_id = str_replace("D_", "", $value);

        if ($d_id !="" && Devices::regexDID($d_id)) {

            // Select all of the MAV IDs that are waiting for this device
            $result = $mysqli->query ( "
                SELECT `Operator`
                FROM `wait_queue`
                WHERE `Dev_id` = $d_id AND `Valid` = 'Y'
                ORDER BY `Q_id` ASC
            " );
	
            echo "<select>";
            while($row = mysqli_fetch_array($result))
            {
                echo '<option value="'.$row["Operator"].'">'; echo $row["Operator"]; echo "</option>";
            }
            echo "</select>";
        
        }
    }
}

?>

<?php
// Standard call for dependencies
include_once ($_SERVER ['DOCUMENT_ROOT'] . '/pages/footer.php');
?>