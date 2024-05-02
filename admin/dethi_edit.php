<?php
ob_start();
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
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
    $_SESSION['toastr'] = 'Sửa đề thi thành công';
    header('Location: dethi.php');
    
}

ob_end_flush();
if(isset($_GET['id'])){
    $ma_de_thi = $_GET['id'];
    $dethi = getDeThibyID($connect, $ma_de_thi);
    $dethi_record = $dethi->fetch_assoc();
    if($dethi->num_rows > 0){
?>
<style>
    .error-message {
        color: red;
}
</style>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa đề thi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form  id="addDeThiForm" method="post" class="row">
            <div class="p-3">
                <p>Sửa tên đề thi</p>
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_de_thi" value="<?php echo $dethi_record['ten_de_thi'];?>" />
                    <label class="ms-2">Tên đề thi </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="dethi">Vui lòng nhập tên đề thi</div>
                <p>Sửa thời gian làm bài</p>
                <div class="form-floating py-1 col-12">
                    <input type="number" class="form-control border shadow" name="thoi_gian_lam_bai" value="<?php echo $dethi_record['thoi_gian_lam_bai'];?>"/>
                    <label class="ms-2">Thời gian làm bài </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="thoiGian">Vui lòng nhập đúng thời gian (0 < Thời gian làm bài < 200 )</div>
                <p>Sửa môn học</p>
 
                    <select class="form-select" name="ma_mon_hoc" id="ma_mon_hoc">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($dethi_record['ma_mon_hoc'] == $row['ma_mon_hoc']) ? 'selected' : '';
                            echo '<option value="' . $row['ma_mon_hoc'] . '" ' . $selected . '>' . $row['ten_mon_hoc'] . '</option>';
                        }
                        ?>
                    </select><br>
                <div class="error-message" id="monhoc">Vui lòng chọn môn học</div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/dethi.php">
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
    }
}
include('../includes/admin_footer.php');
?>