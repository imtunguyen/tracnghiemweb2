<?php
ob_start();
include('../includes/database.php');
include('../includes/header.php');
include('../includes/functionMonHoc.php');
include('../includes/functionDeThi.php');

$result = getMonHoc($connect);
if (isset($_POST['ten_de_thi']) && isset($_POST['thoi_gian_lam_bai']) && isset($_POST['ma_mon_hoc'])) {
    $ten_de_thi = trim($_POST['ten_de_thi']);
    $thoi_gian_lam_bai = trim($_POST['thoi_gian_lam_bai']);
    $ma_mon_hoc = trim($_POST['ma_mon_hoc']);
    $trang_thai = 1;
    $ma_nguoi_tao = 1;
    addDeThi($connect, $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao);
    $_SESSION['toastr'] = 'Thêm đề thi thành công';
    header('Location: dethi.php');
    
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <script src="../js/script.js"></script>
    
</head>
<style>
    .error-message {
        color: red;
}
</style>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Thêm đề thi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form  id="addDeThiForm" method="post" class="row">
            <div class="p-3">
                <p>Thêm tên đề thi</p>
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_de_thi" />
                    <label class="ms-2">Tên đề thi </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="dethi">Vui lòng nhập tên đề thi</div>
                <p>Thêm thời gian làm bài</p>
                <div class="form-floating py-1 col-12">
                    <input type="number" class="form-control border shadow" name="thoi_gian_lam_bai" />
                    <label class="ms-2">Thời gian làm bài </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="thoiGian">Vui lòng nhập đúng thời gian (0 < Thời gian làm bài < 200 )</div>
                <p>Thêm môn học</p>
                <select class="form-select" name="ma_mon_hoc">
                    <option disabled selected>--Chọn môn học--</option>
                    <?php while($record = $result->fetch_assoc()){?>
                        <option value="<?php echo $record['ma_mon_hoc'];?>"><?php echo $record['ten_mon_hoc'];?></option>
                    <?php } ?>
                </select>
                <div class="error-message" id="monhoc">Vui lòng chọn môn học</div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Thêm
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../giaovien/dethi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#thoiGian').hide();
    $('#monhoc').hide();
    $('#dethi').hide();

    $('#addDeThiForm').submit(function(event) {
    var thoiGian = $('input[name="thoi_gian_lam_bai"]').val();
    var maMonHoc = $('select[name="ma_mon_hoc"]').val();
    var tenDeThi = $('input[name="ten_de_thi"]').val();
    var isValid = true;

    if (tenDeThi == null || tenDeThi.trim().length === 0) { 
            $('#dethi').show(); 
            isValid = false;
        } else {
            $('#dethi').hide();
        }

    if (thoiGian < 0 || thoiGian > 200 || thoiGian.trim().length === 0) {
    $('#thoiGian').show();
    isValid = false;
    } else {
        $('#thoiGian').hide();
    }

        if(maMonHoc == null){
            $('#monhoc').show();
            isValid = false;
        } else {
            $('#monhoc').hide();
        }

        if(!isValid){
            event.preventDefault();
        }
    });

});
</script>
<?php
include('../includes/footer.php');
?>