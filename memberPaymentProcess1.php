<?php
include "connection.php";
session_start();
$cid = $_POST['id'];
$cPin = $_POST['pin'];
$cAmount = $_POST['amount'];
$DAT = $_POST['DAT'];

if (empty($cPin) || empty($cid) || empty($cAmount) || empty($DAT)) {
    die("Error.");
} elseif (!ctype_digit($cid) || !ctype_digit($cPin) || !ctype_digit($cAmount)) {
    die("Error...!");
} elseif (!isset($_SESSION["user"])) {
    die("Error in progress...!");
} else {
    $worker_id = $_SESSION["user"]["w_id"];
    $id = htmlspecialchars($cid, ENT_QUOTES, 'UTF-8');
    $pin = htmlspecialchars($cPin, ENT_QUOTES, 'UTF-8');
    $amount = htmlspecialchars($cAmount, ENT_QUOTES, 'UTF-8');
    $worker_id1 = htmlspecialchars($worker_id, ENT_QUOTES, 'UTF-8');

    $q1 = "SELECT * FROM `members` WHERE `id` =? ";
    $types1 = "i";
    $rs1 = Database::searchPrepared($q1, $types1, $id);
    $rs1_num = $rs1->num_rows;

    if ($rs1_num === 1) {
        $rs1_data = $rs1->fetch_assoc();

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $quaryPayment_rs = "INSERT INTO `memberpaymenthistory` (`amount`,`DAT`,`members_id`,`paidDate`,`worker_w_id`) VALUES (?,?,?,?,?)";
        $quaryPayment_rs_types = "dsisi";

        $newDate = date('Y-m-d', strtotime($DAT));

        Database::iudPrepared($quaryPayment_rs, $quaryPayment_rs_types, $amount, $newDate, $id, $date, $worker_id1);
        Database::iudPrepared("UPDATE `members` SET `status_id`=? WHERE `id` = ?", "ii", 1, $id);

        echo ("success");

        // $q = "SELECT * FROM `memberpaymenthistory` WHERE `members_id` = ? ORDER BY `DAT` DESC;";
        // $types = "i";

        // $rs = Database::searchPrepared($q, $types, $id);
        // $rs_num = $rs->num_rows;

        // for ($i = 0; $i < $rs_num; $i++) {
        //     $rs_data = $rs->fetch_assoc();
        //     if ($i === 0) {
        //         $DAT = $rs_data['DAT'];
        //     }
        // }

        // $quaryPayment_rs = "INSERT INTO `memberpaymenthistory` (`amount`,`DAT`,`members_id`,`paidDate`,`worker_w_id`) VALUES (?,?,?,?,?)";
        // $quaryPayment_rs_types = "dsisi";

        // $newDate = date('Y-m-d', strtotime($DAT . ' +1 month'));


        // Database::iudPrepared($quaryPayment_rs, $quaryPayment_rs_types, $amount, $newDate, $id, $date, $worker_id1);
        // echo ("success");
    } else {
        die("Error..!");
    }
}
