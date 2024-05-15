<?php
session_start();
include('./includes/database.php');

if(isset($_POST['ma_lop'])) {
    $ma_lop = $_POST['ma_lop'];
    $user_id = $_SESSION['userId'];
    $sql = "SELECT kq.*, dt.ten_de_thi
    FROM ket_qua kq 
    JOIN bai_thi bt ON kq.ma_bai_thi = bt.ma_bai_thi
    JOIN de_thi dt ON dt.ma_de_thi = bt.ma_de_thi 
    JOIN users u ON u.id = kq.user_id
    JOIN chi_tiet_lop ctl ON ctl.ma_lop = bt.ma_lop
    WHERE ctl.ma_lop = $ma_lop AND u.id = $user_id
    GROUP BY dt.ten_de_thi";

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
