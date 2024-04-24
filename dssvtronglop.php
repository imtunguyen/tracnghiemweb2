<div class="container">
    <h2 class="text-center mb-3">
        Đây là trang sinh viên
    </h2>
    <div class="row">
        <p>Giáo viên: </p>
    </div>
    <div class="row mb-3">
        <p>Mã lớp học: </p>
    </div>
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
            <button class="btn btn-primary" onclick="location.href='chitietlophoc.php?source=thongketheolop'">Xem thống kê</button>
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
