<?php
include "connection.php";

$wid = $_POST['id'];
$sal = $_POST['sal'];
$email = $_POST['email'];
$mobileNum = $_POST['mNUm'];
$address = $_POST['address'];
if (empty($wid) || empty($sal) || empty($mobileNum) || empty($mobileNum)) {
    die("Please fill all the fields.");
} elseif (strlen($email) > 100 || strlen($mobileNum) > 10 || strlen($address) > 100) {
    die("Some input field charactor lenth exceeded.");
} elseif (!ctype_digit($wid)) {
    die("Error in progress...!");
} elseif (!ctype_digit($sal)) {
    die("Invalid Salary");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {
    die("Invalid email address..!");
} elseif (!preg_match("/^07\d{8}$/", $mobileNum)) {
    die("Invalid Mobile Number");
} elseif (!preg_match("/^[a-zA-Z0-9,.() ]+$/", $address) && !empty($address)) {
    die("Invalid Address.");
} else {
    $wid1 = htmlspecialchars($wid, ENT_QUOTES, 'UTF-8');
    $sal1 = htmlspecialchars($sal, ENT_QUOTES, 'UTF-8');
    $email1 = filter_var($email, FILTER_SANITIZE_EMAIL);
    $mobileNum1 = htmlspecialchars($mobileNum, ENT_QUOTES, 'UTF-8');
    $address1 = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');

    $q = "SELECT * FROM `worker` WHERE `w_id` =? ;";
    $types = "i";
    $rs = Database::searchPrepared($q, $types, $wid1);

    $rs_num = $rs->num_rows;

    if ($rs_num == 1) {
        $rs_data = $rs->fetch_assoc();

        $quary = "UPDATE `worker` SET `m_number` = ? , `email` = ? , `salary` = ? , `address` = ?  WHERE `w_id`=? ;";

        $quary_types = "ssdsi";

        Database::iudPrepared($quary, $quary_types,$mobileNum1,$email1,$sal1,$address1,$wid1);
        echo ("Success");

    } else {
        die("An Error conducted during the process. Pleace check details again. ");
    }
}
