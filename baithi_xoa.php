<?php

?>

<?php
    include('./includes/database.php');
    session_start();
    if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_lop'])) {
        $ma_bt = $_POST['ma_bai_thi'];
        $userId = $_SESSION['userId'];
        $ma_lop = $_POST['ma_lop'];

        
        $sql = "UPDATE bai_thi SET trang_thai = 0 WHERE ma_bai_thi = $ma_bt";
        $result = mysqli_query($connect, $sql);

        $sql_lh = "SELECT * FROM lop WHERE ma_lop = $ma_lop";
        $result_lh = mysqli_query($connect, $sql_lh);
        $row_lh = mysqli_fetch_assoc($result_lh);
        $ten_lop = $row_lh['ten_lop'];
        $ma_moi = $row_lh['ma_moi'];

        header("Location: chitietlophoc.php?ma_lop=$ma_lop&ten_lop=$ten_lop&ma_moi=$ma_moi&thong_bao_delete=success");
    }
?>