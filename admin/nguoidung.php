<?php
include('../includes/admin_header.php');
include('../includes/functions.php');
include('../includes/database.php');
?>


<?php 
    if(isset($_GET['view_roles']) && check($connect, $_SESSION['userId'], 'sua_nguoidung')) {
        include('user_role.php');
    }
    else {
        include('view_all_nguoidung.php');
    }
?>

<?php
include('../includes/admin_footer.php');
?>
