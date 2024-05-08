<?php 
ob_start();
include('includes/header.php');
include('includes/database.php');
?>
<?php

$source = '';

if(isset($_GET['lophoc'])){
  $source = $_GET['lophoc'];
} 

switch($source) {
  case "add": if(check($connect, $_SESSION['userId'], 'them_lophoc')){include('lophoc_add.php');} break;
  case "edit": if(check($connect, $_SESSION['userId'], 'sua_lophoc')) {include('lophoc_edit.php');} break;
  default: include('view_all_lophoc.php'); break;
}

?>
<?php 
include('includes/footer.php');
?>