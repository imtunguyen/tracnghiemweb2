<?php

use Smalot\PdfParser\Encoding\PostScriptGlyphs;

include('./includes/header.php');
include('./includes/database.php');
if(isset($_POST['ma_bai_thi'])) {
    $ma_bt = $_POST['ma_bai_thi'];
}

if(isset($_POST['ma_lop'])) {
    $ma_lop = $_POST['ma_lop'];

}

if(isset($_GET['thongbao'])) {
    $thongBao = $_GET['thongbao'];
    if($thongBao != "") {
        echo "<script>toastr.error('Đề thi đã có trong lớp rồi');</script>";
    }
}
?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa đề thi vào lớp</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form method="post" class="row" action="baithi_sua_xuly.php">
            <input hidden name="ma_bai_thi" type="text" value="<?php echo $ma_bt; ?>">
            <input hidden name="ma_lop" type="text" value="<?php echo $ma_lop; ?>">
            <div class="p-3">
                <label>Chọn đề thi</label>
                <div class="form-floating py-1 col-12">
                    <select disabled name='ma_de_thi'  class="form-select border shadow">
                        <?php
                            $user_id = $_SESSION['userId'];;
                            $sql_dt = "SELECT * FROM de_thi WHERE trang_thai = 1 AND ma_nguoi_tao = $user_id";
                            $result_dt = mysqli_query($connect, $sql_dt);
                            while($row_dt = mysqli_fetch_assoc($result_dt)) {
                                echo "<option  value='" .$row_dt['ma_de_thi']. "'>" .$row_dt['ten_de_thi']. "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="p-3">
                <label>Chọn thời gian bắt đầu</label>
                <div class="form-floating py-1 col-12">
                    <input type="datetime-local" name="tgbd" id="tgbd"  class="form-control" >
                    <span class="text-danger" id="tgbd-error"></span>
                </div>
            </div>

            <div class="p-3">
                <label>Chọn thời gian kết thúc</label>
                <div class="form-floating py-1 col-12">
                    <input type="datetime-local" name="tgkt" id="tgkt" class="form-control" >
                    <span class="text-danger" id="tgkt-error"></span>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" onclick="return validateForm();" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="chitietlophoc.php?ma_lop=<?php echo $_SESSION['ma_lop']?>&&ten_lop=<?php echo $_SESSION['ten_lop']?>&&ma_moi=<?php echo  $_SESSION['ma_moi']?> ">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    
    function validateForm() {
        var tgbd = document.getElementById('tgbd').value;
        var tgkt = document.getElementById('tgkt').value;
        var currentTime = new Date();


        if (tgbd <= currentTime) {
            $("#tgbd-error").text("Thời gian bắt đầu phải lớn hơn thời gian hiện tại.");
            return false;
        }

        if (tgkt <= tgbd) {
            $("#tgkt-error").text("Thời gian kết thúc phải lớn hơn thời gian bắt đầu.");
            return false;
        }

        return true; 
    }
</script>

