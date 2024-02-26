<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functions.php');


if (isset($_POST['ten_mon_hoc'])) {

    if ($stm = $connect->prepare('UPDATE mon_hoc SET ten_mon_hoc = ? WHERE ma_mon_hoc = ?')) {
        $stm->bind_param('si', $_POST['ten_mon_hoc'], $_GET['id']);
        $stm->execute();
        $_SESSION['toastr'] = 'Cập nhật môn học thành công';
        header('Location: monhoc.php');
        $stm->close();
        die();
    } else {
        echo "Could not prepare statement: " . $connect->error;
    }
}



if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * FROM mon_hoc WHERE ma_mon_hoc =?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $mon_hoc = $result->fetch_assoc();
        if ($mon_hoc) {

?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa môn học</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <form method="post" class="row">
            <div class="p-3">
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_mon_hoc"
                        value="<?php echo $mon_hoc['ten_mon_hoc'] ?>" />
                    <label class=" ms-2">Tên môn học</label>
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
                    <a class="btn btn-secondary w-100" href="../admin/monhoc.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
        }
        $stm->close();
    } else {
        echo 'Could not prepare statement!';
    }
} else {
    echo "No mon_hoc selected";
    die();
}
include('../includes/admin_footer.php');
?>