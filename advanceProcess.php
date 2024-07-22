<?php
include "connection.php";
include "SMTP.php";
include "Exception.php";
include "PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;

if (!isset($_POST['amo']) || !isset($_POST['sal']) || !isset($_POST['nic']) || empty($_POST['nic'])) {
    die("Error in progress.");
} elseif (empty($_POST['amo'])) {
    die("Please enter needed advance amount.");
} elseif (!ctype_digit($_POST['amo'])) {
    die("Invalid Cash Amount.");
} elseif (!ctype_digit($_POST['sal'])) {
    die("Error in progress.");
} else {
    $nic = htmlspecialchars($_POST['nic'], ENT_QUOTES, 'UTF-8');
    $amo = htmlspecialchars($_POST['amo'], ENT_QUOTES, 'UTF-8');
    $sal = htmlspecialchars($_POST['sal'], ENT_QUOTES, 'UTF-8');
    $cost = 0;
    $eligibleAdvance = 0;

    $q = "SELECT * FROM `transactiondetails` WHERE `desc` LIKE ? AND `DAT` LIKE ? ORDER BY `DAT` DESC; ";
    $q_type = "ss";

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m");


    $rs_q = Database::searchPrepared($q, $q_type, "%" . $nic . "%", $date . "%");
    $rs_q_num = $rs_q->num_rows;

    for ($y = 0; $y < $rs_q_num; $y++) {
        $rs_q_data = $rs_q->fetch_assoc();

        $cost = $cost + $rs_q_data['cost'];
    }

    $eligibleAdvance = $sal - $cost;
    if ($eligibleAdvance >= $amo) {

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hettiarachchih549@gmail.com';
        $mail->Password = 'hvfxbohuoshzcfum';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('hettiarachchih549@gmail.com', 'Salary Advance Request');
        $mail->addReplyTo('hettiarachchih549@gmail.com', 'Salary Advance Request');
        $mail->addAddress('hansarasasanka@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Country Fitness Gymnasium Salary Advance Request';
        $bodyContent = '
        <!DOCTYPE html>
<html>
<head>
  <style>
    /* Add your inline CSS styles here */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }
    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #333333;
      font-size: 24px;
      margin-bottom: 10px;
    }
    p {
      color: #666666;
      font-size: 16px;
      margin-bottom: 20px;
    }
    a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Salary Advance Request</h1>
    <p>' . $nic . ' is requesting for salary advance.</p>
    <a >Rs.' . $amo . '.00 </a>
  </div>
</body>
</html>
        ';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification code sending failed.';
        } else {
            echo 'success';
        }
    } else {
        die("Your only eligible to request Rs." . $eligibleAdvance . ". Pleace try again.");
    }
}
