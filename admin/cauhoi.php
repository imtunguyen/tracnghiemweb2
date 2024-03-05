<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');
include('../includes/functions.php');

thongBao();
if(isset($_GET['delete'])){
    deleteCauHoi($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa câu hỏi thành công';
    header('Location: cauhoi.php');
}
$result = getCauHoi($connect);
if ($result->num_rows >=0 ) {
?>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-7">
                <form action="../admin/cauhoi_search.php" method=post>
                <div class="input-group mb-3 ">
                    <input type="text" class="form-control" name="search" id="floatingInputGroup1" placeholder="Tìm kiếm câu hỏi">
                    <button type="submit" name="submit" class="input-group-text btn"><i class="bi bi-search"></i></button>
                </div>
                </form>
            </div>

            <div class="col-5  text-end">
                <a class="btn btn-success" href="../admin/cauhoi_add.php">
                    <i class="bi bi-plus-circle"></i> Thêm câu hỏi mới
                </a>
            </div>
        </div>
      

        <table class="table table-bordered table-striped table-hover nowrap align-middle text-center" style="width:100%">

            <thead>
                <tr>
                    <th class="col-1">STT</th>
                    <th class="col-5">Câu hỏi</th>
                    <th class="col-4">Sửa | Xóa</th>
                </tr>
            </thead>
            
            <?php $i=1; while($record = mysqli_fetch_assoc($result)){ 
                $modalID = "chiTietModal" . $i; // Tạo ID duy nhất cho mỗi modal
                $modalXoaID = "xoaModal" . $i;
                ?>
            <tbody data-bs-toggle="modal" data-bs-target="#<?php echo $modalID; ?>">
                <td>
                    <?php echo $i++;?>
                </td>
                <td><?php echo $record['noi_dung'];?></td>
                <td>
                    <div class=" btn-group" role="group">
                        <a class=" btn btn-warning mx-2 "
                            href="../admin/cauhoi_edit.php?id=<?php echo $record['ma_cau_hoi']; ?>">
                            <i class=" bi bi-pencil-square"></i> Sửa
                        </a>
                        <a class=" btn btn-danger mx-2 " data-bs-toggle="modal" data-bs-target="#<?php echo $modalXoaID; ?>">
                            <i class="bi bi-trash"></i> Xóa
                        </a>
                    </div>
                </td>
                <?php modalXoaCH($record['ma_cau_hoi'], $modalXoaID) ?> <!-- Truyền ID duy nhất vào hàm modal -->
            </tbody>

            <?php
                modalChitietCH($connect, $record['ma_cau_hoi'], $modalID); // Truyền ID duy nhất vào hàm modal
            } ?>
        </table>
    </div>
</div>
</div>

<?php
}
include('../includes/admin_footer.php');
?>