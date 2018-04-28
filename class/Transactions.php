<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */

/**
 * Transactions
 * A ticket is generated every time an operator uses a piece of equipment.
 * @author Jon Le
 */
 
//Thermal Reciept Dependancies
require_once ($_SERVER['DOCUMENT_ROOT'].'/api/php_printer/autoload.php');
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
 
class Transactions {
    private $device;
    private $duration;
    private $est_time;
    private $purpose;
    private $user;
    private $staff;
    private $status;
    private $t_start;
    private $t_end;
    private $trans_id;
    //Objects
    private $ac;
    private $mats_used;
    
    public function __construct($trans_id){
        global $mysqli;
        
        if (!preg_match("/^\d+$/", $trans_id))
            throw new Exception("Invalid Ticket Number : $trans_id");
        
        if ($result = $mysqli->query("
            SELECT *
            FROM transactions
            WHERE trans_id = $trans_id
            LIMIT 1;
        ")){
            if ($result->num_rows == 0 ){
                throw new Exception("Ticket Not Found : $trans_id");
            }
            $row = $result->fetch_assoc();
            $this->setAc($trans_id);
            $this->setDevice($row['d_id']);
            $this->setDuration($row['duration']);
            $this->setEst_time($row['est_time']);
            $this->setUser($row['operator']);
            $this->setPurpose($row['p_id']);
            $this->setStaffWId($row['staff_id']);
            $this->setStatus_id($row['status_id']);
            $this->setT_end($row['t_end']);
            $this->setT_start($row['t_start']);
            $this->setTrans_id($row['trans_id']);
            $this->setMats_used($row['trans_id']);
        }
        
    }
    
    //Returns {String if error, False if there is a cost, & True if ticket & Mats have been closed}
    public function end($status_id, $staff){
        global $mysqli;
        global $sv;
        $this->setStaff($staff);
        $this->setStatus_id($status_id);
        
        //If there is a remaining balance, exit
        //Sets Duration & end time
        $total = $this->quote();
        if ($this->status->getStatus_id() != 12 && abs($total - 0.001) > .005){
            debug("Total $total");
            return false;
            //return "$".$total;
        }

        if( $staff->getRoleID() < $sv['LvlOfStaff'] && $staff->getOperator() != $this->getUser()->getOperator()){
            //The closing ID must be a certain level
            //Or they must not be closing their own ticket
            return "You are unable to close this ticket ".$this->getTrans_id();
        }
        
        $msg = $this->writeAttr();
        if (is_string($msg)){
            return $msg;
        }
        
        // Remove to allow for various statuses to be applied to each MU
        foreach ($this->getMats_used() as $mu){
            //Change Status and Assign Staff
            $msg = $mu->end($this->getStatus()->getStatus_id(), $staff);
            if (is_string($msg)){
                //method states failure
                //return "Error Updating Material Used";
                return $msg;
            }
        }
        return true;
    }
    
    public function end_juicebox(){
        global $mysqli;
        
        $total = $this->quote();
        if (abs($total - 0.001) > .005){
            //Status = Moveable
            //Intended to block additional Power On Until Learner Pays Balance
            // Alt logic, payments get placed into a "tab"
            $status_id = 11;
        } else {
            $status_id = 14;
        }
        if ($mysqli->query("
            UPDATE `transactions`
            SET `t_end` = '$this->t_end', `duration` = '$this->duration', `status_id` = '$status_id'
            WHERE `trans_id` = '$this->trans_id';
        ")){
            if ($mysqli->affected_rows == 1){
                return true;
            } else {
                return "Check end_juicebox.php";
            }
        }
    }
	
    public static function insertTrans($operator, $d_id, $est_time, $p_id, $status_id, $staff) {
        global $mysqli;

        //Validate input variables
        if (!Devices::regexDID($d_id))return "Bad Device";
        if (Devices::is_open($d_id)) return "Is Open";
        if (!self::regexTime($est_time)) return "Bad Time - $est_time";
        if (!Purpose::regexID($p_id)) return "Invalid Purpose";
        if (!Status::regexID($status_id)) return "Invalid Status";
        
        // This function checks to see if a corresponding wait ticket exists, and invalidates it if so
        Wait_queue::transferFromWaitQueue($operator->getOperator(), $d_id);
        
        if ($mysqli->query("
            INSERT INTO transactions 
              (`operator`,`d_id`,`t_start`,`status_id`,`p_id`,`est_time`,`staff_id`) 
            VALUES
                ('".$operator->getOperator()."','$d_id',CURRENT_TIMESTAMP,'$status_id','$p_id','$est_time','".$staff->getOperator()."');
        ")){
            return $mysqli->insert_id;
        } else {
            return $mysqli->error;
        }
    }

    public function getAc() {
        return $this->ac;
    }

    public function getDevice() {
        return $this->device;
    }

    public function getDuration() {
        if (strcmp($this->duration,"") == 0)
                return "";
        $sArray = explode(":", $this->duration);
        $time = "$sArray[0]h $sArray[1]m $sArray[2]s";
        return $time;
    }

    public function getEst_time() {
        return $this->est_time;
    }

    public function getMats_used() {
        return $this->mats_used;
    }

    public function getPurpose() {
        return $this->purpose;
    }

    public function getUser() {
        return $this->user;
    }

    public function getStaff() {
        return $this->staff;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getT_start() {
        global $sv;
        return date($sv['dateFormat'],strtotime($this->t_start));
        //return $this->t_start;
    }

    public function getT_end() {
        global $sv;
        if (strcmp($this->t_end, "") == 0)
            return "";
        return date($sv['dateFormat'],strtotime($this->t_end));
    }

    public function getTrans_id() {
        return $this->trans_id;
    }
    
    public function move($staff){
        global $mysqli;
        global $sv;
        $this->setStaff($staff);
	$letter = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

        if( $staff->getRoleID() < $sv['LvlOfStaff']){
            return "You are unable to alter this ticket ".$this->getTrans_id();
        }
        
        //Update Transaction with End time, Duration, and Status
        if ($this->writeAttr() === true){
            //Log moving item into ObjManager
            return ObjBox::insert_Obj($this->trans_id, $staff);
        } else {
            return "T352: updateError ".$mysqli->error;
        }
    }
	
    public static function printTicket($trans_id, $est_amount){
        global $mysqli;
        global $sv;
        $est_cost = 0;

        //Pull Ticket Related Information
        $ticket = new self($trans_id);

        // Set up Printer Connection
        /*
        $tp_array = explode("|", $sv['thermalPrinter1']);
        $tpHost = $tp_array[0];
        $tpPort = $tp_array[1];
        */
        // Hardcoded, please remove later
        $tpHost = "129.107.37.13";
        $tpPort = 9100;
        try {
            $connector = new NetworkPrintConnector( $tpHost, $tpPort);
            $printer = new Printer($connector);
        } catch (Exception $e) {
            return "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

        try {
            // Print Generic Header
            $img = EscposImage::load($_SERVER['DOCUMENT_ROOT']."/images/fablab2.png", 0);
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> graphics($img);
            $printer -> feed();
            $printer -> text($ticket->getT_start());
            $printer -> feed();
            $printer -> text("Ticket: " . $ticket->getTrans_id());
            $printer -> feed();
            //Body
            $printer -> feed();
            $printer -> text("Device:   ".$ticket->getDevice()->getDevice_desc());
            //Print Each Material
            foreach ($ticket->getMats_used() as $mu) {
                $printer -> feed();
                $printer -> text("Material:   ".$mu->getMaterial()->getM_name());

                $filename = $mu->getHeader();
                $printer -> feed();
                if ($mu->getUnit_used() > 0){
                    $printer -> text("Est. Amount:   ".$mu->getUnit_used()." ".$mu->getMaterial()->getUnit());
                    //Calculate Cost
                    $est_cost += $mu->getMaterial()->getPrice() * $mu->getUnit_used();
                } elseif (isset($est_amount)) {
                    $printer -> text("Est. Amount:   ".$est_amount." ".$mu->getMaterial()->getUnit());
                    //Calculate Cost
					$est_cost += $mu->getMaterial()->getPrice() * $est_amount;
                }
            }
            $printer -> feed();
            $printer -> text("Est. Cost:   ");
            $printer -> text("$ ".number_format($est_cost,2));
            $printer -> feed();
            $printer -> text("Est. Duration:   ".$ticket->getEst_time());
            if ($filename){
                    $printer -> feed();
                    $printer -> text("File:   ".$filename);
            }
            $printer -> feed(3);
            $printer -> text("Address: ______________________");
            $printer -> feed();
            $printer -> text("Potential Problems?  ( Y )  ( N )");
			$printer -> feed();
			$printer -> text("NOTES: _________________________");
			$printer -> feed(2);
			$printer -> text("________________________________");
			$printer -> feed(2);
			$printer -> text("________________________________");
			$printer -> feed(3);
			$printer -> graphics(EscposImage::load($_SERVER['DOCUMENT_ROOT']."/images/sig.png", 0));
			//EscposImage::load($_SERVER['DOCUMENT_ROOT']."/images/fablab2.png", 0);
			
            $printer -> feed();
            $printer -> text("http://fablab.uta.edu/");
            $printer -> feed();
            $printer -> text("(817) 272-1785");
            $printer -> feed(2);
            $printer -> cut();
        } catch (Exception $print_error) {
            return $print_error->getMessage();
        }

        try {
            /* Close printer */
            $printer -> close();
        } catch( Exception $e) {
            echo "printer was not open";
        }
    }
    
    //return the Estimated cost for this ticket, set duration and t_end
    public function quote(){
        global $sv;
        $cost = 0;
        
        //Add up costs of materials
        foreach ($this->getMats_used() as $mu){
            if ($mu->getStatus()->getStatus_id() != 12){
                $cost += $mu->getUnit_used() * $mu->getMaterial()->getPrice();
            }
        }
        //Find the difference between right now and the start time
        //Format duration into standard form
        if ($this->getDuration()){
            $sArray = explode(":", $this->duration);
            $diff = $sArray[0] + $sArray[1]/60 + $sArray[2]/3600;
        } else {
            //Set End Time
            $this->setT_end(date("Y-m-d H:i:s", strtotime("now")));
            
            $diff = strtotime($this->t_end) - strtotime($this->t_start);
            $h = floor($diff / 3600);
            $m = $diff / 60 % 60;
            $s = $diff % 60;
            $this->setDuration("$h:$m:$s");
            $diff = $diff/3600;
        }
        
        //Minimum Time Interval
        if ($diff < $sv['minTime']){
            $diff = $sv['minTime'];
        }
        
        //echo sprintf("<br>Mats Cost = $%.2f", $cost);
        $cost += $diff * $this->getDevice()->getBase_price();
        
        //Take Current Cost - (what has already been paid for)
        //Add .0001 to prevent negative rounding errors
        return ($cost - $this->totalAC() + .001);
    }

    public static function regexTime($duration) {
        if ( preg_match("/^\d{1,3}:\d{2}:\d{2}$/", $duration) == 1 )
            return true;
        return false;
    }
	
	public static function regexPhone($phone) {
        if ( preg_match("/^\d{10}$/", $phone) == 1 )
            return true;
        return false;
    }
    
    public static function regexTrans($trans_id){
        global $mysqli;
        
        if(!preg_match("/^\d+$/", $trans_id)){
            return false;
        }
        
        //Check to see if transaction exists
        if ($result = $mysqli->query("
            SELECT *
            FROM transactions
            WHERE trans_id = $trans_id
            LIMIT 1;
        ")){
            if ($result->num_rows == 1)
                return true;
            return false;
        } else {
            return false;
        }
    }

    public function setAc($trans_id) {
        $this->ac = Acct_charge::byTrans_id($trans_id);
    }

    public function setDevice($d_id) {
        $this->device = new Devices($d_id);
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setEst_time($est_time) {
        $this->est_time = $est_time;
    }

    private function setMats_used($trans_id) {
        $this->mats_used = Mats_Used::byTrans($trans_id);
    }

    public function setPurpose($p_id) {
        $this->purpose = new Purpose($p_id);
    }

    public function setUser($operator) {
        $this->user = Users::withID($operator);
    }

    public function setStaffWId($staff_id) {
        $this->staff = Users::withID($staff_id);
    }

    public function setStaff($staff) {
        $this->staff = $staff;
    }

    public function setStatus_id($status_id) {
        $this->status = new Status($status_id);
    }

    private function setT_start($t_start) {
        $this->t_start = $t_start;
    }

    private function setT_end($t_end) {
        $this->t_end = $t_end;
    }

    private function setTrans_id($trans_id) {
        $this->trans_id = $trans_id;
    }
    
    public function totalAC(){
        $total = 0;
        foreach (Acct_charge::byTrans_id($this->trans_id) as $ac){
            if ($ac->getAccount()->getA_id() == 1 ){
                //Do not include OutStanding Charges
            } else {
                $total += $ac->getAmount();
            }
        }
        return $total;
    }
    
    //Writes all variables to the DB for a given Transaction
    public function writeAttr(){
        global $mysqli;
        
        if (strcmp($this->t_end, "") == 0)
            $t_end = "NULL";
        else 
            $t_end = "'$this->t_end'";
        
        if (strcmp($this->est_time, "") == 0)
            $est_time = "NULL";
        else 
            $est_time = "'$this->est_time'";
        
        if (strcmp($this->duration, "") == 0)
            $duration = "NULL";
        else 
            $duration = "'$this->duration'";
        
        if (strcmp($this->purpose->getP_id(), "") == 0)
            $purpose = "NULL";
        else 
            $purpose = "'".$this->purpose->getP_id()."'";
        
        if (is_object($this->staff)){
            $staff_id = "'".$this->staff->getOperator()."'";
        } else {
            $staff_id = "NULL";
        }
        
        if($mysqli->query("
            UPDATE `transactions`
            SET `d_id` = '".$this->device->getD_id()."', `operator` = '".$this->user->getOperator()."', `est_time` = $est_time,
                `t_start` = '$this->t_start', `t_end` = $t_end, `duration` = $duration,
                `status_id` = '".$this->status->getStatus_id()."', `p_id` = $purpose, `staff_id` = $staff_id
            WHERE `trans_id` = '$this->trans_id'
            LIMIT 1;
        ")){
            foreach($this->getMats_used() as $mu){
                $mu->writeAttr();
            }
            return true;
        } else {
            return $mysqli->error;
        }
    }
}
?>