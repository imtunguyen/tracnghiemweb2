<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

$usernameOrEmail = isset($_GET['usernameOrEmail']) ? $_GET['usernameOrEmail'] : '';
    echo  $usernameOrEmail;
if(isset($_POST["submit"])){
    if(isset($_POST['newPassword']) && isset($_POST['confirmPassword'])){
        if($_POST['newPassword'] != $_POST['confirmPassword']){
            echo "Nhập mật khẩu chưa trùng khớp";
        }
        else{
            $newPassword = $_POST["newPassword"];
            
            updatePassword($connect,$usernameOrEmail ,$newPassword);
            echo "<script>
            alert('Đổi mật khẩu thành công');
                 </script>";
        }
    }
    else{
        echo "Vui lòng nhập mật khẩu";
    }
}
?>

<div>
    <form action="#" method="post">
        <label for="">Nhập Mật khẩu mới</label><br>
        <input type="text" name="newPassword" id=""><br>
        <label for="">Xác nhận mật khẩu</label><br>
        <input type="text" name="confirmPassword" id="">
        <button type="submit" name="submit">Xác nhận</button>
    </form>
</div>