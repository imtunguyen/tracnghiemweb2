<?php

function thongBao(){
    if (isset($_SESSION['toastr'])) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
        toastr.success("<?php echo $_SESSION['toastr']; ?>");
        </script>"
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

function check($connect, $id, $ten_chuc_nang) {
    $query = "select * from users u 
    join chi_tiet_quyen ctq on u.id = ctq.user_id
    join quyen q on q.ma_quyen = ctq.ma_quyen 
    join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = q.ma_quyen
    join chuc_nang cn on ctcn.ma_chuc_nang = cn.ma_chuc_nang
    where ctcn.cho_phep = 1 and ctq.cho_phep = 1 and u.id = $id and cn.ten_chuc_nang = '{$ten_chuc_nang}';";

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