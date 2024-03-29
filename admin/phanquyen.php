<?php
include('../includes/config.php');
include('../includes/admin_header.php');
?>

<?php

if(isset($_GET['source'])){
  $source = $_GET['source'];
} 
else {
$source = '';
}
  
  switch($source) {
      
    case 'add': include('them_quyen.php'); break; 

    case 'update': include('sua_quyen.php'); break;

    default: include('view_all_quyen.php'); break;
  }
  ?>

<?php
include('../includes/admin_footer.php');
?>