<?php
include "connection.php";
session_start();

$emailOrNIC =  $_POST['email'];
$ps = $_POST['ps'];
$remember = $_POST['ATaC'];


if (empty($emailOrNIC)) {
    echo ("Please Enter Your Email Address Or NIC.");
} else if (strlen($emailOrNIC) > 100) {
    echo ("Email Address Must Contain LOWER THAN 100 characters.");
} else if (!preg_match("/^(?:\d{9}(?:[vV]|\d{3})|[\w.-]+@[A-Za-z\d.-]+\.\w{2,})$/", $emailOrNIC)) {
    echo ("Invalid Email Address or NIC.");
} else if (empty($ps)) {
    echo ("Please Enter Your Password.");
} else if (strlen($ps) < 5 || strlen($ps) > 20) {
    echo ("Password Must Contain 5 to 20 Characters.");
} else if (!preg_match("/^[a-zA-Z0-9!@#$%]+$/", $ps)) {
    echo ("Password Contains unnecessary characters...!");
} else {

    $emailOrNIC1 = filter_var($emailOrNIC, FILTER_SANITIZE_EMAIL);
    $ps1 = htmlspecialchars($ps, ENT_QUOTES, 'UTF-8');
    $remember1 = htmlspecialchars($remember, ENT_QUOTES, 'UTF-8');

    if (filter_var($emailOrNIC1, FILTER_VALIDATE_EMAIL)) {
        $select_q = "SELECT * FROM `worker` INNER JOIN `worker_prof_img` ON `worker_prof_img`.`w_p_img_id` = `worker`.`worker_prof_img_w_p_img_id` WHERE `email` = ?  AND `password` = ? ;";
        $select_q_type = "ss";

        $select_q_rs = Database::searchPrepared($select_q, $select_q_type, $emailOrNIC1, $ps1);
    } else {
        $select_q = "SELECT * FROM `worker` INNER JOIN `worker_prof_img` ON `worker_prof_img`.`w_p_img_id` = `worker`.`worker_prof_img_w_p_img_id` WHERE `nic` = ?  AND `password` = ? ;";
        $select_q_type = "ss";

        $select_q_rs = Database::searchPrepared($select_q, $select_q_type, $emailOrNIC1, $ps1);
    }



    $select_q_rs_num = $select_q_rs->num_rows;

    if ($select_q_rs_num == 1) {
        $rs_data = $select_q_rs->fetch_assoc();
        $_SESSION['user'] = $rs_data;

        if ($remember1 == "true") {
            setcookie("eOrNic",$emailOrNIC1, time() + (60*60*24*365));
            setcookie("ps",$ps1 ,time() + (60*60*24*365));

        } else {
            setcookie("eOrNic","", -1);
            setcookie("ps","" ,-1);
        }
        
        echo ("success");
    }else {
        die ("There is no any recode belongs to this Details...!");
    }
}

