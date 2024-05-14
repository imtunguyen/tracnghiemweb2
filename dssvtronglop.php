<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']))) {
    header("Location: dangnhap.php");
}
if(!(isset($_GET['ma_lop']) && isset($_GET['ten_lop']))) {
    header("Location: lophoc.php");
} else {
  $ma_lop = $_GET['ma_lop']; 
  $_SESSION['ma_lop'] = $ma_lop;
  $ten_lop = $_GET['ten_lop'];
}
?>
<div class="container">
    <h2 class="text-center mb-5">
         <?php echo $ma_lop . "_" . $ten_lop ?>
    </h2>
    <h3 class="text-center mb-3">
        Danh sách sinh viên trong lớp
    </h3>
    <div class="row mb-2"> 
        <div class="col-4">
        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm sinh viên" />
        </div>
        <div class="col-8 text-end">
        <form class="btn p-0 m-0" action="thongketheolop.php" method="GET">
                <input type="hidden" name="ma_lop" value="<?php echo $ma_lop; ?>">
                <button type="submit" class="btn btn-primary">Xem thống kê</button>
        </form>
        </div>
    </div>
    <div class="table-responsive" id="dynamic_dssv"></div>
</div>
<script>
    load_data(1);
    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchdssv.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_dssv').html(data);
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