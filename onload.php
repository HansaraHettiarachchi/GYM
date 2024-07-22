<?php
session_start();
$tot = 0;

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d");



$date1 = $d->format("d");

if ($date1 == "1") {
    $check_q = "SELECT * FROM `transactiondetails` WHERE `desc` LIKE ? AND `DAT`= ? ;";
    $check_q_type = "ss";
    $check_q_rs = Database::searchPrepared($check_q, $check_q_type, "Last Month%", $date);
    $check_q_rs_num = $check_q_rs->num_rows;

    if ($check_q_rs_num == 0) {
        $d->modify('-1 month');
        $month = $d->format("Y-m")."%" ;
    
        $query = "SELECT * FROM `transactiondetails` WHERE `DAT` LIKE ? ;";
        $type = "s";
    
        $query1 = "SELECT * FROM `memberpaymenthistory` WHERE  `DAT` LIKE ? ;";
        $type1 = "s";
    
        $rs1 = Database::searchPrepared($query1, $type1, $month);
        $rs = Database::searchPrepared($query, $type, $month);
        $rs_num1 = $rs1->num_rows;
        $rs_num = $rs->num_rows;
    
        for ($i = 0; $i < $rs_num; $i++) {
            $rs_data = $rs->fetch_assoc();
    
            if ($rs_data["paymentType_pay_type_id"] == 2) {
                $tot = $tot + $rs_data['cost'];
            } else {
                $tot = $tot - $rs_data['cost'];
            }
        }
        for ($i = 0; $i < $rs_num1; $i++) {
            $rs_data1 = $rs1->fetch_assoc();
            $tot = $tot + $rs_data1['Amount'];
        }
        $query2 = "INSERT INTO `transactiondetails` (`desc`,`cost`,`DAT`,`paymentType_pay_type_id`,`worker_w_id`) VALUES (?,?,?,?,?) ";
        $query_types = "sdsii";
    
        if ($tot >= 0) {
            $p = "Last Month Profit";
            $typeData = 2;
        } else {
            $typeData = 1;
            $p = "Last Month Loss";
        }
    
        Database::iudPrepared($query2, $query_types, $p, $tot, $date, $typeData, 1);
        
    }
} 
