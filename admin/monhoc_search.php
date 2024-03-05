<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionMonHoc.php');
include('../includes/functions.php');

thongBao();

if(isset($_GET['delete'])){
    deleteMonHoc($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa môn học thành công';
    header('Location: monhoc.php');
}
$result = getMonHoc($connect);
if ($result->num_rows >=0 ) {
?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách môn học</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-7">
                <form action="" method=post>
                <div class="input-group mb-3 ">
                    <input type="text" class="form-control" name="search" id="floatingInputGroup1" placeholder="Tìm kiếm môn học">
                    <button type="submit" name="submit" class="input-group-text btn"><i class="bi bi-search"></i></button>
                </div>
                </form>
            </div>

            <div class="col-5  text-end">
                <a class="btn btn-success" href="../admin/monhoc_add.php">
                    <i class="bi bi-plus-circle"></i> Thêm môn học mới
                </a>
            </div>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên môn học</th>
                    <th>Sửa | Xóa</th>
                </tr>
            </thead>
        <?php
        if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $result = searchMonHoc( $connect, $search);
    $count = mysqli_num_rows($result);
    if($count ==0){
        echo "<h1>Tên môn học không tồn tại</h1>";
    }
    else{
         while($record = mysqli_fetch_assoc($result)){ ?>
            <tbody>
                <td><?php echo $record['ma_mon_hoc'];?> </td>
                <td><?php echo $record['ten_mon_hoc'];?></td>
                <td>
                    <div class="w-75 btn-group" role="group">
                        <a class=" btn btn-primary mx-2"
                            href="../admin/monhoc_edit.php?id=<?php echo $record['ma_mon_hoc']; ?>">
                            <i class=" bi bi-pencil-square"></i> Edit
                        </a>
                        <a class=" btn btn-danger mx-2" 
                            href="../admin/monhoc.php?delete=<?php echo $record['ma_mon_hoc']; ?>">
                            <i class="bi bi-trash"></i> Delete
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