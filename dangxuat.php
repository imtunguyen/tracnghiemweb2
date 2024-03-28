<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['userId']) && isset($_SESSION['permissionId'])) {
    unset($_SESSION['username']);
    unset($_SESSION['userId']);
    unset($_SESSION['permissionId']);
    header("Location: index.php");
} else {
    echo "Đăng xuất không thành công";
}
exit();
?>