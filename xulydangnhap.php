<?php

require_once('./includes/functions.php');

if (isset($_POST["username"]) && isset($_POST["password"])) {

    session_start();
    include('./includes/database.php');
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_check_login = "SELECT * FROM users WHERE (username = '$username' || email = '$username') AND mat_khau = '$password' AND trang_thai = 1";
    $res_check_login = mysqli_query($connect, $sql_check_login);
    $row_num_check_login = mysqli_num_rows($res_check_login);

    if ($row_num_check_login > 0) {
        $row_check_login =  mysqli_fetch_assoc($res_check_login);
        $userId = $row_check_login['id'];

        $_SESSION["username"] = $row_check_login['username'];
        $_SESSION["userId"] = $userId;
        
    } else {
        echo "Sai tên đăng nhập hoặc mật khẩu";
    }
}
