<?php
ob_start();
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionMonHoc.php');
include('../includes/functions.php');
include('../includes/functionDeThi.php');
include('../includes/functionChiTietDeThi.php');
thongBao();
$monhoc = getMonHoc($connect);
$dethi = getDeThi($connect);
if(isset($_GET['delete'])){
    deleteDeThi($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa đề thi thành công';
    header('Location: dethi.php');
}
if(isset($_POST['submit'])){
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $trang_thai = 1;
    $thoi_gian_lam_bai = $_POST['thoiGian'];
    $ten_de_thi = $_POST['tenDeThi'];
    $ma_nguoi_tao = 1;
    addDeThi($connect, $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao);
    $_SESSION['toastr'] = 'Thêm đề thi thành công';
    header('Location: dethi.php');
    exit;
}
ob_end_flush();
?>
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
                <a href="dethi_add.php" class="btn btn-success" ><i class="bi bi-plus-circle"></i> Thêm đề thi mới</a>
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
include('../includes/admin_footer.php'); ?>
