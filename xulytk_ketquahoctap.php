<?php
session_start();
include('./includes/database.php');

if(isset($_POST['ma_lop'])) {
    $ma_lop = $_POST['ma_lop'];
    $user_id = $_SESSION['userId'];
    $sql = "SELECT DISTINCT kq.*, dt.ten_de_thi
    FROM ket_qua kq 
    JOIN chi_tiet_lop ctl ON kq.user_id = ctl.user_id 
    JOIN bai_thi ON ctl.ma_lop = bai_thi.ma_lop
    JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi 
    JOIN users ON users.id = kq.user_id
    WHERE ctl.ma_lop = $ma_lop AND users.id = $user_id";

    $result = mysqli_query($connect, $sql);
    $array = array();
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $sub_array = array(
                $row['ten_de_thi'],
                $row['diem'],
                "#b87333" // Màu sắc cố định "#b87333" - bạn có thể thay đổi tùy ý
            );
            array_push($array, $sub_array);
        }
         // JSON_UNESCAPED_UNICODE cho phép trả về tiếng việt
         echo json_encode($array,JSON_UNESCAPED_UNICODE); 
    } else {
        echo "Không có dữ liệu.";
    }
} else {
    echo "Thiếu dữ liệu đầu vào.";
}
?>
