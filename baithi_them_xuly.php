<?php
    include('./includes/database.php');
    session_start();
    if( isset($_POST['tgbd']) && isset($_POST['tgkt']) && isset($_POST['ma_lop'])) {
        
        $ma_dt = $_POST['ma_de_thi'];
        $tgbd = date('Y-m-d', strtotime($_POST['tgbd']));
        $tgkt = date('Y-m-d', strtotime($_POST['tgkt']));
        $userId = $_SESSION['userId'];
        $ma_lop = $_POST['ma_lop'];

        $sql_check = "SELECT * FROM bai_thi WHERE ma_lop = $ma_lop AND ma_de_thi = $ma_dt";
        $result_check = mysqli_query($connect, $sql_check);

        if(mysqli_num_rows($result_check) > 0) {
            header("Location: baithi_add.php?ma_lop=$ma_lop&thongbao=trung");
            exit();
        }
        
        
        $sql = "INSERT INTO bai_thi (`ma_lop`, `ma_de_thi`, `tg_bat_dau`, `tg_ket_thuc`, `trang_thai`) VALUES 
        ($ma_lop, $ma_dt,'$tgbd','$tgkt',1)";
        $result = mysqli_query($connect, $sql);
        $sql_lh = "SELECT * FROM lop WHERE ma_lop = $ma_lop";
        $result_lh = mysqli_query($connect, $sql_lh);
        $row_lh = mysqli_fetch_assoc($result_lh);
        $ten_lop = $row_lh['ten_lop'];
        $ma_moi = $row_lh['ma_moi'];

        header("Location: chitietlophoc.php?ma_lop=$ma_lop&ten_lop=$ten_lop&ma_moi=$ma_moi&thong_bao=success");
    }
?>