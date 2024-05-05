<?php
ob_start();
include('../includes/config.php');
include('../includes/admin_header.php');
include('../includes/database.php');
include('../includes/functions.php');
include('../includes/functionLopHoc.php');

$ten_lop=getlophocByID($connect,$_GET['id']);
$ten_lop = $ten_lop->fetch_assoc()['ten_lop'];
?>
<div class="w-100 card border-0 p-4">
<div class="card-header bg-success bg-gradient ml-0 py-3">
    <div class="row">
        <div class="col-12 text-center text-white">
            <h2>Bài thi có trong lớp <?php echo $ten_lop; ?> </h2>
        </div>
    </div>
</div>
<div class="card-body border p-4">
    <div class="row pb-3">
        <div class="col-7">
            <div class="form-group">
                <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm lớp học" />
            </div>
           
            
        </div>
        <div class="col-5 text-end">
            <a class="btn btn-success" href="../admin/dethi_add.php">
                <i class="bi bi-plus-circle"></i> Thêm đề thi vào lớp 
            </a>
        </div>
    </div>
    <div class="table-responsive" id="dynamic_vaolop"></div>
 </div>   
 <script>
$(document).ready(function(){
    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchvaolop.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_vaohoc').html(data);
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
  include('../includes/admin_footer.php');
?>