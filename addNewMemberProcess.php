<?php
include "connection.php";
$gender = 1;
$coachingAdvice = 1;

if (!isset($_POST['gender'])) {
    echo ("Please select your Gender.");
} elseif ($_POST['termsAndConditions'] != "true") {
    echo ("Please agree to trems and conditions.");
} else {
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $email = $_POST['email'];
    $mobileNum = $_POST['mobileNum'];
    $dob = $_POST['dob'];
    $mShipSelection = $_POST['mShipSelection'];
    $address = $_POST['address'];
    $occupationInput = $_POST['occupationInput'];
    $gen = $_POST['gender'];
    $cA = $_POST['coachingAdvice'];
    $termsAndConditions = $_POST['termsAndConditions'];

    $dobPattern = "/^\d{4}-\d{2}-\d{2}$/";

    if (
        empty($name) || empty($mobileNum) || empty($dob) || empty($mShipSelection) ||
        empty($address) || empty($occupationInput) || empty($gender) || empty($coachingAdvice) || empty($termsAndConditions)
    ) {
        echo ("Please fill all the fields and agree to the terms and conditions.");
    } elseif (strlen($name) > 100 || strlen($nic) > 12 || strlen($email) > 100 || strlen($mobileNum) > 10 || strlen($mShipSelection) > 120 || strlen($address) > 100 || strlen($occupationInput) > 50) {
        echo ("Some input field charactor lenth exceeded.");
    } elseif (!preg_match("/^[a-zA-Z]+( [a-zA-Z]+)*$/", $name)) {
        echo ("Invalid Name");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {
        echo ("Invalid email address..!");
    } elseif (!preg_match("/^07\d{8}$/", $mobileNum)) {
        echo ("Invalid Mobile Number");
    } elseif (!preg_match("/^[a-zA-Z0-9',.() ]+$/", $address)) {
        echo ("Invalid Address.");
    } elseif (!preg_match("/^[0-9\\n]+$/", $mShipSelection)) {
        echo ($mShipSelection);
        echo ("Please Select a Membership.");
    } elseif (!preg_match("/^[a-zA-Z() ]*$/", $occupationInput)) {
        echo ("Invalid occupation");
    } elseif (!preg_match($dobPattern, $dob)) {
        echo ('Invalid date format. Please use the international format YYYY-MM-DD.');
    } else {
        $name1 = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $nic1 = htmlspecialchars($nic, ENT_QUOTES, 'UTF-8');
        $email1 = filter_var($email, FILTER_SANITIZE_EMAIL);
        $mobileNum1 = htmlspecialchars($mobileNum, ENT_QUOTES, 'UTF-8');
        $dob1 = htmlspecialchars($dob, ENT_QUOTES, 'UTF-8');
        $mShipSelection1 = htmlspecialchars($mShipSelection, ENT_QUOTES, 'UTF-8');
        $address1 = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $occupationInput1 = htmlspecialchars($occupationInput, ENT_QUOTES, 'UTF-8');
        $gen1 = htmlspecialchars($gen, ENT_QUOTES, 'UTF-8');
        $cA1 = htmlspecialchars($cA, ENT_QUOTES, 'UTF-8');
        $termsAndConditions1 = htmlspecialchars($termsAndConditions, ENT_QUOTES, 'UTF-8');
        $profileImg_p_id = 1;
        if ($gen == "female") {
            $gender = 2;
        }
        if ($cA == "no") {
            $coachingAdvice = 2;
        }

        $q = "SELECT * FROM `members` WHERE `m_name` =? OR `m_number` =?";
        $types = "ss";
        $rs = Database::searchPrepared($q, $types, $name1, $mobileNum1);

        $q1 = "SELECT * FROM `membership` WHERE `mS_id` =? ";
        $types1 = "i";
        $rs1 = Database::searchPrepared($q1, $types1, $mShipSelection1);

        $rs_num = $rs->num_rows;
        $rs_num1 = $rs1->num_rows;

        if (($rs_num == 0 ) && ($rs_num1 == 1)) {
            $rs1_data = $rs1->fetch_assoc();

            $quary = "INSERT INTO `gym`.`members` ( `m_name`, `nic`, `email`, `m_number`, `dob`, `membership_m_id`, `address`, `occupation`,`joined_date` , `gender_id`, `coachingAdvice_id`,`profileImg_p_id`,`status_id`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $type = "sssssssssiiii";

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");
            $date1 = $d->format("Y-m-d");

            Database::iudPrepared($quary, $type, $name1, $nic1, $email1, $mobileNum1, $dob1, $mShipSelection1, $address1, $occupationInput1, $date, $gender, $coachingAdvice, $profileImg_p_id ,1);
            $insert_id = Database::$connection->insert_id;

            $quaryPayment_rs = "INSERT INTO `memberpaymenthistory` (`amount`,`DAT`,`members_id`,`paidDate`,`worker_w_id`) VALUES (?,?,?,?,?)";
            $quaryPayment_rs_types = "dsisi";
            
            Database::iudPrepared($quaryPayment_rs , $quaryPayment_rs_types , $rs1_data['price'], $date1  , $insert_id ,$date ,1);
            echo ("success");
        } else {
            for ($i = 0; $i < $rs_num; $i++) {
                $rs_data = $rs->fetch_assoc();
            }
            echo "The person who registered now is already registered...! The id is : '" . $rs_data['id'] . "'. ";
        }
    }
}
?>