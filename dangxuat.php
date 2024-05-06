<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['userId'])) {
    unset($_SESSION['username']);
    unset($_SESSION['userId']);
    header("Location: dangnhap.php");
} else {
    echo "Đăng xuất không thành công";
}
exit();
?>