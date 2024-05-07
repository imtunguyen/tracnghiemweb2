<?php
function thongBao(){
    if (isset($_SESSION['toastr'])) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
        toastr.success("<?php echo $_SESSION['toastr']; ?>");
        </script>
        <?php
        unset($_SESSION['toastr']);
    }
}

function secure() {
    if(!isset($_SESSION['id'])){
        $_SESSION['message'] = "Please login first to view this page.";
        header('Location: /');
        die();
    }
}
function randomColor(){
    $red = mt_rand(180,230);
    $green = mt_rand(180,230);
    $blue = mt_rand(180,230);
    $color = sprintf('#%02X%02X%02X', $red, $green, $blue);
    return $color;
}
function check($connect, $id, $ten_chuc_nang) {
    $query = "select * from users u 
    join chi_tiet_quyen ctq on u.id = ctq.user_id
    join quyen q on q.ma_quyen = ctq.ma_quyen 
    join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = q.ma_quyen
    join chuc_nang cn on ctcn.ma_chuc_nang = cn.ma_chuc_nang
    where ctcn.cho_phep = 1 and ctq.cho_phep = 1 and u.id = $id and cn.ten_chuc_nang = '{$ten_chuc_nang}' and q.trang_thai = 1 and cn.trang_thai = 1;";

    $rowcount = 0;
    if ($result = mysqli_query($connect, $query))
    {
        $rowcount=mysqli_num_rows($result);
    }
    if($rowcount > 0) {
        return true;
    }
    else {
        return false;
    }
}

function getQuyen($connect, $id){
    $query = "SELECT q.ten_quyen FROM users u 
    JOIN chi_tiet_quyen ctq ON u.id = ctq.user_id
    JOIN quyen q ON q.ma_quyen = ctq.ma_quyen 
    WHERE ctq.cho_phep = 1 AND u.id = $id;";
    $select_roles = mysqli_query($connect, $query);  
    $roles = array();
    while($row = mysqli_fetch_assoc($select_roles)) {
        $roles[] = $row['ten_quyen'];
    }
    return $roles;
}

function getChucNangCuaNguoiDung($connect, $id) {
    $chuc_nang = "";
    $query = "select cn.* from users u 
    join chi_tiet_quyen ctq on u.id = ctq.user_id
    join quyen q on q.ma_quyen = ctq.ma_quyen 
    join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = q.ma_quyen
    join chuc_nang cn on ctcn.ma_chuc_nang = cn.ma_chuc_nang
    where ctcn.cho_phep = 1 and ctq.cho_phep = 1 and q.trang_thai = 1 and cn.trang_thai = 1 and  u.id = $id;";
    $select_roles = mysqli_query($connect, $query);  
    while($row = mysqli_fetch_assoc($select_roles)) {
        $chuc_nang .= $row['ten_chuc_nang'];
        $chuc_nang .= ", ";
    }
    return $chuc_nang;
}

function getMaQuyenCuaNguoiDung($connect, $id) {
    $role_id = "";
    $query = "select ma_quyen from chi_tiet_quyen where user_id = $id and cho_phep = 1;";
    $select_roles = mysqli_query($connect, $query);  
    while($row = mysqli_fetch_assoc($select_roles)) {
        $role_id = $row['ma_quyen'];
    }
    return $role_id;
}