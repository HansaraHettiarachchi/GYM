<?php
include "connection.php";
include "SMTP.php";
include "Exception.php";
include "PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;

$email = $_POST["email"];

if (!isset($email)) {
  echo ("Please Enter Your Email Address.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo ("Invalid Email Address.");
} else {


  $rs = Database::search("SELECT * FROM `worker` WHERE `email` = '" . $email . "';");
  $num_rs = $rs->num_rows;


  if ($num_rs == 1) {

    $code = rand(100000, 999999);
    $q = "UPDATE `worker` SET `verification_code` = ? WHERE `email` = ? ;";
    $q_type = "is";

    Database::iudPrepared($q , $q_type, $code , $email);
    setcookie("e", $email, time() + (60 * 60 * 10));
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hettiarachchih549@gmail.com';
    $mail->Password = 'hvfxbohuoshzcfum';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('hettiarachchih549@gmail.com', 'Country Fitness Gymnasium');
    $mail->addReplyTo('hettiarachchih549@gmail.com', 'Country Fitness Gymnasium');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Forgot password Verification Code';
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
    <h1>Verification Email</h1>
    <p>Please click the link below to verify your email address.</p>
    <a href="">' . $code . '</a>
  </div>
</body>
</html>
        ';
    $mail->Body    = $bodyContent;

    if (!$mail->send()) {
      echo 'Verification code sending failed.';
    } else {
      echo 'success01';
    }
  } else {
    echo ("There is no any registry from this E-mail. Please check your E-mail.");
  }
}
