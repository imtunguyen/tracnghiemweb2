<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

if(isset($_POST['submit']) && isset($_POST['email'])){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nguyenthanhthientu18nt@gmail.com';
    $mail->Password = 'wxaihndxfozuwqep';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('nguyenthanhthientu18nt@gmail.com');
    $mail->addAddress($_POST['email']);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';

    $mail->Subject = '=?UTF-8?B?'.base64_encode('Quên mật khẩu').'?=';
    $random = random_number(6);
    $_SESSION['random_code'] = $random;
    $_SESSION['email'] = $_POST['email'];
    $mail->Body = "$random";

    $mail->send();

    header("Location: inputCode.php"); // Chuyển hướng sau khi gửi email
    exit();
}
?>
