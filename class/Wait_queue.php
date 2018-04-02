<?php


class Wait_queue {
    private $device;
    private $device_group;
    private $start_time;
    private $end_time;
    private $wait_id;
    private $valid;
    
    public function __construct($q_id){
        global $mysqli;
        
        if (!preg_match("/^\d+$/", $q_id))
            throw new Exception("Invalid Ticket Number : $q_id");
        
        if ($result = $mysqli->query("
            SELECT *
            FROM wait_queue
            WHERE Q_id = $q_id
            LIMIT 1;
        ")){
            if ($result->num_rows == 0 ){
                throw new Exception("Ticket Not Found : $q_id");
            }
            $row = $result->fetch_assoc();
            $this->setWaitId($row['Q_id']);
            $this->setDevId($row['Dev_id']);
            $this->setDevgrId($row['Devgr_id']);
            $this->setStartTime($row['start_date']);
            $this->setEndTime($row['end_date']);
            $this->setValid($row['valid']);
        }
        
    }
    

    public static function insertWaitQueue($operator, $d_id, $dg_id, $phone, $email) {
        global $mysqli;
        
        /**
         * TODO: variable validation
         * d_id, dg_id
         */
        
        //Validate input variables
		if (!self::regexPhone($phone) && !empty($phone)) {
            echo ("Bad phone number - ");
            echo $phone;
            return "Bad phone number";
        }
        
        if (!self::regexOperator($operator)) {
            echo ("Bad operator number - ");
            echo $operator;
            return "Bad operator number";
        }
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
            echo ("Bad email - ");
            echo $email;
			return "Bad email";
		}
        
        if(isset($d_id)) {
            if ($mysqli->query("
            INSERT INTO operator_info
                (`Op_id`, `Op_email`, `Op_phone`, `last_contact`)
            VALUES
                ('$operator', '$email', '$phone', CURRENT_TIMESTAMP);
            ")){
                echo ("\nSuccessfully inserted ticket!");
                //insertContactInfo($operator, $phone, $email);
                if ($mysqli->query("
                INSERT INTO wait_queue 
                  (`operator`,`dev_id`,`start_date`) 
                VALUES
                    ('$operator','$d_id', CURRENT_TIMESTAMP);
            ")){

                    self::sendNotification($phone, "Fabapp Notification", "You have signed up for fabapp notifications. Your ticket number is: ".$mysqli->insert_id."", 'From: Fabapp Notifications' . "\r\n" .'');
                echo ("\nSuccessfully updated contact info!");
                return $mysqli->insert_id;
            } else {
                echo ("Error updating contact info!");
                return $mysqli->error;
            }
                return $mysqli->insert_id;
            } else {
                echo ("\nError updating ticket!");
                return $mysqli->error;
            }
        } else if(isset($dg_id)) {
            if ($mysqli->query("
            INSERT INTO operator_info
                (`Op_id`, `Op_email`, `Op_phone`, `last_contact`)
            VALUES
                ('$operator', '$email', '$phone', CURRENT_TIMESTAMP);
            ")){
                echo ("\nSuccessfully inserted ticket!");
                //insertContactInfo($operator, $phone, $email);
                if ($mysqli->query("
                INSERT INTO wait_queue 
                  (`operator`,`devgr_id`,`start_date`) 
                VALUES
                    ('$operator','$dg_id', CURRENT_TIMESTAMP);
                ")){

                    self::sendNotification($phone, "Fabapp Notification", "You have signed up for fabapp notifications. Your ticket number is: ".$mysqli->insert_id."", 'From: [your_gmail_account_username]@gmail.com' . "\r\n" .
            'MIME-Version: 1.0');
                    echo ("\nSuccessfully updated contact info!");
                    return $mysqli->insert_id;
                } else {
                    echo ("Error updating contact info!");
                    return $mysqli->error;
                }
                    return $mysqli->insert_id;
            } else {
                echo ("\nError updating ticket!");
                return $mysqli->error;
            }
        }
    }

    public static function insertContactInfo($operator, $op_phone, $op_email) {
        global $mysqli;

        //Validate input variables
		if (!self::regexPhone($op_phone)) {
            echo ("Bad phone number - ");
            echo $op_phone;
            return "Bad phone number";
        }
		
		if(!filter_var($op_email, FILTER_VALIDATE_EMAIL)) {
            echo ("Bad email");
			return "Bad email";
		}
        /**
         * TODO: Use IF EXISTS and to update if an operator already exists in the table
         */
        if ($mysqli->query("
            INSERT INTO operator_info
                (`Op_id`, `Op_email`, `Op_phone`, `last_contact`)
            VALUES
                ('$operator', '$op_email', '$op_phone', CURRENT_TIMESTAMP);
        ")){
            
            echo ("\nSuccessfully updated contact info!");
            return $mysqli->insert_id;
        } else {
            echo ("Error updating contact info!");
            return $mysqli->error;
        }
    }
    
    
    //Probaby needs to be a class
    public static function sendNotification($phone, $subject, $message, $headers) {
        global $mysqli;
        // This function needs to query the carrier table and send an email to all combinations
        /*if(mail("".$phone."@tmomail.net", $subject, $message, $headers))
            echo "Email sent";
        else
            echo "Email sending failed";*/
        if ($result = $mysqli->query("
            SELECT email
            FROM carrier
        ")){
            while ( $row = $result->fetch_assoc() ){
                mail("".$phone."".$row['email']."", $subject, $message, $headers);
            }
        } else {
            echo("Carrier query failed!");
        }
    }

    public static function regexPhone($phone) {
        if ( preg_match("/^\d{10}$/", $phone) == 1 )
            return true;
        return false;
    }
    
    public static function regexOperator($op_id) {
        if ( preg_match("/^\d{10}$/", $op_id) == 1 )
            return true;
        return false;
    }
    
    public function setWaitId($q_id) {
        $this->wait_id = $q_id;
    }

    public function setValid($op_id) {
        $this->valid = $valid;
    }

    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    private function setEndTime($end_time) {
        $this->end_time = $end_time;
    }

    private function setDevId($d_id) {
        $this->device = $d_id;
    }

    private function setDevgrId($dg_id) {
        $this->device_group = $dg_id;
    }
}
?>
