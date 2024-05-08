
<?php 
include( 'includes/config.php');
include( 'includes/functionUsers.php');

include( 'includes/database.php');
if(isset($_POST['newPassword']) && isset($_POST['reNewPassword'])){
    $email = $_SESSION['email'];
    $newPassword = $_POST["newPassword"];
    updatePassword($connect, $email, $newPassword);
    echo "Đổi mật khẩu thành công đang chuyển hướng đến trang đăng nhập...";
}