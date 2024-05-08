<?php
require_once('includes/quyen_functions.php');
if (
    isset($_POST["username"]) && isset($_POST["fullname"]) && isset($_POST["password"]) &&
     isset($_POST["email"]) && isset($_POST["birthday"])
) {
    include('./includes/database.php');
    $username = $_POST["username"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
    if(isset($_POST["gender"])) {
        $gender = 1;
    } else {
        $gender = 0;
    }
    
    $email = $_POST["email"];
    $avatar = $_FILES["avatar"]["name"];
    $tempname = $_FILES["avatar"]["tmp_name"];
    $folder = "./images/" . $avatar;
    //sua lai
    $permission = strtolower($_POST["permission"]) == strtolower('Giáo viên') ? 2 : 3;
    
    $permission = strtolower($_POST["permission"]) == strtolower('Giáo viên') ? getMaQuyenTheoTen($connect, "giao_vien") : getMaQuyenTheoTen($connect, "hoc_sinh");
    $dateCreate = date("Y-m-d H:i:s");
    $birthDay = $_POST["birthday"];
    $status = 1;

    $sql_check_exist_username = "SELECT * FROM users WHERE trang_thai = 1 AND username = '$username'";
    $res_check_username = mysqli_query($connect, $sql_check_exist_username);
    $row_check_username = mysqli_num_rows($res_check_username);

    $sql_check_exist_email = "SELECT * FROM users WHERE trang_thai = 1 AND email = '$email'";
    $res_check_email = mysqli_query($connect, $sql_check_exist_email);
    $row_check_email = mysqli_num_rows($res_check_email);

    if(move_uploaded_file($tempname, $folder) && $avatar != "") {
       
    } else {
        echo "Failed to upload file";
        die();
    }
    if($row_check_email > 0) {
        echo "Email đã tồn tại";
        die();
    } elseif ($row_check_username > 0) {
        echo "Tên tài khoản bị trùng";
        die();
    } else {
        $sql_insert_user = "INSERT INTO users (ho_va_ten, username, mat_khau, email, avatar, gioi_tinh, ngay_sinh, ngay_tao, trang_thai) VALUES ('$fullname', '$username', '$password', '$email','$avatar', $gender, '$birthDay', '$dateCreate', 1)";
        $res_insert = mysqli_query($connect, $sql_insert_user);
        if ($res_insert) {
            $userId = mysqli_insert_id($connect);
            $sql_insert_userpermission = "INSERT INTO chi_tiet_quyen(ma_quyen, user_id, cho_phep) VALUES ($permission,$userId,1)";
            $res_insert_userpermission = mysqli_query($connect, $sql_insert_userpermission);
            echo "Đăng ký thành công đang chuyển hướng đến trang đăng nhập...";
        } else {
            echo "Đăng ký thất bại";
        }
    }
}

