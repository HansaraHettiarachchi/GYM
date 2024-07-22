<?php
include "connection.php";

$cid = $_POST['id'];
$dates = array();
$consecutiveMonths = 0;
$cmonthsArray = array();
$tableContent = array();
$date;
$price = 0;
$priceAllow = 0;

$d12 = new DateTime();
$tz12 = new DateTimeZone("Asia/Colombo");
$d12->setTimezone($tz12);
$date12 = $d12->format("Y-m-d");

if (empty($cid)) {
    die("Please Enter id..!");
} elseif (!ctype_digit($cid)) {
    die("Wrrong Id.");
} else {
    $id = htmlspecialchars($cid, ENT_QUOTES, 'UTF-8');
    $q = "SELECT * FROM `members` INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id WHERE `id` = ?;";

    $types = "i";

    $rs = Database::searchPrepared($q, $types, $id);
    $rs_num = $rs->num_rows;

    if ($rs_num === 1) {
        $rs_data = $rs->fetch_assoc();

        $q_updated = "SELECT * FROM `members` INNER JOIN `membership` ON `members`.membership_m_id = `membership`.mS_id 
                    INNER JOIN `memberpaymenthistory` ON `memberpaymenthistory`.`members_id` = `members`.`id` WHERE `members`.`id` = ?; ";

        $q_rs_types = "i";
        $q_updated_rs = Database::searchPrepared($q_updated, $q_rs_types, $id);

        $q_updated_num = $q_updated_rs->num_rows;

        for ($i = 0; $i < $q_updated_num; $i++) {
            $q_updated_data = $q_updated_rs->fetch_assoc();
            if ($i === 0) {
                $price = $q_updated_data['price'];
            }
            if ($i === $q_updated_num - 1) {
                $date = $q_updated_data['DAT'];
            }
            $dates[] = $q_updated_data['DAT'];
        }
        rsort($dates);

        for ($i = 1; $i < count($dates); $i++) {

            $currentDate = new DateTime($dates[$i]);
            $prevDate = new DateTime($dates[$i - 1]);
            $monthDiff = $currentDate->diff($prevDate)->m;
            $cmonthsArray[$i] = $monthDiff;
        }
        if ($rs_data['mS_id'] === 1 || $rs_data['mS_id'] === 4) {

            if ((array_slice($cmonthsArray, 0, 11) === [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1]) && ($priceAllow === 0)) {
                $price = $price - 500;
                $priceAllow = 500;
            } elseif ((array_slice($cmonthsArray, 0, 5) === [1, 1, 1, 1, 1])  && ($priceAllow === 0)) {
                $price = $price - 300;
                $priceAllow = 300;
            } elseif ((array_slice($cmonthsArray, 0, 2) === [1, 1]) && ($priceAllow === 0)) {
                $price = $price - 150;
                $priceAllow = 150;
            }
        }
        // echo json_encode($cmonthsArray);

        if ($rs_data['mS_id'] === 1 || $rs_data['mS_id'] === 4 || $rs_data['mS_id'] === 10 || $rs_data['mS_id'] === 9) {
            $nPaymentD = date('Y-m-d', strtotime($date . "+1 month"));
        } elseif ($rs_data['mS_id'] === 2 || $rs_data['mS_id'] === 5) {
            $nPaymentD = date('Y-m-d', strtotime($date . "+6 month"));
        } elseif ($rs_data['mS_id'] === 3 || $rs_data['mS_id'] === 6) {
            $nPaymentD = date('Y-m-d', strtotime($date . "+12 month"));
        } elseif ($rs_data['mS_id'] === 7 || $rs_data['mS_id'] === 8) {
            $nPaymentD = date('Y-m-d', strtotime($date . "+4 month"));
        }

        if ($rs_data['status_id'] === 2) {
            $dates1 = json_encode(array(
                'id' => $id,
                'p' => $rs_data['price'],
                'mem_name' => $rs_data['m_name'],
                'mshipName' => $rs_data['mS_name'],
                'mshipPrice' => $rs_data['price'],
                'nPaymentD' => $date12
            ));
        } else {
            $dates1 = json_encode(array(
                'id' => $id,
                'p' => $price,
                'mem_name' => $rs_data['m_name'],
                'mshipName' => $rs_data['mS_name'],
                'mshipPrice' => $rs_data['price'],
                'nPaymentD' => $nPaymentD
            ));
        }

        sleep(1);
        echo $dates1;
    } else {
        die("error");
    }
}
