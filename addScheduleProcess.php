<?php
include "connection.php";

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d");

if (!isset($_POST["workouts"]) || !isset($_POST["details"]) || !isset($_POST["id"]) || !isset($_POST["sN"]) || !isset($_POST["rD"])) {
    die("Error");
} elseif (strlen($_POST["sN"]) == 0) {
    die("Please add a Name for Schedule.");
} elseif (strlen($_POST["sN"]) > 20) {
    die("Schedule Name exceding charactor limit.");
} elseif (strlen($_POST["workouts"]) > 480) {
    die("Workout column exceding charactor limit.");
} elseif (strlen($_POST["details"]) > 480) {
    die("Detalis column exceding charactor limit.");
} elseif (strlen($_POST["rD"]) == 0) {
    die("Please add the Renewal date.");
} elseif (!preg_match("/^[a-zA-Z0-9() :]+$/", ($_POST["sN"]))) {
    die("Unexpected charactorers with schedule name.");
} elseif (strtotime($_POST["rD"]) === false) {
    die("Incorrect Date...!");
} elseif ($_POST["rD"] < $date) {
    die("The renewal date should be after today.");
} else {
    $jWorkouts = $_POST["workouts"];
    $jDetails = $_POST["details"];
    $cId = $_POST["id"];
    $cSN = $_POST["sN"];
    $rD = $_POST["rD"];


    $workouts = json_decode($jWorkouts);
    $details = json_decode($jDetails);

    foreach ($workouts as $i => $cWorkout) {
        $cDetail = $details[$i];
        if (!preg_match("/^[A-Za-z0-9 (),.:\/-]+$/", $cWorkout)) {
            die("Workout column contains unnecessary characters.");
        } elseif (!empty($cDetail) && !preg_match("/^[A-Za-z0-9 ():,.-]+$/", $cDetail)) {
            die("Details column contains unnecessary characters.");
        } elseif (strlen($cWorkout) > 30) {
            die("Workout column exceding charactor limit.");
        } elseif (strlen($cDetail) > 30) {
            die("Detalis column exceding charactor limit.");
        } elseif (!preg_match("/^[0-9]+$/", $cId)) {
            die("Error: You're trying to change something that you don't need.");
        } else {
            $workout = htmlspecialchars($cWorkout, ENT_QUOTES, 'UTF-8');
            $detail = htmlspecialchars($cDetail, ENT_QUOTES, 'UTF-8');
            $id = htmlspecialchars($cId, ENT_QUOTES, 'UTF-8');

            if ($i == 0) {
                $sN = htmlspecialchars($cSN, ENT_QUOTES, 'UTF-8');

                $query = "INSERT INTO `schedule` (`sName`,`members_id`,`dateOfRenewal`,`addedDate`) VALUES (?,?,?,?);";
                $types = "siss";

                Database::iudPrepared($query, $types, $sN, $id, $rD, $date);
                $insert_id = Database::$connection->insert_id;
            }

            $query = "INSERT INTO `workouts` (`schedule_s_id`,`workout`,`details`) VALUES (?, ?, ?);";
            $types = "iss";

            Database::iudPrepared($query, $types, $insert_id, $workout, $detail);

            if ($i == 0) {
                echo ($id);
            }
        }
    }
}
