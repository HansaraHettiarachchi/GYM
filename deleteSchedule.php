<?php
include "connection.php";

if (!isset($_POST['sid'])) {
    die("Error..Operation Unsuccessfull");
} else {
    $q = "SELECT * FROM `schedule` WHERE `s_id` =?;";
    $types = "i";
    $rs = Database::searchPrepared($q, $types, $_POST['sid']);

    $rs_num = $rs->num_rows;
    if ($rs_num == 1) {
        Database::iudPrepared("DELETE FROM `workouts` WHERE `schedule_s_id`=?;", 'i', $_POST['sid']);
        Database::iudPrepared("DELETE FROM `schedule` WHERE `s_id`=?;", 'i', $_POST['sid']);
        echo ("success");
    }
}
