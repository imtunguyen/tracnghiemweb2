<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

if(isset($_POST['usernameOrEmail'])){
  $usernameOrEmail = $_POST['usernameOrEmail'];
  $userInfo = getUsername($connect, $usernameOrEmail);
    if($userInfo !== null && $userInfo->num_rows > 0) {
      $row = $userInfo->fetch_assoc(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   
    <title>Login</title>
</head>
<body>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="max-width: 500px; max-height: 250px;">
        <form action="sendEmail.php" method="post"> 
            <label for=""><h4>Gửi đến Email</h4></label>
            <div class="row">
                <div class="left-box col-md-8">
                    <label for="">Gửi đến mail:</label>
                    <label for=""><?php echo $row['email'] ?></label>
                    <input type="hidden" name="email" value="<?php echo $row['email'] ?>">
                </div>
                <div class="right-box col-md-4">
                    <img src="<?php echo $row['avatar']?>" style="width: 50px;"><br>
                    <label for=""><?php echo $row['username'] ?></label>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <button class="btn btn-secondary">Hủy</button>
                <button class="btn btn-primary" type="submit" name="submit">Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<?php
          } 
          else{
             
          }
      }
include('includes/admin_footer.php');
?>
