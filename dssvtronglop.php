<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']) && isset($_SESSION['permissionId']))) {
    header("Location: dangnhap.php");
}
if(!(isset($_GET['ma_lop']) && isset($_GET['ten_lop']))) {
    header("Location: lophoc.php");
} else {
  $ma_lop = $_GET['ma_lop'];
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
            <input type="text" class="form-control d-flex" placeholder="Nhập tên sinh viên">
        </div>
        <div class="col-2">
            <button class="btn btn-primary">Tìm kiếm</button>
        </div>
        <div class="col-6 text-end">
        <form class="btn p-0 m-0" action="thongketheolop.php" method="GET">
                <input type="hidden" name="ma_lop" value="<?php echo $ma_lop; ?>">
                <button type="submit" class="btn btn-primary">Xem thống kê</button>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT 
               users.id, 
               users.ho_va_ten, 
               users.ngay_sinh, 
               users.gioi_tinh, 
               users.email
           FROM 
               `users`
           JOIN 
               `chi_tiet_lop` ctl ON users.id = ctl.user_id
           WHERE 
               ctl.ma_lop = 1 AND users.trang_thai = 1";
            $result = mysqli_query($connect, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['id'] . '-' . $row['ho_va_ten'] . "</td>
                <td>" . ($row['gioi_tinh'] == 1 ? 'Nam' : 'Nữ') . "</td>
                <td>" . $row['ngay_sinh'] . "</td>
                <td>" . $row['email'] . "</td>
              </tr>";
            }
            ?>

        </tbody>
    </table>
</div>
