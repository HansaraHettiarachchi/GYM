<?php
include "connection.php";
session_start();

try {
    $len = json_decode($_POST['len']);
    $desc = json_decode($_POST['jdesc']);
    $cost = json_decode($_POST['jcost']);
    $type = json_decode($_POST['jtype']);
} catch (\Throwable $th) {
    die("Error");
}

if (empty($len) || empty($desc) || empty($cost) || empty($type)) {
    die("Please fill requred details before update.");
} elseif (!isset($_SESSION['user'])) {
    die("Please Login before anything...!");
} elseif (!is_numeric($len)) {
    die("Invaild Details...!");
} else {
    if (sizeof($desc) == $len && sizeof($cost) == $len && sizeof($type) == $len) {
        foreach ($desc as $i => $descData) {

            if (preg_match("/^[a-zA-Z0-9,.() ]+$/", $descData) || preg_match("/^[0-9]+$/", $cost[$i]) || preg_match("/^[0-9]+$/", $type[$i])) {
                $costData = htmlspecialchars($cost[$i], ENT_QUOTES, 'UTF-8');
                $typeData = htmlspecialchars($type[$i], ENT_QUOTES, 'UTF-8');
                $descData1 = htmlspecialchars($descData, ENT_QUOTES, 'UTF-8');

                $query = "INSERT INTO `transactiondetails` (`desc`,`cost`,`DAT`,`paymentType_pay_type_id`,`worker_w_id`) VALUES (?,?,?,?,?) ";
                $query_types = "sdsii";

                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format('Y-m-d H:i');

                Database::iudPrepared($query, $query_types, $descData1, $costData, $date, $typeData, $_SESSION['user']['w_id']);
            } else {
                die("An error conducted during the precess...!");
            }
        }
        echo "success";
    }
}
