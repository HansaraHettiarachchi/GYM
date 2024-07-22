<?php
include "connection.php";
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$mobileNum = $_POST['mobileNum'];
$nic = $_POST['nic'];
$ps = $_POST['ps'];
$gender = $_POST['gender'];
$ATaC = $_POST['ATaC'];

if (empty($fname)) {
    echo ("Please Enter Your First Name..!");
} elseif (strlen($fname) > 50) {
    echo ("First Name Must Contain LOWER THAN 50 characters...!");
} elseif (!preg_match("/^[a-zA-Z]+( [a-zA-Z]+)*$/", $fname)) {
    echo ("First Name Contains unnecessary characters...!");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name.");
} else if (strlen($lname) > 50) {
    echo ("Last Name Must Contain LOWER THAN 50 characters.");
} else if (!preg_match("/^[a-zA-Z]+( [a-zA-Z]+)*$/", $lname)) {
    echo ("Last Name Contains unnecessary characters...!");
} else if (empty($email)) {
    echo ("Please Enter Your Email Address.");
} else if (empty($mobileNum)) {
    echo ("Please Enter Your Mobile Number.");
} elseif (!preg_match("/^07\d{8}$/", $mobileNum)) {
    echo ("Invalid Mobile Number");
} elseif (empty($nic)) {
    echo ("Please enter NIC Number...!");
} elseif (!preg_match("/^(?:\d{9}vV|\d{12})$/", $nic)) {
    echo ("Invalid NIC Number");
} else if (strlen($email) > 100) {
    echo ("Email Address Must Contain LOWER THAN 100 characters.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address.");
} else if (empty($ps)) {
    echo ("Please Enter Your Password.");
} else if (strlen($ps) < 5 || strlen($ps) > 20) {
    echo ("Password Must Contain 5 to 20 Characters.");
} else if (!preg_match("/^[a-zA-Z0-9@$#]+$/", $ps)) {
    echo ("Password Contains unnecessary characters...!");
} else if (empty($gender)) {
    echo ("Password Select Gender...!");
} else if (!preg_match("/^[d{1}]+$/", $gender) || $gender == 0) {
    echo ("Error...!");
} else {
    if ($ATaC == "true") {
        
        $fname1 = htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');
        $lname1 = htmlspecialchars($lname, ENT_QUOTES, 'UTF-8');
        $email1 = filter_var($email, FILTER_SANITIZE_EMAIL);
        $ps1 = htmlspecialchars($ps, ENT_QUOTES, 'UTF-8');
        $nic1 = htmlspecialchars($nic, ENT_QUOTES, 'UTF-8');
        $mobileNum1 = htmlspecialchars($mobileNum, ENT_QUOTES, 'UTF-8');
        $gender1 = htmlspecialchars($gender, ENT_QUOTES, 'UTF-8');
        $ATaC1 = htmlspecialchars($ATaC, ENT_QUOTES, 'UTF-8');

        $select_q = "SELECT * FROM `worker` WHERE `nic` = ? OR `email` = ? ;";
        $select_q_type = "ss";

        $select_q_rs = Database::searchPrepared($select_q, $select_q_type, $nic1, $email1);
        $select_q_rs_num = $select_q_rs->num_rows;

        if ($select_q_rs_num == 0) {

            $insert_q = "INSERT INTO `worker` (`fname`,`lname`,`nic`,`email` , `password`,`m_number`,`pin`,`joined_date`,`status_id`,`gender_g_id`,`worker_type_w_t_id`,`worker_prof_img_w_p_img_id`,`salary`) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $insert_q_type = "ssssssisiiiid";

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            $pin = mt_rand(100000, 999999);

            Database::iudPrepared($insert_q, $insert_q_type, $fname1, $lname1, $nic1, $email1, $ps1, $mobileNum1, $pin, $date, 2, $gender1, 2, 1,25000);

            echo ("success");
        } else {
            die("Already registered user with this email and nic.");
        }
    } else {
        die("Please agree to terms conditions...!");
    }
}
