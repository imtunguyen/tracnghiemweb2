<?php
ob_start();
include('../includes/header.php');
include('../includes/functionMonHoc.php');

if (isset($_POST['ten_mon_hoc'])) {
    $ten_mon_hoc = trim($_POST['ten_mon_hoc']);
    if (empty($ten_mon_hoc)) {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
            toastr.options = {
            "progressBar" : true
        }
        toastr.error("<?php echo "Tên môn học không được để trống. Vui lòng nhập lại"; ?>");
</script>"
        <?php
    } else {
        updateMonHoc($connect, $_POST['ten_mon_hoc'], $_GET['id']);
        $_SESSION['toastr'] = 'Cập nhật môn học thành công';
        header('Location: monhoc.php');
        
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
                    <a class="btn btn-secondary w-100" href="../giaovien/monhoc.php">
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
include('../includes/footer.php');
?>