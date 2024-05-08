<?php
if (
    isset($_POST["username"]) && isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["birthday"])
) {
    include('./includes/database.php');
    $id = $_POST['id'];
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $avatar = $_FILES["avatar"]["name"];
    $tempname = $_FILES["avatar"]["tmp_name"];
    $folder = "./images/" . $avatar;
    $dateCreate = date("Y-m-d H:i:s");
    $birthDay = $_POST["birthday"];

    $sql_check_exist_username = "SELECT * FROM users WHERE trang_thai = 1 AND username = '$username' AND id != $id";
    $res_check_username = mysqli_query($connect, $sql_check_exist_username);
    $row_check_username = mysqli_num_rows($res_check_username);

    $sql_check_exist_email = "SELECT * FROM users WHERE trang_thai = 1 AND email = '$email' AND id != $id";
    $res_check_email = mysqli_query($connect, $sql_check_exist_email);
    $row_check_email = mysqli_num_rows($res_check_email);

    if(move_uploaded_file($tempname, $folder) && $avatar != "") {
        echo "File uploaded successfully";
    } else {
        echo "Failed to upload file";
    }
    if($row_check_email > 0) {
        echo "Email đã tồn tại";
        die();
    } elseif ($row_check_username > 0) {
        echo "Tên tài khoản bị trùng";
        die();
    } else {
        // Update user data
        $sql_update_user = "UPDATE users SET ho_va_ten = '$fullname', username = '$username', email = '$email', ngay_sinh = '$birthDay',avatar = '$avatar'";
        
        $sql_update_user .= " WHERE id = $id";

        if(mysqli_query($connect, $sql_update_user)) {
            echo "Cập nhật thông tin thành công";
        } else {
            echo "Đã xảy ra lỗi khi cập nhật thông tin: " . mysqli_error($connect);
        }
    }
}

