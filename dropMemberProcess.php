<?php
include "connection.php";

if (!isset($_POST['id']) || empty($_POST['id']) || !ctype_digit($_POST['id'])) {
    die ("Error..Operation Unsuccessfull");
} else {
    $q = "SELECT * FROM `members` WHERE `id` =?;";
    $types = "i";
    $rs = Database::searchPrepared($q, $types, $_POST['id']);
    
    $rs_num = $rs->num_rows;
    if ($rs_num == 1) {
    Database::iudPrepared("DELETE FROM `members` WHERE `id`=?;",'i',$_POST['id']);
    echo ("success");
    }
}



?>