<?php
include('includes/header.php');
include('includes/database.php');
$userId = $_SESSION['userId'];
if(isset($_GET['thong_bao'])) {
  $thongBao = "Bạn đã làm bài thi rồi";
}

$sql_get_all_lop_of_user = "SELECT l.`ma_lop`, l.`trang_thai`, l.`ma_moi`, l.`ten_lop`
FROM `lop` l
JOIN `chi_tiet_lop` ctl ON ctl.`ma_lop` = l.`ma_lop`
JOIN `users` u ON u.`id` = ctl.`user_id`
Where u.id= $userId";
$res = mysqli_query($connect, $sql_get_all_lop_of_user);
?>

<div class="container">
  <div class="row mb-5">
    <div class="col-4">
      <input class="form-control mr-sm-2" type="search" placeholder="Nhập tên lớp hoặc tên giảng viên" aria-label="Search">
    </div>
    <div class="col-1">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>

    </div>
  </div>
  <div class="row p-3 gap-5 m-auto">
    <?php
    function random_pastel_color()
    {
      // Tạo một mã màu ngẫu nhiên nhạt
      $color = '#' . str_pad(dechex(mt_rand(0xaaaaff, 0xeeeeff)), 6, '0', STR_PAD_LEFT);
      return $color;
    }
    while ($row = mysqli_fetch_assoc($res)) {
      $background_color = random_pastel_color(); ?>
      <form class="col-4 m-0 p-0" style="max-width: 380px;" action="chitietlophoc.php" method="GET">
        <button class="btn py-0" style="width:100%;" type="submit">
          <div class="row d-flex align-items-center justify-content-center rounded-top" style="background-color:<?php echo $background_color; ?>;  height:80px;">
            <h3 class="text-center"><?php echo $row['ma_lop'] . "_" . $row['ten_lop']; ?></h3>
          </div>
          <div class="row pt-3  rounded-bottom" style="box-shadow: 0 2.4rem 4.8rem rgba(0, 0, 0, 0.075); ">
            <p>Trạng thái: <?php if ($row['trang_thai'] == 1) echo "Đang mở";
                            else echo "Đã đóng"; ?></p>
          <div>
          <input type="hidden" name="ma_lop" value="<?php echo $row['ma_lop']; ?>">
          <input type="hidden" name="ten_lop" value="<?php echo $row['ten_lop']; ?>">
          <input type="hidden" name="ma_moi" value="<?php echo $row['ma_moi']; ?>">
        </button>
      </form>
    <?php } ?>
  </div>
</div>
</div>

<script>
  let thongBao = "<?php echo $thongBao; ?>";
  console.log(thongBao);
  if(thongBao == "Bạn đã làm bài thi rồi") {
    toastr.error(thongBao);
  }
</script>
<?php
include('includes/footer.php');
?>