<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');


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
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 500px; height: 300px">
        <form action="confirmUsername.php" method="post"> 
            <label for=""><h4>Nhập Username hoặc Email</h4></label><hr>
            <label for="">Nhập Username hoặc Email để thay đổi mật khẩu:</label><br><br>
            <input type="text" class="form-control" name="usernameOrEmail"aria-label="Recipient's username" aria-describedby="button-addon2"><hr>
            <div class="text-end">
            <button class="btn btn-secondary">Hủy</button>
            <button class="btn btn-primary"type="submit" name="submit"  >Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<?php
include('includes/admin_footer.php');
?>
