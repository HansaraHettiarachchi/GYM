<?php

include "connection.php";

if (!isset($_POST["c"])) {
die ("Error.Please try again later."); 
}elseif (!isset($_COOKIE['e'])) {
    die ("Error.Please try again later.");
}else {
    $uCode = $_POST["c"];
    $email = $_COOKIE['e'];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email Address.");
    }elseif (empty($uCode)) {
        echo ("Please enter your verification code.");
    } else {
        $user_rs = Database::search("SELECT * FROM `worker` WHERE `email`='" . $email . "';");
        $user_data = $user_rs->fetch_assoc();
    
        if ($uCode == $user_data['verification_code']) {
            echo ("success");
        } else {
            echo ("Invalid Verification Code...!");
        }
    }
    
}


?>