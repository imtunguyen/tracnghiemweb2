<?php
include('./includes/header.php');
include('./includes/database.php');
if (!(isset($_SESSION['username']) && isset($_SESSION['userId']) && isset($_SESSION['permissionId']))) {
    header("Location: dangnhap.php");
}
?>
<?php
if(isset($_GET['source'])){
  $source = $_GET['source'];
} 
else {
  $source = '';
}
  switch($source) {
    case 'dssvtronglop': include('dssvtronglop.php'); break; 

    case 'thongketheolop': include('thongketheolop.php'); break;

    default: include('dethitronglop.php'); break;
  }
?>