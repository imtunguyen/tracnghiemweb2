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
}
if(isset($_GET['thong_bao'])) {
  $thong_bao =  $_GET['thong_bao'];
  if($thong_bao != "") {
    echo "<script>toastr.success('Thêm đề thi vào lớp thành công');</script>";
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
      JOIN chi_tiet_quyen ctq ON ctq.user_id = users.id
      Where ctq.ma_quyen = 2 AND ctl.ma_lop = $ma_lop";
      $result_ten_gv = mysqli_query($connect, $sql_ten_gv);
      $ten_gv = "";
      $count = 0;
      while($row_gv = mysqli_fetch_assoc($result_ten_gv)) {
          if ($count > 0) {
            $ten_gv .= " - ";
          }
          $ten_gv .= $row_gv['ho_va_ten'];
          $count++;
      }
    ?>
    <p >Giáo viên: <?php echo $ten_gv; ?></p>
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
    <div class="col-6 text-end">
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
  <table class="table">
    <thead>
      <tr>
        <th>STT</th>
        <th>Đề thi</th>
        <th>Môn học</th>
        <th>Thời gian bắt đầu</th>
        <th>Thời gian kết thúc</th>
        <th>Thời gian làm bài</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT bt.ma_de_thi, bt.ma_bai_thi, bt.tg_bat_dau, bt.tg_ket_thuc, dt.thoi_gian_lam_bai, dt.ten_de_thi, dt.ma_mon_hoc, mh.ten_mon_hoc
            FROM bai_thi bt
            JOIN de_thi dt ON bt.ma_de_thi = dt.ma_de_thi JOIN mon_hoc mh ON mh.ma_mon_hoc = dt.ma_mon_hoc
            WHERE bt.ma_lop = 1 AND bt.trang_thai = 1
            ";
      $result = mysqli_query($connect, $sql);
      $stt = 0;
      $user_id = $_SESSION['userId'];
      while ($row = mysqli_fetch_assoc($result)) {
        $stt += 1;
        echo "<tr>
                <td>" . $stt . "</td>
                <td>" . $row['ten_de_thi'] . "</td>
                <td>" . $row['ten_mon_hoc'] . "</td>
                <td>" . $row['tg_bat_dau'] . "</td>
                <td>" . $row['tg_ket_thuc'] . "</td>
                <td>" . $row['thoi_gian_lam_bai'] . "</td>
                <td>
                <div class='w-75 btn-group' role='group'>";
        
                if(check($connect, $_SESSION['userId'], 'sua_dethi')) {

                echo
                "<form action='baithi_sua.php' method='post'>
                  <input type='hidden' name='ma_lop' value='$ma_lop'>
                  <input type='hidden' name='ma_bai_thi' value='" . $row['ma_bai_thi'] . "'>
                  <button id='btnSubmit1' class='btn btn-success mx-2' type='submit'>Sửa</button>
                </form>";
                }
                
                if(check($connect, $_SESSION['userId'], 'xoa_dethi')) {
                echo "
                <form action='baithi_xoa.php' method='post'>
                  <input type='hidden' name='ma_bai_thi' value='" . $row['ma_bai_thi'] . "'>
                  <button id='btnSubmit2' class='btn btn-danger mx-2' type='submit'>Xóa</button>
                </form>";
                }
                echo "
                </div>";
                
                if(check($connect, $_SESSION['userId'], 'lam_baithi')) {
                echo  "
                <form action='lambai.php' method='post'>
                  <input type='hidden' name='ma_lop' value='$ma_lop'>
                  <input type='hidden' name='ma_bai_thi' value='" . $row['ma_bai_thi'] . "'>
                  <input type='hidden' name='ma_de_thi' value='" . $row['ma_de_thi'] . "'>
                  <input type='hidden' name='thoi_gian_lam_bai' value='" . $row['thoi_gian_lam_bai'] . "'>
                  <input type='hidden' name='ten_de_thi' value='" . $row['ten_de_thi'] . "'>
                  <button id='btnSubmit' class='btn btn-primary' type='submit'>Làm bài</button>
                </form>";
                }
                
        echo "
              </td>
              </tr>";
      }
      ?>

    </tbody>
  </table>
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

