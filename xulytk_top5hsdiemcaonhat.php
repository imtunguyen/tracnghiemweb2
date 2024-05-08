<?php
include('./includes/database.php');

if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_lop'])) {
    $ma_bai_thi = $_POST['ma_bai_thi'];
    $ma_lop = $_POST['ma_lop'];

    $sql_get_bt = "SELECT * FROM bai_thi WHERE ma_bai_thi = $ma_bai_thi";
    $result_get_bt = mysqli_query($connect, $sql_get_bt);
    $row_get_bt = mysqli_fetch_assoc($result_get_bt);
    $tgkt = $row_get_bt['tg_ket_thuc'];

    function add_kq_0($connect,$ma_bai_thi, $user_id){
        $sql_insert = "INSERT INTO ket_qua(ma_bai_thi, user_id, so_cau_dung, 
        so_cau_sai, so_cau_chua_chon, diem) VALUES 
        ($ma_bai_thi, $user_id, 0, 0, 0, 0)";
        $res_insert = mysqli_query($connect, $sql_insert);
    }

    // get user chua lam bai
    $sql_get_userId = "SELECT DISTINCT ctl.user_id
    FROM chi_tiet_lop ctl
    WHERE NOT EXISTS (
        SELECT 1 
        FROM ket_qua kq 
        JOIN chi_tiet_quyen ctq ON ctq.user_id = kq.user_id
        JOIN chi_tiet_chuc_nang ctcn ON ctcn.ma_quyen = ctq.ma_quyen 
        WHERE kq.user_id = ctl.user_id AND kq.ma_bai_thi = $ma_bai_thi
         AND ctcn.ma_chuc_nang = 22
    ) AND ma_lop = $ma_lop ;";
    $result_get_userId = mysqli_query($connect, $sql_get_userId);
    while($row_get_userId = mysqli_fetch_assoc($result_get_userId)) {
        $tght = time();
        $tgkt_timestamp = strtotime($tgkt);
        if($tght > $tgkt_timestamp) {
            add_kq_0($connect, $ma_bai_thi, $row_get_userId['user_id']);
        }
    }

    $sql = "SELECT kq.*, dt.ten_de_thi, users.ho_va_ten
            FROM ket_qua kq 
            JOIN chi_tiet_lop ctl ON kq.user_id = ctl.user_id 
            JOIN lop ON lop.ma_lop = ctl.ma_lop
            JOIN bai_thi ON kq.ma_bai_thi = bai_thi.ma_bai_thi
            JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi 
            JOIN users ON users.id = kq.user_id
            JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
            Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen 
            Where ctcn.ma_chuc_nang = 22 AND ctl.ma_lop = $ma_lop AND bai_thi.ma_bai_thi = $ma_bai_thi
            ORDER BY kq.diem DESC 
            LIMIT 5";

    $result = mysqli_query($connect, $sql);
    $array = array();
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $sub_array = array(
                $row['ho_va_ten'],
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
