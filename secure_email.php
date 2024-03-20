<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
if(isset($_POST['submit'])){
    if(isset($_POST['vemail'])){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nguyenthanhthientu18nt@gmail.com';
        $mail->Password = 'wxaihndxfozuwqep';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('nguyenthanhthientu18nt@gmail.com');
        $mail->addAddress($_POST['vemail']);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Subject = '=?UTF-8?B?'.base64_encode('Quên mật khẩu').'?=';
        $mail->Body = "123456";

        $mail->send();
        echo"
        <script>
            alert('Gửi mail thành công');
        </script>
        ";
    }
}
?>