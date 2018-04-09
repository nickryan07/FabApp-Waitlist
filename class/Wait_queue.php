<?php


class Wait_queue {
    private $device;
    private $device_group;
    private $start_time;
    private $end_time;
    private $q_id;
    private $valid;
    private $operator;
    
    public function __construct($q_id){
        global $mysqli;

        if ($result = $mysqli->query("
            SELECT *
            FROM wait_queue
            WHERE `Q_id` = $q_id
            LIMIT 1;
        ")){
            if ($result->num_rows == 0 ){
                throw new Exception("Queue Number Not Found : $q_id");
            }
            $row = $result->fetch_assoc();
            $this->setWaitId($row['Q_id']);
            $this->setOperator($row['Operator']);
            $this->setDevId($row['Dev_id']);
            $this->setDevgrId($row['Devgr_id']);
            $this->setStartTime($row['Start_date']);
            $this->setEndTime($row['End_date']);
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
            ('$operator', '$email', '$phone', CURRENT_TIMESTAMP)
            ON DUPLICATE KEY UPDATE `Op_email` = '$email', `Op_phone` = '$phone';
            ")){
                echo ("\nSuccessfully inserted ticket!");
                if ($mysqli->query("
                INSERT INTO wait_queue 
                  (`operator`,`dev_id`,`start_date`) 
                VALUES
                    ('$operator','$d_id', CURRENT_TIMESTAMP);
            ")){
                Wait_queue::calculateWaitTimes();
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
            ('$operator', '$email', '$phone', CURRENT_TIMESTAMP)
            ON DUPLICATE KEY UPDATE `Op_email` = '$email', `Op_phone` = '$phone';
            ")){
                echo ("\nSuccessfully inserted ticket!");
                if ($mysqli->query("
                INSERT INTO wait_queue 
                  (`operator`,`devgr_id`,`start_date`) 
                VALUES
                    ('$operator','$dg_id', CURRENT_TIMESTAMP);
                ")){
                    Wait_queue::calculateWaitTimes();
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

    public static function isOperatorWaiting($operator) {
        global $mysqli;
        if ($result = $mysqli->query("
            SELECT COUNT(*) AS `Total`
            FROM `wait_queue`
            WHERE `Operator` = $operator AND `valid` = 'Y';
        "))
        {
            // If the count is greater than zero, then return true
            $row = $result->fetch_assoc();
            
            if ($row['Total'] > 0)
            {
                echo ("This operator is waiting on another ticket, so it's info won't be deleted");
                return true;
            }
            return false;
        }

        return false;
    }

    public static function deleteFromWaitQueue($queueItem)
    {
        global $mysqli;
        global $operator;

            if ($mysqli->query("
                UPDATE `wait_queue`
                SET `valid` = 'N'
                WHERE `Q_id` = $queueItem->q_id;
            ")) {
                echo("\nSuccessfully changed valid bit to 'N'!");
            }
            else {
                return $mysqli->error;
            }
        
        // Get the email or phone number of the student to send them a confirmation notification
        if ($result = $mysqli->query("
            SELECT *
            FROM `operator_info`
            WHERE `op_id` = $queueItem->operator
            LIMIT 1;
        ")) {
            $row = $result->fetch_assoc();
            if (isset($row['Op_phone'])) {
                // Send a notification that they have canceled their wait queue ticket
                self::sendNotification($row['Op_phone'], "Fabapp Notification", "Your Wait Ticket has been cancelled", 'From: Fabapp Notifications' . "\r\n" .'');
            }                 
        }
        else {
            echo ("Could not retrieve phone number of customer ID #$queueItem->operator");
        }
    
        // If they are not waiting for any other jobs, then delete their contact information
        if (!Wait_queue::isOperatorWaiting($queueItem->operator)) {
            Wait_queue::deleteContactInfo($queueItem->operator);
        }

        // Calculate new wait times based off a person leaving the wait queue
        Wait_queue::calculateWaitTimes();
    }

    public static function deleteContactInfo($operator)
    {
        global $mysqli;
        if ($mysqli->query("
            DELETE FROM `operator_info`
            WHERE `Op_id` = $operator
        "))
        {
            echo("\nSuccessfully deleted $operator contact info!");
        } else {
            echo ("Error deleting $operator contact info!");
        }
    }

    public static function calculateWaitTimes()
    {
        global $mysqli;

        // Find all of the device groups that are being waited for
        if ($result= $mysqli->query("
            SELECT DISTINCT Devgr_id
            FROM wait_queue
            WHERE Devgr_id IS NOT NULL;
        ")) {

            // For each group find how many devices are in the group and their current wait times
            while ($row = $result->fetch_assoc())
            {
                $device_group = $row['Devgr_id'];
                if ($result2 = $mysqli->query("
                    SELECT `devices`.`d_id`, `t_start`, `est_time`, `t_end`
                    FROM `devices` JOIN `device_group` ON `devices`.`dg_id` = `device_group`.`dg_id`
                    LEFT JOIN (SELECT `trans_id`, `t_start`, `t_end`, `est_time`, `d_id`, `operator`, `status_id` FROM `transactions` WHERE `status_id` < 12 ORDER BY `trans_id` DESC) as t 
                    ON `devices`.`d_id` = `t`.`d_id`
                    WHERE `public_view` = 'Y' AND `device_group`.`dg_id` = $device_group AND `devices`.`d_id` NOT IN (
                    
                        SELECT `d_id`
                        FROM `service_call`
                        WHERE `solved` = 'N'
                    )
                    ORDER BY `device_group`.`dg_id`, `device_desc`
                ")) {
                    // Create an array with size equal to the number of devices in that group that holds the number of seconds to wait 
                    $estTimes = array();

                    // Gather all of the times
                    while ($row2 = $result2->fetch_assoc())
                    {
                        if (!isset($row2['t_start']))
                        {
                            // Free Device because the start time is not set
                            array_push($estTimes, 0);
                        }
                        elseif (isset($row2['t_start']) && isset($row2['est_time']) && !isset($row2['t_end']))
                        {
                            list($hours, $minutes, $seconds) = explode(":", $row2['est_time']);
                            $estSeconds = ($hours * 3600 + $minutes * 60 + $seconds);
                            $timeLeft = strtotime($row2['t_start']) + $estSeconds - strtotime("now");

                            // The estimated time has expired but the print has not been ended by the staff
                            if ($timeLeft <= 0) {
                                array_push($estTimes, 0);
                            }

                            // The print is ongoing so log the time
                            else {
                                array_push($estTimes, $timeLeft);
                            }
                        }
                    }


                    
                    // Sort the array
                    sort($estTimes);

                    //echo "<br/><br/><br/><br/><br/><br/><br/>";
                    //echo '<pre>'; print_r($estTimes); echo '</pre>';

                    // Assign estimated wait times to those in the wait queue
                    // if the number of devices in the queue is greater than the number of devices in the group, then do not estimate times for those customers
                    if ($result2 = $mysqli->query("
                        SELECT Q_id
                        FROM wait_queue WQ JOIN device_group DG ON WQ.devgr_id = DG.dg_id
                        WHERE valid = 'Y' AND WQ.Devgr_id = $device_group
                        ORDER BY Q_id;
                    ")) {
                        
                        // For each device waiting in this device group
                        $count = 0;
                        while ($row2 = $result2->fetch_assoc())
                        {
                            // If their wait number is smaller than the number of devices in this device group then give them an estimated time
                            if ($count < count($estTimes)) {
                                $rhours = floor($estTimes[$count] / 3600);
                                $rmins = floor($estTimes[$count] / 60 % 60);
                                $rsecs = floor($estTimes[$count] % 60);
                                $timeFormat = sprintf('%02d:%02d:%02d', $rhours, $rmins, $rsecs);
                                
                                //echo ($timeFormat."<br/>");

                                if ($result3 = $mysqli->query("
                                    UPDATE wait_queue
                                    SET estTime = '$timeFormat'
                                    WHERE Q_id = ".$row2['Q_id']."
                                "));
                            }

                            // If their wait number is greater than the number of devices in this device group then do not estimate their time
                            else {
                                if ($result3 = $mysqli->query("
                                    UPDATE wait_queue
                                    SET estTime = NULL
                                    WHERE Q_id = ".$row2['Q_id']."
                                "));
                            }

                            $count++;
                        }
                    }
                }
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
        if(!empty($phone)) {
            if ($result = $mysqli->query("
                SELECT email
                FROM carrier
            ")){
                while ( $row = $result->fetch_assoc() ){
                    list($a, $b) = explode('number', $row['email']);
                    mail("".$phone."".$b."", $subject, $message, $headers);
                }
            } else {
                echo("Carrier query failed!");
            }
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
        $this->q_id = $q_id;
    }

    public function setValid($valid) {
        $this->valid = $valid;
    }

    public function setStartTime($start_time) {
        $this->start_time = $start_time;
    }

    public function setEndTime($end_time) {
        $this->end_time = $end_time;
    }

    public function setDevId($d_id) {
        $this->device = $d_id;
    }

    public function setDevgrId($dg_id) {
        $this->device_group = $dg_id;
    }

    public function setOperator($op) {
        $this->operator = $op;
    }

    public function getOperator() {
        return $this->operator;
    }

    public function getQ_ID() {
        return $this->q_id;
    }

}
?>
