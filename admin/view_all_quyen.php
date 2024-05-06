<?php 

require_once('../includes/quyen_functions.php');
require_once('../includes/database.php');
require_once('../includes/functions.php');

if(isset($_GET['delete']) && check($connect, $_SESSION['userId'], 'xoa_quyen')) {
    $id = $_GET['delete'];
        deleteQuyen($connect, $id);
    ?>
    <script>window.location.href = "phanquyen.php";</script>
    <?php
}

?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách quyền</h2>
            </div>
        </div>    
        <button><a href="phanquyen.php?source=add">ADD</a></button>
    </div>
    <table class="table table-bordered table-striped align-middle text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Quyền</th>
                <th>Chức Năng</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <?php 
        $query = "select * from quyen where trang_thai = 1;";
        $select_roles = mysqli_query($connect, $query);  
        while($row = mysqli_fetch_assoc($select_roles)) {
            $role_id  = $row['ma_quyen'];
            $role_name = $row['ten_quyen'];

            $query = 'SELECT cn.ten_chuc_nang AS "chuc_nang" FROM quyen q JOIN chi_tiet_chuc_nang ctcn ON ctcn.ma_quyen = q.ma_quyen JOIN chuc_nang cn ON cn.ma_chuc_nang = ctcn.ma_chuc_nang WHERE cho_phep = 1 AND q.ma_quyen = '.$role_id;
            $chuc_nang = "";
            $select_chucnang = mysqli_query($connect, $query);  
            while($row = mysqli_fetch_assoc($select_chucnang)) {
                $chuc_nang .= $row['chuc_nang'];
                $chuc_nang .= ", ";
            }

            echo '

            <tr>
                <td>'.$role_id.'</td>
                <td>'.$role_name.'</td>
                <td>'.$chuc_nang.'</td>
                <td><a style="color: green;" href="phanquyen.php?source=update&ma_quyen='.$role_id.'">Update</a></td>
                <td><a class ="delete_role" style="color: red;" href="phanquyen.php?delete='.$role_id.'" id="'.$role_name.'">Delete</a></td>
            </tr>

            ';
        }

        ?>
    </table>
</div>

<script>
$(document).ready(function() {
  $("a.delete_role").on("click", function(event) {
    var id = $(this).attr('id');
    if (confirm("Bạn Muốn Xóa Quyền " + id + "?")) {
    } else {
      event.preventDefault(); 
    }
  });
});
</script>