<?php
ob_start();
include('../includes/database.php');
include('../includes/header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

thongBao();
$monhoc = getMonHoc($connect);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
               <div class="row">
                    <div class="form-group col-6">
                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm câu hỏi" />
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_monhoc" id="filter_monhoc">
                            <option disabled selected>Môn học</option>
                            <?php while($monhoc_record = $monhoc->fetch_assoc()) { ?>
                                <option value="<?php echo $monhoc_record['ma_mon_hoc']; ?>"><?php echo $monhoc_record['ten_mon_hoc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_dokho" id="filter_dokho">
                            <option disabled selected>Độ khó</option>
                            <option value="Dễ">Dễ</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Khó">Khó</option>
                        </select>
                    </div>
               </div>
            </div>
            <div class="col-4 text-end">
                <?php  if(check($connect, $_SESSION['userId'], 'them_cauhoi')) {echo'
                <a class="btn btn-success" href="../giaovien/cauhoi_add.php">
                    <i class="bi bi-plus-circle"></i> Thêm câu hỏi mới
                </a>';}?>
            </div>
            <div class="col-2 ">
                <?php  if(check($connect, $_SESSION['userId'], 'them_cauhoi')) {echo'
                
                <a class="btn btn-primary" href="../giaovien/export_file.php">
                <i class="bi bi-file-earmark-text-fill"></i> Xuất File
                </a>';}?>
            </div>
        </div>
        <div class="table-responsive" id="dynamic_cauhoi"></div>
     </div>   

<script>
$(document).ready(function(){
    load_data(1);

    function load_data(page, search_query = '', monHoc = '', doKho = '') {
        $.ajax({
            url: "fetchch.php",
            method: "POST",
            data: {
                page: page,
                query: search_query,
                mon_hoc: monHoc,
                do_kho: doKho
            },
            success: function(data) {
                $('#dynamic_cauhoi').html(data);
            }
        });
    }

    $(document).on('click', '.page-link', function(){
        var page = $(this).data('page_number');
        var search_query = $('#search_box').val();
        var monHoc = $('#filter_monhoc').val();
        var doKho = $('#filter_dokho').val();
        load_data(page, search_query, monHoc, doKho);
    });

    $('#search_box').keyup(function(){
        var search_query = $(this).val();
        var monHoc = $('#filter_monhoc').val();
        var doKho = $('#filter_dokho').val();
        load_data(1, search_query, monHoc, doKho);
    });

    $('#filter_monhoc').change(function(){
        var search_query = $('#search_box').val();
        var monHoc = $(this).val();
        var doKho = $('#filter_dokho').val();
        load_data(1, search_query, monHoc, doKho);
    });

    $('#filter_dokho').change(function(){
        var search_query = $('#search_box').val();
        var monHoc = $('#filter_monhoc').val();
        var doKho = $(this).val();
        load_data(1, search_query, monHoc, doKho);
    });
});

</script>

<?php 
    include('../includes/footer.php');
?>
