<?php
include('../includes/admin_header.php');
?>


<?php 
    if(isset($_GET['view_roles'])) {
        include('user_role.php');
    }
    else {
        include('view_all_nguoidung.php');
    }
?>

<?php
include('../includes/admin_footer.php');
?>
