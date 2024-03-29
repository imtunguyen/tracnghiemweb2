<?php 

require_once('../includes/quyen_functions.php');
require_once('../includes/database.php');


if(isset($_GET['ma_quyen'])){
    $ma_quyen =  $_GET['ma_quyen'];
}

$error = "";

if(isset($_POST['update_quyen'])) {

    foreach (['nguoidung', 'cauhoi', 'quyen', 'dethi', 'lophoc', 'monhoc'] as $permissionCategory) {

        (isset($_POST["them_$permissionCategory"]) && $_POST["them_$permissionCategory"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "them_$permissionCategory"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "them_$permissionCategory"), 0);
        (isset($_POST["sua_$permissionCategory"]) && $_POST["sua_$permissionCategory"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "sua_$permissionCategory"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "sua_$permissionCategory"), 0);
        (isset($_POST["xoa_$permissionCategory"]) && $_POST["xoa_$permissionCategory"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "xoa_$permissionCategory"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "xoa_$permissionCategory"), 0);
    
    }

        (isset($_POST["xem_thongke"]) && $_POST["xem_thongke"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "xem_thongke"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "xem_thongke"), 0);
        (isset($_POST["vao_lophoc"]) && $_POST["vao_lophoc"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "vao_lophoc"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "vao_lophoc"), 0);
        (isset($_POST["lam_baithi"]) && $_POST["lam_baithi"] === 'on') ? updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "lam_baithi"), 1) : updateChiTietChucNang($connect, $ma_quyen, getIdTheoTen($connect, "lam_baithi"), 0);
      
        ?>

        <script>window.location.href = "phanquyen.php";</script>

        <?php
}

?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Sửa Quyền</h2>
            </div>
        </div>    
    </div>
    <div class="container-fluid">
        <form action="" method="post">
            <table class="table table-bordered table-striped align-middle text-center">
                <tr>
                <div class="mb-3 mt-3">
                    <input type="text" class="form-control" id="ten_quyen"  name = "ten_quyen" placeholder="Nhập Tên Quyền" aria-describedby="error_input" value = '<?php echo getNameById($connect, $ma_quyen); ?>' disabled="disabled">
                    <div id="error_input" class="form-text" style="color: red;"><?php echo $error ?></div>
                </div>
                </tr>
                <tr>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="xem_thongke" name="xem_thongke"  <?php if(checkExistedCheckBox($connect, $ma_quyen, "xem_thongke")) { echo "checked"; } ?> >
                        <label class="form-check-label" for="xem_thongke">Xem Thống Kê</label>
                    </div>
                </tr>
                <tr>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="vao_lophoc" name="vao_lophoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "vao_lophoc")) { echo "checked"; } ?> >
                        <label class="form-check-label" for="vao_lophoc">Vào Lớp Học</label>
                    </div>
                </tr>
                <tr>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="lam_baithi" name="lam_baithi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "lam_baithi")) { echo "checked"; } ?> >
                        <label class="form-check-label" for="lam_baithi">Làm Bài Thi</label>
                    </div>
                </tr>
                <tr>
                    <th>Object</th>
                    <th>Thêm</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
                <tr>
                    <td>Người dùng</td>
                    <td><input type="checkbox" id="them_nguoidung" name="them_nguoidung"  <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_nguoidung")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_nguoidung" name="sua_nguoidung" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_nguoidung")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_nguoidung" name="xoa_nguoidung" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_nguoidung")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td>Câu hỏi & Trả lời</td>
                    <td><input type="checkbox" id="them_cauhoi" name="them_cauhoi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_cauhoi")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_cauhoi" name="sua_cauhoi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_cauhoi")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_cauhoi" name="xoa_cauhoi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_cauhoi")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td>Quyền</td>
                    <td><input type="checkbox" id="them_quyen" name="them_quyen" <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_quyen")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_quyen" name="sua_quyen" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_quyen")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_quyen" name="xoa_quyen" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_quyen")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td>Đề thi</td>
                    <td><input type="checkbox" id="them_dethi" name="them_dethi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_dethi")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_dethi" name="sua_dethi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_dethi")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_dethi" name="xoa_dethi" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_dethi")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td>Lớp Học</td>
                    <td><input type="checkbox" id="them_lophoc" name="them_lophoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_lophoc")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_lophoc" name="sua_lophoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_lophoc")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_lophoc" name="xoa_lophoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_lophoc")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td>Môn học</td>
                    <td><input type="checkbox" id="them_monhoc" name="them_monhoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "them_monhoc")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="sua_monhoc" name="sua_monhoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "sua_monhoc")) { echo "checked"; } ?> ></td>
                    <td><input type="checkbox" id="xoa_monhoc" name="xoa_monhoc" <?php if(checkExistedCheckBox($connect, $ma_quyen, "xoa_monhoc")) { echo "checked"; } ?> ></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Save" name="update_quyen"></td>
                </tr>
            </table>

        </form>
    </div>
</div>
<script>