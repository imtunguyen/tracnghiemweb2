<?php
$userId = $_SESSION['userId'];
if(isset($_GET['thong_bao'])) {
  $thongBao = "Bạn đã làm bài thi rồi";
}

if(isset($_GET['delete']) && check($connect, $_SESSION['userId'], 'xoa_lophoc')) {
  $id = $_GET['delete'];
  $query = "UPDATE lop ";
  $query .= "SET trang_thai = 0 WHERE ma_lop = $id ";

  $create_query = mysqli_query($connect, $query); 
  ?>
  <script>window.location.href = "lophoc.php";</script>
  <?php
}

function checkExistedMaMoi($connect, $ma_moi) {
  $query = "SELECT * FROM lop
                WHERE trang_thai = 1 AND ma_moi = '{$ma_moi}'";
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

function checkExisted($connect, $ma_lop, $user_id) {
  $query = "SELECT * FROM chi_tiet_lop
                WHERE trang_thai = 1 AND user_id = $user_id and ma_lop = $ma_lop";
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

function getIdByMaMoi($connect, $ma_moi) {
  $id = "";
  $query = "SELECT ma_lop FROM lop WHERE trang_thai = 1 AND ma_moi = '{$ma_moi}'";
  $result = mysqli_query($connect, $query);
  while($row = mysqli_fetch_assoc($result)) {
    $id = $row['ma_lop'];
  }
  return $id;
}

if(isset($_POST['ma_moi']) ) {
  $ma_moi = $_POST['ma_moi'];
  $ma_lop = checkExistedMaMoi($connect, $ma_moi) ? getIdByMaMoi($connect, $ma_moi) : "none";
  if($ma_lop != "none" && checkExisted($connect, $ma_lop, $userId) == false) {
    $query2 = "INSERT INTO chi_tiet_lop(user_id, ma_lop, trang_thai) ";
    $query2 .= "VALUES($userId, $ma_lop, 1)"; 
    $result = mysqli_query($connect, $query2);
    header('Location: lophoc.php');
  }
  else {?>
    <script>toastr.error("Kiểm tra lại mã mời của bạn!");</script>
    <?php
  }
}

?>

<div class="container">
  <div class="row mb-5">
    <div class="col-4">
      <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm theo tên lớp" aria-label="Search" name="search_box" id="search_box">
    </div>
    <?php if(check($connect, $_SESSION['userId'], 'them_lophoc')){echo '
    <div class="col">
      <a class="btn btn-success" href="lophoc.php?lophoc=add">
          <i class="bi bi-plus-circle"></i> Thêm lớp học mới
      </a>
    </div>';} ?>
    <?php if(check($connect, $_SESSION['userId'], 'lam_baithi')){echo '<div class="col">
      <form action="" method="post">
        <input type="text" name="ma_moi">
        <input type="submit" value="Tham Gia Lớp Học">
        </form>
    </div>';} ?>
    
</div>

<div class="row p-3 m-auto" id="dynamic_content">
</div>
  

<script>
  let thongBao = "<?php echo $thongBao; ?>";
  console.log(thongBao);
  if(thongBao == "Bạn đã làm bài thi rồi") {
    toastr.error(thongBao);
  }
</script>
<?php
include('includes/footer.php');
?>

<script>
  $(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchlophoc.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
            $('#dynamic_content').html(data);
            }
        });
    }

    $(document).on('click', '.page-link', function(){
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
    });

    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data(1, query);
    });

    }); 

  
</script>