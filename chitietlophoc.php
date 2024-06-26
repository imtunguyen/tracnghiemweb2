<?php
include('./includes/header.php');
include('./includes/database.php');

if (!(isset($_SESSION['userId']))) {
  header("Location: dangnhap.php");
}
if (!(isset($_GET['ma_lop']) && isset($_GET['ten_lop']) && isset($_GET['ma_moi']))) {
  header("Location: lophoc.php");
} else {
  $ma_lop = $_GET['ma_lop'];
  $_SESSION['ma_lop'] = $ma_lop;
  $ten_lop = $_GET['ten_lop'];
  $ma_moi = $_GET['ma_moi'];
  $_SESSION['ten_lop']=$ten_lop;
  $_SESSION['ma_moi']=$ma_moi;
}
if(isset($_GET['thong_bao'])) {
  $thong_bao =  $_GET['thong_bao'];
  if($thong_bao != "") {
    echo "<script>toastr.success('Thêm đề thi vào lớp thành công');</script>";
}
}
if(isset($_GET['baithirong'])) {
  $thong_bao_bai_thi_rong =  $_GET['baithirong'];
  if($thong_bao_bai_thi_rong != "") {
    echo "<script>toastr.error('Bài thi này rỗng, xin chọn bài thi khác!');</script>";
}
}
if(isset($_GET['thong_bao_da_lam_bai'])) {
  $thong_bao_da_lam_bai =  $_GET['thong_bao_da_lam_bai'];
  if($thong_bao_da_lam_bai != "") {
    echo "<script>toastr.error('Bạn đã làm đề thi này rồi');</script>";
}
}

if(isset($_GET['thong_bao_update'])) {
  $thong_bao_update =  $_GET['thong_bao_update'];
  if($thong_bao_update != "") {
    echo "<script>toastr.success('Cập nhật đề thi thành công');</script>";
}
}

if(isset($_GET['thong_bao_chua_toi_gio_lam_bai'])) {
  $thong_bao_ctglb = $_GET['thong_bao_chua_toi_gio_lam_bai'];
  if($thong_bao_ctglb != "") {
    echo "<script>toastr.error('Chưa tới giờ làm bài');</script>";
}
}
if(isset($_GET['thong_bao_het_gio_gio_lam_bai'])) {
  $thong_bao_hglb = $_GET['thong_bao_het_gio_gio_lam_bai'];
  if($thong_bao_hglb != "") {
    echo "<script>toastr.error('Đã quá giờ làm bài');</script>";
}
}

if(isset($_GET['thong_bao_delete'])) {
  $thong_bao_delete = $_GET['thong_bao_delete'];
  if($thong_bao_delete != "") {
    echo "<script>toastr.success('Xóa thành công');</script>";
}
}
?>

<div class="container">
  <h2 class="text-center mb-3">
    <?php echo $ma_lop . "_" . $ten_lop ?>
  </h2>
  <div class="row">
    <?php
      $sql_ten_gv = "SELECT users.ho_va_ten
      FROM users
      JOIN chi_tiet_lop ctl ON ctl.user_id = users.id
      JOIN chi_tiet_quyen ctq on ctq.user_id = users.id
      Join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = ctq.ma_quyen  
      Where ctcn.ma_chuc_nang = 13 AND ctl.ma_lop = $ma_lop and ctcn.cho_phep = 1";
      $result_ten_gv = mysqli_query($connect, $sql_ten_gv);
      $ten_gv = "";
      $row_gv = mysqli_fetch_assoc($result_ten_gv);
      $ten_gv .= $row_gv['ho_va_ten'];
    ?>
    <p style="font-weight: bold;">Giáo viên: <?php echo $ten_gv; ?></p>
  </div>
  <div class="row mb-3">
    <p style="font-weight: bold;">Mã mời: <?php if(check($connect, $_SESSION['userId'], 'them_lophoc')) {echo $ma_moi;} ?></p>
  </div>
  <h3 class="text-center mb-3">
    Danh sách đề thi trong lớp
  </h3>
  <div class="row mb-2">
    <div class="col-4">
      <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm đề thi" />

    </div>
    <div class="col-8 text-end">
      <?php 
      if(check($connect, $_SESSION['userId'], 'them_dethi')) {
        echo
      '<form class="btn p-0 m-0" action="baithi_add.php" method="POST">
      <input type="hidden" name="ma_lop" value="' .$ma_lop . '">
      <button type="submit" class="btn btn-primary">Thêm đề thi vào lớp</button>
      </form>';
      }
      ?>
      <?php 
      if(check($connect, $_SESSION['userId'], 'xem_thongke')) {
        echo
      '
      <form class="btn p-0 m-0" action="dssvtronglop.php" method="GET">
        <input type="hidden" name="ma_lop" value="' .$ma_lop . '">
        <input type="hidden" name="ten_lop" value="' .$ten_lop . '">

        <button type="submit" class="btn btn-primary">Xem DSSV</button>
      </form>';
      }
      ?>

    </div>
  </div>
  <div class="table-responsive" id="dynamic_chitietlop"></div>
  
</div>

<script>
    load_data(1);
    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchchitietlophoc.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_chitietlop').html(data);
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

