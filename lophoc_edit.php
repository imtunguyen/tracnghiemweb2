<?php
require_once('includes/functionLopHoc.php');

$ma_lop = $_GET['ma_lop'];
$name = "";
$query = "select ten_lop from lop where ma_lop = $ma_lop and trang_thai = 1";
$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_assoc($result)) {
    $name = $row['ten_lop'];
}

if (isset($_POST['ten_lop'])) {
    $ten_lop = trim($_POST['ten_lop']);
    if (empty($ten_lop)) {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
            toastr.options = {
            "progressBar" : true
        }
        toastr.error("<?php echo "Tên môn lớp không được để trống. Vui lòng nhập lại"; ?>");
</script>"
        <?php
    } 
    else {
        updateLopHoc($connect, $_POST['ten_lop'], $_GET['ma_lop']);
        $_SESSION['toastr'] = 'Cập nhật lớp học thành công';
        header('Location: lophoc.php');
        
    }
}
?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa lớp học</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form method="post" class="row">
            <div class="p-3">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_lop"
                        value="<?php echo $name ?>" />
                    <label class=" ms-2">Tên lớp học</label>
                    <span></span>
                    
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="lophoc.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>