<?php
class Notifications {
    private $operator;
    private $phone_num;
    private $email;
    private $last_contacted;

    public static function sendNotification($operator, $subject, $message, $headers) {
        global $mysqli;
        $hasbeenContacted = false;
        // This function queries the carrier table and sends an email to all combinations

            //Query the phone number and email
        if ($result = $mysqli->query("
            SELECT `Op_phone` AS `Phone`, `Op_email` AS `Email`
            FROM `operator_info`
            WHERE `Op_id` = $operator
        ")) 
        {
            $row = $result->fetch_assoc();
            $phone = $row['Phone'];
            $email = $row['Email'];

            if (!empty($phone)) {
                if ($result = $mysqli->query("
                    SELECT email
                    FROM carrier
                ")) {
                    while ($row = $result->fetch_assoc()) {
                        list($a, $b) = explode('number', $row['email']);
                        mail("".$phone."".$b."", $subject, $message, $headers);
                    }
                    $hasbeenContacted = true;
                } else {
                    echo("Carrier query failed!");
                }
            }
            
            if (!empty($email)) {
                mail("".$email."", $subject, $message, $headers);
                $hasbeenContacted = true;
            }
    
            if ($hasbeenContacted == true) {
                // Update the database to display that the student has been contacted
                if ($result = $mysqli->query("
                    UPDATE `operator_info`
                    SET `last_contact` = CURRENT_TIMESTAMP
                    WHERE `Op_id` = $operator
                ")) {
                }
            }
        }
    }
}
?>
