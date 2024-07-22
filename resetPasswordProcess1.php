<?php
include "connection.php";

if (!isset($_POST["c"])) {
    die("Error.Please try again later.");
} elseif (!isset($_COOKIE['e'])) {
    die("Error.Please try again later.");
} elseif (!isset($_POST["nP"])) {
    die("Error.Please try again later.");
} elseif (!isset($_POST["rNP"])) {
    die("Error.Please try again later.");
} else {
    $uCode = $_POST["c"];
    $newPassword = $_POST["nP"];
    $ReNewPassword = $_POST["rNP"];
    $email = $_COOKIE['e'];

    if (empty($uCode)) {
        echo ("Please Enter Your Verification Code.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Error...!");
    } else if (empty($newPassword)) {
        echo ("Please Enter Your Password.");
    } else if (strlen($newPassword) < 5 || strlen($newPassword) > 50) {
        echo ("Password Must Contain 5 to 20 Characters.");
    } else if (!preg_match("/^[a-zA-Z0-9@$#]+$/", $newPassword)) {
        echo ("Password contains unnecessary Characters.");
    } else if (!preg_match("/^[a-zA-Z0-9@$#]+$/", $ReNewPassword)) {
        echo ("Password contains unnecessary Characters.");
    } else if ($newPassword != $ReNewPassword) {
        echo ("Please Enter Your correctly password.");
    } else {

        $rs = Database::search("SELECT * FROM `worker` WHERE `email`='" . $email . "';");
        $n = $rs->num_rows;
        $rs_data = $rs->fetch_assoc();

        if ($uCode == $rs_data["verification_code"]) {
            if ($n == 1) {

                $q = "UPDATE `worker` SET `password` = ? WHERE `email` = ? ;";
                $q_types = "ss";
                Database::iudPrepared($q, $q_types, $ReNewPassword, $email);
                echo ("success");
            } else {
                echo ("Error....");
            }
        }
    }
}
