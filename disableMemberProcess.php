<?php
include "connection.php";

if (!isset($_POST['id']) || empty($_POST['id']) || !ctype_digit($_POST['id'])) {
    die("Error..Operation Unsuccessfull");
} else {
    $q = "SELECT * FROM `members` WHERE `id` =?;";
    $types = "i";
    $rs = Database::searchPrepared($q, $types, $_POST['id']);

    $rs_num = $rs->num_rows;
    if ($rs_num == 1) {
        $rs_data = $rs->fetch_assoc();

        if ($rs_data['status_id'] === 1) {
            $q = "UPDATE `members` SET `status_id`=? WHERE `id`=?;";
            Database::iudPrepared($q,'ii', 2,$_POST['id']);
            echo ("Member Disabled.");
        } else {
            $q = "UPDATE `members` SET `status_id`=? WHERE `id`=?;";
            Database::iudPrepared($q,'ii', 1,$_POST['id']);
            echo ("Member Enabled.");
        }

    }
}
?>
