<?php
ob_start();
include('../includes/header.php');
include('../includes/database.php');
include('../includes/functionMonHoc.php');
include('../includes/functionDeThi.php');
include('../includes/functionChiTietDeThi.php');
thongBao();
if(isset($_GET['delete'])){
    deleteDeThi($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa đề thi thành công';
    header('Location: dethi.php');
ob_end_flush();
}
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
<body>
<style>
    .error-message {
        color: red; 
}
</style>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách đề thi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-7">
                <div class="form-group">
                    <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm đề thi" />
                </div>
            </div>
            <div class="col-5 text-end">
<<<<<<< HEAD:admin/dethi.php
                <a href="dethi_add.php" class="btn btn-success" ><i class="bi bi-plus-circle"></i> Thêm đề thi mới</a>
=======
                <a href="../giaovien/dethi_add.php" class="btn btn-success" ><i class="bi bi-plus-circle"></i> Thêm đề thi mới</a>
>>>>>>> dev:giaovien/dethi.php
            </div>
        </div>
        <div class="table-responsive" id="dynamic_dethi"></div>
    </div> 
</div>



<script>
    load_data(1);
    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchdethi.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_dethi').html(data);
            }
        });
    }

    $(document).on('click', '.page-link', function(){
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
    });

    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data(1, query);
    });
</script>

<?php 
include('../includes/footer.php'); ?>