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
                <a class="btn btn-success" href="../admin/monhoc_add.php">
                    <i class="bi bi-plus-circle"></i> Thêm câu hỏi mới
                </a>
            </div>
        </div>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">

            <thead>
                <tr>
                    <th class="col-1">STT</th>
                    <th class="col-4">Câu hỏi</th>
                    <th class="col-3">Xem chi tiết</th>
                    <th class="col-4">Sửa | Xóa</th>

                </tr>
            </thead>
            <?php
        if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $result = searchCauHoi($connect, $search);
    $count = mysqli_num_rows($result);
    if($count ==0){
        echo "<h1>Không có kết quả tìm kiếm</h1>";
    }
    else{
             $i=1; while($record = mysqli_fetch_assoc($result)){ ?>
            <tbody>
                <td>
                    <?php echo $i++;?>
                </td>
                <td><?php echo $record['noi_dung'];?></td>
                <td>
                    <a class=" btn btn-info mx-2"
                        href="../admin/cauhoi_edit.php?id=<?php echo $record['ma_cau_hoi']; ?>">
                        <i class="bi bi-gear-fill"></i> Xem chi tiết
                    </a>
                </td>
                <td>
                    <div class="w-75 btn-group" role="group">
                        <a class=" btn btn-primary mx-2"
                            href="../admin/cauhoi_edit.php?id=<?php echo $record['ma_cau_hoi']; ?>">
                            <i class=" bi bi-pencil-square"></i> Sửa
                        </a>
                        <a class=" btn btn-danger mx-2" 
                            href="../admin/cauhoi.php?delete=<?php echo $record['ma_cau_hoi']; ?>">
                            <i class="bi bi-trash"></i> Xóa
                        </a>
                    </div>
                </td>

            </tbody>
            <?php } 
        }
    }?>
        </table>
    </div>
</div>
</div>
<?php
} 
include('../includes/admin_footer.php');
?>