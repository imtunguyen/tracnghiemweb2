<?php
if(isset($_POST["username"]) && isset($_POST["password"])) {

    session_start();
    include('./includes/database.php');
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_check_login = "SELECT * FROM users WHERE (username = '$username' || email = '$username') AND mat_khau = '$password' AND trang_thai = 1";
    $res_check_login = mysqli_query($connect, $sql_check_login);
    $row_num_check_login = mysqli_num_rows($res_check_login);
    $row_check_login =  mysqli_fetch_assoc($res_check_login);
    $userId = $row_check_login['id'];
    if($row_num_check_login > 0) {
        $sql_check_permission = "SELECT * FROM chi_tiet_quyen WHERE user_id = $userId";
        $res_check_permission = mysqli_query($connect,$sql_check_permission);
        if(mysqli_num_rows($res_check_permission) > 0) {
            $row_check_permission = mysqli_fetch_assoc($res_check_permission);
            $permissionId = $row_check_permission['ma_quyen'];
            $flag = 1;
            if($permissionId == 1) {
                echo "Đăng nhập thành công. Đang chuyển hướng đến trang admin.";
            } elseif($permissionId == 2) {
                echo "Đăng nhập thành công. Đang chuyển hướng đến trang giáo viên.";
            } elseif($permissionId == 3) {
                echo "Đăng nhập thành công. Đang chuyển hướng đến trang học sinh.";
            } else {
                echo "Đăng nhập thất bại. Vui lòng liên hệ admin để biết thêm chi tiết.";
                $flag = 0;
            }
            if($flag == 1) {
                $_SESSION["username"] = $row_check_login['username'];
                $_SESSION["userId"] = $userId;
                $_SESSION["permissionId"] = $permissionId;
            }
        }
    } else {
        echo "Sai tên đăng nhập hoặc mật khẩu";
    }
}
