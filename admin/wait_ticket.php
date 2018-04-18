<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$d_id = $dg_id = $operator = "";

if (!$staff || $staff->getRoleID() < 7){
    //Not Authorized to see this Page
    header('Location: /index.php');
	exit();
}
?>
<title><?php echo $sv['site_name'];?> Create Wait Ticket</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Wait Ticket</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <?php if ($staff && $staff->getRoleID() >= $sv['minRoleTrainer']) {?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-ticket-alt" aria-hidden="true"></i> Create New Wait Ticket
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover"><form name="wqform" id="wqform" autocomplete="off" method="POST" action="">
                            <tr>
                                <td><a href="#" data-toggle="tooltip" data-placement="top" title="Which device does this wait ticket belong to?">Select Device or Group</a></td>
                                <td>
                                <select name="d_id" id="d_id" onchange="selectDevice(this)" tabindex="1">
                                        <option disabled hidden selected value="">Device</option>
                                        <?php if($result = $mysqli->query("
                                            SELECT DISTINCT `devices`.`d_id`, `devices`.`device_desc`
                                            FROM `devices`
                                            INNER JOIN `device_group`
                                            ON `devices`.`dg_id` = `device_group`.`dg_id`
                                            WHERE `granular_wait` = 'Y'
                                            ORDER BY `device_desc`
                                        ")){
                                            while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[d_id]'>$row[device_desc]</option>");
                                            }
                                        } else {
                                            echo ("Device list Error - SQL ERROR");
                                        }?>
                                    </select> or <select name="dg_id" id="dg_id" onchange="selectDevice(this)" tabindex="2">
                                        <option disabled hidden selected value="">Device Group</option>
                                        <?php if($result = $mysqli->query("
                                            SELECT DISTINCT `device_group`.`dg_id`, `device_group`.`dg_desc`
                                            FROM `device_group`
                                            WHERE `granular_wait` = 'N'
                                            ORDER BY `dg_desc`
                                        ")){
                                            while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[dg_id]'>$row[dg_desc]</option>");
                                            }
                                        } else {
                                            echo ("Device list Error - SQL ERROR");
                                        }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#" data-toggle="tooltip" data-placement="top" title="The email of the person that you will issue a wait ticket for">(Optional) Email</a></td>
                                <td><input type="text" name="op-email" id="op-email" class="form-control" placeholder="email address" maxlength="100" size="10"/></td>
                            </tr>
                            <tr>
                                <td><a href="#" data-toggle="tooltip" data-placement="top" title="The phone number of person that you will issue a wait ticket for">(Optional) Phone</a></td>
                                <td><input type="text" name="op-phone" id="op-phone" class="form-control" placeholder="phone number" maxlength="10" size="10"/></td>
                            </tr>
                            <tr>
                                <td><a href="#" data-toggle="tooltip" data-placement="top" title="The person that you will issue a wait ticket for">Operator</a></td>
                                <td><input type="text" name="operator" id="operator" class="form-control" placeholder="1000000000" maxlength="10" size="10"/></td>
                            </tr>
                            <tr>
                                <td>
                                    <label><i class="fa fa-info-circle"></i> Disclaimer</label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="disclaimer" value="">I have read and understand the <a>FERPA release policies</a>.
                                            </label>
                                        </div>
                                        <?php
                                        if(isset($_POST['disclaimer'])) {
                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitBtn'])) {
                                                $operator = filter_input(INPUT_POST, 'operator');
                                                /*if(isset($device)) {
                                                    $wait_id = Wait_queue::insertWaitQueue($operator, $device->getD_id(), $est_time, $p_id, $status_id, $staff);
                                                } else if(isset($device, NULL, 2)) {
                                                    $wait_id = 
                                                }*/
                                                $d_id = filter_input(INPUT_POST,'d_id');
                                                $dg_id = filter_input(INPUT_POST,'dg_id');
                                                $em = filter_input(INPUT_POST,'op-email');
                                                $ph = filter_input(INPUT_POST, 'op-phone');
                                                $wait_id = Wait_queue::insertWaitQueue($operator, $d_id, $dg_id, $ph, $em);

                                                //$msg = false;

                                                //$msg = submitTM($tm_id, $operator, $staff);

                                                //if ($msg === true){
                                                 //   $_SESSION['type'] = 'tc_success';
                                                //    $_SESSION['tm_id'] = $tm_id;
                                                 //   header("Location:wait_ticket.php");
                                                //} else {
                                                 //   echo "<script type='text/javascript'> window.onload = function(){goModal('Error',\"$msg\", false)}//</script>";
                                                //}
                                            }
                                        } else {
                                            echo ("You must accept the disclaimer if you enter contact information.");
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><div class="pull-right"><input type="submit" name="submitBtn" value="Submit"></div></td>
                                </tr>
                            </tfoot>
                        </form>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            <?php } elseif($staff) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-sign-in-alt fa-lg"></i>  Issue wait ticket
                    </div>
                    <div class="panel-body">
                        <?php
                            echo ("To issue a wait ticket, you must be logged in as ".ROLE::getTitle($sv['minRoleTrainer'])." or higher.");
                        ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            <?php } else { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fas fa-sign-in-alt fa-lg"></i> Please Log In
                    </div>
                    <div class="panel-body">
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            <?php } ?>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>
<script type="text/javascript">
    function selectDevice(element){
        if (element.id == 'd_id'){
            document.getElementById("dg_id").selectedIndex = 0;
        } else if (element.id == 'dg_id') {
            document.getElementById("d_id").selectedIndex = 0;
        }
    }
    /*
    $('#teTable').DataTable({
        searching: false, 
        paging: false});
    
    //AJAX call to build a list of training modules for the specified device or device group
    function selectDevice(element){
        if (element.id == 'd_id'){
            document.getElementById("dg_id").selectedIndex = 0;
        } else if (element.id == 'dg_id') {
            document.getElementById("d_id").selectedIndex = 0;
        }
        document.getElementById("tm_id").selectedIndex = 0;
        document.getElementById("td_deviceList").innerHTML = "";

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("tr_tm").innerHTML = this.responseText;
                document.getElementById("tm_id").innerHTML = this.responseText;
                document.getElementById("tm_desc").innerHTML = "";
            }
        };
        device = element.id + "=" + element.value;
        xmlhttp.open("GET","sub/certTM.php?" + device,true);
        xmlhttp.send();
        
        //List Devices
        if (element.id == 'dg_id') {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp2 = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //document.getElementById("tr_tm").innerHTML = this.responseText;
                    document.getElementById("td_deviceList").innerHTML = this.responseText;
                }
            };
            device = element.id + "=" + element.value;
            xmlhttp2.open("GET","sub/certDevices.php?" + device,true);
            xmlhttp2.send();
        }
    }
    
    
    //AJAX call to build a list of training modules for the specified device or device group
    function getDesc(element){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tm_desc").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","sub/descTM.php?tm_id=" + element.value,true);
        xmlhttp.send();
    }*/
</script>