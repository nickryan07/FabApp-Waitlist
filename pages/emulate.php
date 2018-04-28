<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2018
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code necessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['mBtn']) ){
    try {
        $trans_id = filter_input(INPUT_POST, "ticket");
        $ticket = new Transactions($trans_id);
    } catch (Exception $e) {
        $_SESSION['error_msg'] = "Invalid Ticket # - $trans_id";
        echo "<script>console.log( \"Debug : Invalid Ticket $trans_id\");</script>";
        header("Location: /pages/emulate.php");
    }
    
    //Inside the Transactions Class You should place your hook.
    $ticket->end_octopuppet();
    $_SESSION['success_msg'] = "Ticket $trans_id has been set to moveable";
    echo "<script>console.log( \"Debug : Ticket $trans_id set to Moveable\");</script>";
    header("Location: /index.php");
}
?>
<title><?php echo $sv['site_name'];?> Emulate Other Actions</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1>Emulate Other Actions</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Set Ticket to Moveable Status
                </div>
                <div class="panel-body">
                    <form name="anything" method="post" action="" onsubmit="return validateForm()" autocomplete='off'>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td align="Center">Ticket #</td>
                            <td><input value="<?php if (isset($trans_id)) echo $trans_id;?>" name="ticket" id="ticket" tabindex="1" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-danger btn-md pull-right" tabindex="5" name="mBtn">Set to Moveable</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-8 -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-calculator fa-fw"></i>End Wait-Tab
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-warning btn-md" tabindex="5" name="endBtn" data-toggle="modal" data-target="#endModal">End Wait-Tab Example</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
<div id="endModal" class="modal fade">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title">TM</h4>
            </div>
            <div class="modal-body text-center">
                Set Wait-Tab to 
                <select>
                    <option value="" disabled hidden>Select</option>
                    <option value="value_a">Canceled</option>
                    <option value="value_b">Skipped</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<script>
function validateForm(){
	
    var x = document.getElementById('ticket').value;
    var reg = /^\d+$/;
    if (x === null || x === "" || !reg.test(x)) {
        alert("Ticket # is Invalid");
        document.getElementById('ticket').focus();
        return false;
    }
    //Everything above was good
    return true;
}
</script>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>