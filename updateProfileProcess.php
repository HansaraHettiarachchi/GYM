<?php
include "connection.php";

$mId = $_POST['mId'];
$name = $_POST['name'];
$nic = $_POST['nic'];
$email = $_POST['email'];
$mobileNum = $_POST['mobileNum'];
$dob = $_POST['dob'];
$mShipSelection = $_POST['mShipSelection'];
$address = $_POST['address'];
$occupationInput = $_POST['occupationInput'];
$pGoal = $_POST['pGoal'];
$pCAOR = $_POST['pCAOR'];
$jMeasurments = $_POST['jMeasurments'];
$measurments = json_decode($jMeasurments);
$measurmentArray[] = array();

$dobPattern = "/^\d{4}-\d{2}-\d{2}$/";
if (
    empty($name) || empty($mobileNum) || empty($dob) || empty($mShipSelection) ||
    empty($address) || empty($occupationInput) || empty($occupationInput)
) {
    die ("Please fill all the fields.");
} elseif (strlen($name) > 100 || strlen($nic) > 12 || strlen($email) > 100 || strlen($mobileNum) > 10 || strlen($address) > 100 || strlen($occupationInput) > 50) {
    die ("Some input field charactor lenth exceeded.");
} elseif (!preg_match("/^[a-zA-Z]+( [a-zA-Z]+)*$/", $name)) {
    die ("Invalid Name");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {
    die ("Invalid email address..!");
} elseif (!preg_match("/^07\d{8}$/", $mobileNum)) {
    die ("Invalid Mobile Number");
} elseif (!preg_match("/^[a-zA-Z0-9,.() ]+$/", $address)) {
    die ("Invalid Address.");
} elseif (!preg_match("/^[0-9\\n]+$/", $mShipSelection)) {
    die ($mShipSelection);
    die ("Please Select a Membership.");
} elseif (!preg_match("/^[a-zA-Z() ]*$/", $occupationInput)) {
    die ("Invalid occupation");
} elseif (!preg_match($dobPattern, $dob)) {
    die ('Invalid date format. Please use the international format YYYY-MM-DD.');
} elseif (!preg_match("/^[a-zA-Z0-9,.() ]+$/", $pCAOR) && !empty($pCAOR)) {
    die ("Invalid Address.");
}else {
    $mId1 = htmlspecialchars($mId, ENT_QUOTES, 'UTF-8');
    $name1 = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $nic1 = htmlspecialchars($nic, ENT_QUOTES, 'UTF-8');
    $email1 = filter_var($email, FILTER_SANITIZE_EMAIL);
    $mobileNum1 = htmlspecialchars($mobileNum, ENT_QUOTES, 'UTF-8');
    $dob1 = htmlspecialchars($dob, ENT_QUOTES, 'UTF-8');
    $mShipSelection1 = htmlspecialchars($mShipSelection, ENT_QUOTES, 'UTF-8');
    $address1 = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
    $occupationInput1 = htmlspecialchars($occupationInput, ENT_QUOTES, 'UTF-8');
    $pGoal1 = htmlspecialchars($pGoal, ENT_QUOTES, 'UTF-8');
    $pCAOR1 = htmlspecialchars($pCAOR, ENT_QUOTES, 'UTF-8');

    foreach ($measurments as $i => $measurment_Data) {
        if (!empty($measurment_Data)) {
            $measurmentArray[$i] = htmlspecialchars($measurment_Data, ENT_QUOTES, 'UTF-8');
        }
    }
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d");

    $measurmentArray1 = array_merge([$date], $measurmentArray, [$mId1]);

    if (count($measurmentArray) == 20) {
        $in_q = "INSERT INTO `measurment` 
           ( `added_date`,`neck`, `chest`, `waist`, `l_upper`, `r_upper`, `l_fore`, `r_fore`, `hips`,`l_wrist`, `r_wrist`, `l_thigh`,
            `r_thigh`, `l_knee`, `r_knee`, `l_calf`, `r_calf`, `l_ankle`, `r_ankle`, `height`, `weight`,`members_id`) 
           VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        $in_types = "sddddddddddddddddddddi";

        Database::iudPreparedArray($in_q, $in_types, $measurmentArray1);
    }

    $q = "SELECT * FROM `members` WHERE `id` =?;";
    $types = "i";
    $rs = Database::searchPrepared($q, $types, $mId1);

    $rs_num = $rs->num_rows;

    if ($rs_num == 1) {
        $rs_data = $rs->fetch_assoc();
        $length = sizeof($_FILES);

        if ($length == 1) {

            $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

            if (isset($_FILES["pImg"])) {

                $image_file = $_FILES["pImg"];
                $file_extension = $image_file["type"];

                if (in_array($file_extension, $allowed_image_extensions)) {

                    $new_img_extension;

                    if ($file_extension == "image/jpg") {
                        $new_img_extension = ".jpg";
                    } else if ($file_extension == "image/png") {
                        $new_img_extension = ".png";
                    } else if ($file_extension == "image/jpeg") {
                        $new_img_extension = ".jpeg";
                    } else if ($file_extension == "image/svg+xml") {
                        $new_img_extension = ".svg";
                    }

                    $file_name = "plugins//images//profileImgs//" . $rs_data['m_name'] . "_" . uniqid() . $new_img_extension;
                    move_uploaded_file($image_file["tmp_name"], $file_name);

                    if ($rs_data['profileImg_p_id'] == 1) {
                        $img_query = "INSERT INTO `profileimg`(`profileImgLocation`) VALUES (?)";
                        $img_query_types = "s";

                        Database::iudPrepared($img_query, $img_query_types, $file_name);
                        $pImgId = Database::$connection->insert_id;

                        $memberPupdate_q = "UPDATE `members` SET `profileImg_p_id` = ?  WHERE `id` = ? ;";
                        $memberPupdate_types = "ii";

                        Database::iudPrepared($memberPupdate_q, $memberPupdate_types, $pImgId, $rs_data['id']);
                    }

                    if ($rs_data['profileImg_p_id'] > 1) {
                        $img_rs = Database::search("SELECT * FROM `profileimg` WHERE `p_id` = '" . $rs_data['profileImg_p_id'] . "';");
                        $img_num = $img_rs->num_rows;

                        if ($img_num == 1) {
                            $img_data = $img_rs->fetch_assoc();

                            if (file_exists($img_data['profileImgLocation'])) {
                                if (unlink($img_data['profileImgLocation'])) {

                                    $imgUpdate_q = "UPDATE `profileimg` SET `profileImgLocation` = ? WHERE `p_id` = ?;";
                                    $imgUpdate_q_type = "si";

                                    Database::iudPrepared($imgUpdate_q, $imgUpdate_q_type, $file_name, $img_data['p_id']);
                                } else {
                                    die ("Error deleting the file.");
                                }
                            } else {
                                die ("File does not exist.");
                            }
                        } else {
                            die ("Error");
                        }
                    }
                } else {
                    die ("Inavid image type.");
                }
            }
        }

        $quary = "UPDATE `members` SET `m_name`=? , `nic` = ? , `email` = ? , `m_number` = ? , `dob` = ? ,
        `address` = ? , `occupation` = ? , `pGoal` = ? , `remarks` = ? , `membership_m_id` = ? WHERE `id`=? ;";

        $quary_types = "sssssssssii";

        Database::iudPrepared($quary, $quary_types, $name1, $nic1, $email1, $mobileNum1, $dob1, $address1, $occupationInput1 ,$pGoal1 ,$pCAOR1 , $mShipSelection1,  $mId1);
        echo ("Success");
    } else {
        die ("An Error conducted during the process. Pleace check details again. ");
    }
}
?>