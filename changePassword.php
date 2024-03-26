<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

if(isset($_POST['submit'])) {
       echo $email = $_SESSION['email'];
            if(isset($_POST['newPassword']) && isset($_POST['confirmPassword'])){
                if($_POST['newPassword'] != $_POST['confirmPassword']){
                    echo "Nhập mật khẩu chưa trùng khớp";
                }
                else{
                    $newPassword = $_POST["newPassword"];
                    updatePassword($connect, $email, $newPassword);
                    echo "<script>alert('Đổi mật khẩu thành công');</script>";
                }
            }
            else{
                echo "<script>alert('Vui lòng nhập mật khẩu');</script>";
            }
}
    

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
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 600px; height: 350px">
        <form action="" method="post"> 
            <label for=""><h4>Đổi mật khẩu</h4></label><hr>
            <label for="">Nhập mật khẩu mới:</label><br>
            <input type="text" class="form-control" name="newPassword"><br>
            <label for="">Xác nhận mật khẩu:</label><br>
            <input type="text" class="form-control" name="confirmPassword"><hr>
            <div class="text-end">
            <button class="btn btn-secondary">Hủy</button>
            <button class="btn btn-primary"type="submit" name="submit"  >Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<?php
        
?>