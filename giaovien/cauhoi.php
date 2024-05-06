<?php
ob_start();
include('../includes/database.php');
include('../includes/header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

thongBao();
if(isset($_GET['delete'])){
    deleteCauHoi($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa câu hỏi thành công';
    header('Location: cauhoi.php');
    exit();
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
<body>
 <div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-6">
                <div class="form-group">
                    <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm câu hỏi" />
                </div>
            </div>
            <div class="col-4 text-end">
<<<<<<< HEAD:admin/cauhoi.php
                <a class="btn btn-success" href="../admin/cauhoi_add.php">
=======
                <a class="btn btn-success" href="../giaovien/cauhoi_add.php">
>>>>>>> dev:giaovien/cauhoi.php
                    <i class="bi bi-plus-circle"></i> Thêm câu hỏi mới
                </a>
            </div>
            <div class="col-2 ">
<<<<<<< HEAD:admin/cauhoi.php
                <a class="btn btn-primary" href="../admin/export_file.php">
=======
                <a class="btn btn-primary" href="../giaovien/export_file.php">
>>>>>>> dev:giaovien/cauhoi.php
                <i class="bi bi-file-earmark-text-fill"></i> Xuất File
                </a>
            </div>
        </div>
        <div class="table-responsive" id="dynamic_cauhoi"></div>
     </div>   


<script>
$(document).ready(function(){
    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchch.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_cauhoi').html(data);
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
});
</script>

<?php 
    include('../includes/footer.php');
?>
