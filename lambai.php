<?php

include('includes/header.php');
include('includes/database.php');
if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_de_thi']) &&
isset($_POST['thoi_gian_lam_bai']) && isset($_POST['ten_de_thi'])
&& isset($_POST['ma_lop'])) {
    
    $ma_de_thi = $_POST['ma_de_thi'];
    $ma_bai_thi = $_POST['ma_bai_thi'];
    $thoi_gian_lam_bai = $_POST['thoi_gian_lam_bai'];
    $ten_de_thi = $_POST['ten_de_thi'];
    $user_id = $_SESSION['userId'];
    $sql_check_lam_bai = "select * from ket_qua where ma_bai_thi = $ma_bai_thi and user_id = $user_id";
    $select = mysqli_query($connect, $sql_check_lam_bai);
    $check_lam_bai = mysqli_num_rows($select);
    // check da lam bai
    $ma_lop = $_POST['ma_lop'];
    $sql_lh = "SELECT * FROM lop WHERE ma_lop = $ma_lop";
    $result_lh = mysqli_query($connect, $sql_lh);
    $row_lh = mysqli_fetch_assoc($result_lh);
    $ten_lop = $row_lh['ten_lop'];
    $ma_moi = $row_lh['ma_moi'];
    if($check_lam_bai != 0) {
        header("Location: chitietlophoc.php?ma_lop=$ma_lop&ten_lop=$ten_lop&ma_moi=$ma_moi&thong_bao_da_lam_bai=bandalambaithiroi");
    }

    $sql_dh = "SELECT * FROM bai_thi WHERE ma_bai_thi = $ma_bai_thi";
    $result_dh = mysqli_query($connect,$sql_dh);
    $row_dh = mysqli_fetch_assoc($result_dh);
    $tgbd = $row_dh['tg_bat_dau'];
    $tgkt = $row_dh['tg_ket_thuc'];
    date_default_timezone_set('Asia/Ho_Chi_Minh'); 
    $tght = date('Y-m-d H:i:s', time());
    
    if($tgbd > $tght) {
        header("Location: chitietlophoc.php?ma_lop=$ma_lop&ten_lop=$ten_lop&ma_moi=$ma_moi&thong_bao_chua_toi_gio_lam_bai=chuatoigiolambai"); 
    }    
    if($tght >= $tgkt) {
        header("Location: chitietlophoc.php?ma_lop=$ma_lop&ten_lop=$ten_lop&ma_moi=$ma_moi&thong_bao_het_gio_gio_lam_bai=chuatoigiolambai"); 
    }

}
?>


<div class="container">
    <h1 class="text-center">
        <?php echo $ten_de_thi; ?>
    </h1>
    <div class="row">
        <div class="col-8">
            <div class="text-danger mb-2">
                <span style="font-weight: bold;">Số lần vi phạm (chuyển tab): </span> 
                <span id="slctab">0</span>
            </div>
            <div class="mb-2">
                <span style="font-weight: bold;">Thời gian làm bài: </span>
                <span><?php echo $thoi_gian_lam_bai .":00"; ?></span>
            </div>
            <div class="mb-2">
                <span style="font-weight: bold;">Thời gian còn lại: </span>
                <span  id="time"><?php echo $thoi_gian_lam_bai .":00"; ?></span>
            </div>
        </div>
        <div class="col-4" >
        <ul>
        <div class="text-danger mb-2" style="font-weight: bold;">Quy định làm bài</div>
            <li>Không được tab ra trang khác hay ứng dụng khác.</li>
            <li>Nếu tab quá 3 lần sẽ tự động nộp bài.</li>
        </ul>
        </div>
    </div>
    
    <form action="ket_qua.php" method = "POST">
    <?php 
    $query = "select ch.* from chi_tiet_de_thi ctdt 
    join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi 
    join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi 
    where dt.ma_de_thi = $ma_de_thi";
    $select_cauhoi = mysqli_query($connect,$query);
    $i = 0;  
    while($row = mysqli_fetch_assoc($select_cauhoi)) {
        $i++;
        $ma_cau_hoi = $row['ma_cau_hoi'];
        $noi_dung = $row['noi_dung'];
        echo '
        <div class="question mb-3">';
        echo '<div class="row mb-2">'. 'Câu ' . $i . ': ' . $noi_dung .'</div>'; 
        echo '<div role="group" aria-label="Basic radio toggle button group">';
        $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
        $select_cautl = mysqli_query($connect,$query2); 
        $index = 0;
        while($row2 = mysqli_fetch_assoc($select_cautl)) { 
            ++$index;
            $la_dap_an = $row2['la_dap_an'];
            $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
            $noi_dung_ctl = $row2['noi_dung'];
            switch($index) {
                case 1: 
                    echo
                    '   
                        <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                            <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                            <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> A </label>
                            <div>' . $noi_dung_ctl. '</div>
                        </div>
                    ';
                break;
                case 2: 
                    echo
                    '
                        <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                            <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                            <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> B </label>
                            <div>' . $noi_dung_ctl. '</div>
                        </div>
                    ';
                break;
                case 3: 
                    echo
                    '
                        <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                            <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                            <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> C </label>
                            <div>' . $noi_dung_ctl. '</div>
                        </div>
                    ';
                break;
                case 4: 
                    echo
                    '
                        <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                            <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                            <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> D </label>
                            <div>' . $noi_dung_ctl. '</div>
                        </div>
                    ';
                break;
            }
            
        }
        echo '
        </div>
        ';
    }

    echo '</div>';
    ?>
    <input type="text" hidden name="ma_bai_thi" value=" <?php echo $ma_bai_thi; ?> ">
    <input type="text" hidden name="ma_de_thi" value=" <?php echo $ma_de_thi; ?> ">

    <div class="button-submit">
        <input class="btn btn-primary" id="submitButton" type="submit" name="submit" value = "Submit">
    <div>
</form>
</div>

<script>
    let time = <?php echo $thoi_gian_lam_bai; ?>;
    function startCountdown() {
    var countdownElement = document.getElementById("time");
    var timeLeft = <?php echo $thoi_gian_lam_bai; ?> * 60;

    var countdownInterval = setInterval(function() {
        // Chuyển thời gian còn lại thành phút và giây
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;

        // Định dạng thời gian hiển thị (phút:giây)
        var formattedTime = minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
        
        // Hiển thị thời gian còn lại trong phần tử HTML
        countdownElement.textContent = formattedTime;

        // Giảm thời gian còn lại
        timeLeft--;

        // Kiểm tra nếu thời gian còn lại là âm hoặc bằng 0, dừng đếm ngược
        if (timeLeft < 0) {
            clearInterval(countdownInterval);
            document.getElementById("submitButton").click();
        }
    }, 1000); // Cập nhật thời gian mỗi giây
}


window.onload = function() {
    startCountdown();
};
let vipham=0;
$(window).blur(function() {
    ++vipham;
   alert('Bạn đã tab ra ngoài ' + vipham + ' lần');
   if(vipham == 3) {
    document.getElementById("submitButton").click();
   }
   document.getElementById("slctab").innerText = vipham;
   //do something else
});
</script>

<?php
    include('includes/footer.php');
?>