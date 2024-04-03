<?php

require_once('../includes/quyen_functions.php');
require_once('../includes/database.php');

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $user_name = getUserNameById($connect, $user_id);
    $role_name = getTenQuyen($connect, $user_id);
}

if(isset($_POST['submit'])) {
    $ten_quyen_update = $_POST['role'];
    $ma_quyen = getMaQuyenTheoTen($connect, $ten_quyen_update);

    updateUserRole($connect, $user_id, $ma_quyen);

    ?>
    <script>window.location.href = "nguoidung.php";</script>
    <?php
}

?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="col-12 text-center text-white">
            <h2>Sửa quyền</h2>
        </div>
    </div>   
    <div style="max-width: 400px; margin: 0 auto;">
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" disabled="disabled" value="<?php echo $user_name ?>">
            </div>
            <div class="form-group">
                <label for="role">Quyền</label>
                <select id="role" name="role" class="form-select">
                    <?php 
                    
                    $query = "select * from quyen where trang_thai = 1";
                    $result = mysqli_query($connect, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                        $ten_quyen = $row['ten_quyen'];
                        if($ten_quyen == $role_name) {
                            echo '<option value="'.$ten_quyen.'" selected>'.$ten_quyen.'</option>';
                        }
                        else {
                            echo '<option value="'.$ten_quyen.'">'.$ten_quyen.'</option>';
                        }
                    }

                    ?>
                    
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</div>