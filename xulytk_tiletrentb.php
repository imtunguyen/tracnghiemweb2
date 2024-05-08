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
        $tght = date('Y-m-d H:i:s');
        if($tght > $tgkt) {
            add_kq_0($connect, $ma_bai_thi, $row_get_userId['user_id']);
        } 
    }

    $sql = "SELECT kq.diem
            FROM ket_qua kq 
            JOIN chi_tiet_lop ctl ON kq.user_id = ctl.user_id 
            JOIN lop ON lop.ma_lop = ctl.ma_lop
            JOIN bai_thi ON kq.ma_bai_thi = bai_thi.ma_bai_thi
            JOIN de_thi dt ON dt.ma_de_thi = bai_thi.ma_de_thi 
            JOIN chi_tiet_quyen ctq on ctq.user_id = kq.user_id
            Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen 
            Where ctcn.ma_chuc_nang = 22 AND ctl.ma_lop = $ma_lop AND bai_thi.ma_bai_thi = $ma_bai_thi
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
