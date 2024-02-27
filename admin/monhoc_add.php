<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functions.php');

if (isset($_POST['ten_mon_hoc'])) {
    if ($stm = $connect->prepare('INSERT INTO mon_hoc (ten_mon_hoc, trang_thai) VALUES (?, ?)')) {
        $stm->bind_param('si', $_POST['ten_mon_hoc'], $trang_thai);
        
        $trang_thai = 1;
        
        $stm->execute();
        $_SESSION['toastr'] = 'Thêm môn học mới thành công';
        header('Location: monhoc.php');
        
        $stm->close();
        die();
    }
    else {
    echo 'Could not prepare statement!';
    }
}
?>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Thêm môn học</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form method="post" class="row">
            <div class="p-3">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_mon_hoc" />
                    <label class="ms-2">Tên môn học</label>
                    <span></span>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Thêm
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/monhoc.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include('../includes/admin_footer.php');
?>