<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');

if (isset($_SESSION['toastr'])) { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
toastr.success("<?php echo $_SESSION['toastr']; ?>");
</script>"
<?php
unset($_SESSION['toastr']);

}



if(isset($_GET['delete'])){
    if($stm = $connect->prepare('UPDATE mon_hoc SET trang_thai = 0 WHERE ma_mon_hoc = ?')){
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        $_SESSION['toastr'] = 'Xóa môn học thành công';
        header('Location: monhoc.php');
        $stm->close();
        die();
    }
}

if ($stm = $connect->prepare('SELECT * FROM mon_hoc WHERE trang_thai = 1')) {
$stm->execute();
$result = $stm->get_result();

if ($result->num_rows >0 ) {


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
            <div class="input-group mb-3 ">

    <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Tên môn học">
  <span class="input-group-text"><i class="bi bi-search"></i></span>
</div>

  
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
            <?php while($record = mysqli_fetch_assoc($result)){ ?>
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
            <?php } ?>
        </table>
    </div>
</div>
</div>
<?php
   } else 
   {
    echo 'No users found';
   }

    
   $stm->close();

} else {
   echo 'Could not prepare statement!';
}


include('../includes/admin_footer.php');
?>