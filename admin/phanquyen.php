<?php
include('../includes/config.php');
include('../includes/admin_header.php');
include('../includes/functions.php');
include('../includes/database.php');
?>

<?php
$source = '';
if(isset($_GET['source'])){
  $source = $_GET['source'];
} 
if($source == 'add' && check($connect, $_SESSION['userId'], 'them_quyen')) {
  include('them_quyen.php');
}
if($source == 'update' && check($connect, $_SESSION['userId'], 'sua_quyen')) {
  include('sua_quyen.php');
}
else {
  include('view_all_quyen.php');
}
?>
<?php
include('../includes/admin_footer.php');
?>