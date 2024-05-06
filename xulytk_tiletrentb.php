<?php
include('./includes/database.php');

if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_lop'])) {
    $ma_bai_thi = $_POST['ma_bai_thi'];
    $ma_lop = $_POST['ma_lop'];

    $sql = "SELECT kq.diem
            FROM ket_qua kq 
            JOIN chi_tiet_lop ctl ON kq.user_id = ctl.user_id 
            JOIN lop ON lop.ma_lop = ctl.ma_lop
            JOIN chi_tiet_quyen ctq ON ctq.user_id = kq.user_id 
            JOIN bai_thi ON kq.ma_bai_thi = bai_thi.ma_bai_thi
            JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi 
            WHERE ctq.ma_quyen = 3 AND ctl.ma_lop = $ma_lop AND bai_thi.ma_bai_thi = $ma_bai_thi
            ";

    $result = mysqli_query($connect, $sql);
    $array = array();
    $sum_trentb = 0;
    $sum_duoitb = 0;
    
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

            $diem = $row['diem'];
            if($diem >= 5) {
                $sum_trentb += 1;
            } else if($diem < 5) {
                $sum_duoitb += 1;
            }
        }
        $tren_tb = array(
            "Trên trung bình",
            $sum_trentb
        );
        $duoi_tb = array(
            "Dưới trung bình",
            $sum_duoitb
        );
        array_push($array, $tren_tb);
        array_push($array, $duoi_tb);
        // JSON_UNESCAPED_UNICODE cho phép trả về tiếng việt
        echo json_encode($array,JSON_UNESCAPED_UNICODE); 
    } else {
        echo "Không có dữ liệu.";
    }
} else {
    echo "Thiếu dữ liệu đầu vào.";
}
?>
