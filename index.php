<?php 

if(isset($_SESSION['userId'])) {
  include('trangchu.php');
}
else {
  include('dangnhap.php');
}

?>
    