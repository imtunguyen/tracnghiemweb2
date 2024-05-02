<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']) && isset($_SESSION['permissionId']))) {
  header("Location: dangnhap.php");
}
if (!(isset($_GET['ma_lop']) && isset($_GET['ten_lop']) && isset($_GET['ma_moi']))) {
  header("Location: lophoc.php");
} else {
  $ma_lop = $_GET['ma_lop'];
  $ten_lop = $_GET['ten_lop'];
  $ma_moi = $_GET['ma_moi'];
}
?>

<?php
$ma_lop = $_GET['ma_lop'];
?>
<div class="container">
  <h2 class="text-center mb-3">
    <?php echo $ma_lop . "_" . $ten_lop ?>
  </h2>
  <div class="row">
    <p>Giáo viên: </p>
  </div>
  <div class="row mb-3">
    <p>Mã mời: <?php echo $ma_moi ?></p>
  </div>
  <h3 class="text-center mb-3">
    Danh sách đề thi trong lớp
  </h3>
  <div class="row mb-2">
    <div class="col-4">
      <input type="text" class="form-control d-flex" placeholder="Nhập tên đề thi">
    </div>
    <div class="col-2">
      <button class="btn btn-primary">Tìm kiếm</button>
    </div>
    <div class="col-6 text-end">
      <button class="btn btn-primary">Thêm đề thi vào lớp</button>
      <form class="btn p-0 m-0" action="dssvtronglop.php" method="GET">
        <input type="hidden" name="ma_lop" value="<?php echo $ma_lop; ?>">
        <input type="hidden" name="ten_lop" value="<?php echo $ten_lop; ?>">
        <button type="submit" class="btn btn-primary">Xem DSSV</button>
      </form>

    </div>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>STT</th>
        <th>Đề thi</th>
        <th>Môn học</th>
        <th>Thời gian bắt đầu</th>
        <th>Thời gian kết thúc</th>
        <th>Thời gian làm bài</th>
        <th>Chi tiết</th>
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
      while ($row = mysqli_fetch_assoc($result)) {
        $stt += 1;
        echo "<tr>
                <td>" . $stt . "</td>
                <td>" . $row['ten_de_thi'] . "</td>
                <td>" . $row['ten_mon_hoc'] . "</td>
                <td>" . $row['tg_bat_dau'] . "</td>
                <td>" . $row['tg_ket_thuc'] . "</td>
                <td>" . $row['thoi_gian_lam_bai'] . "</td>
                <td>Xem</td>
              </tr>";
      }
      ?>

    </tbody>
  </table>
</div>