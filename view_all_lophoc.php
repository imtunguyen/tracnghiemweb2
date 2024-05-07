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

?>

<div class="container">
  <div class="row mb-5">
    <div class="col-4">
      <input class="form-control mr-sm-2" type="search" placeholder="Nhập tên lớp" aria-label="Search" name="search_box" id="search_box">
    </div>
    <div class="col">
      <a class="btn btn-success" href="lophoc.php?lophoc=add">
          <i class="bi bi-plus-circle"></i> Thêm lớp học mới
      </a>
    </div>
</div>

<div class="row p-3 m-auto" id="dynamic_content">
</div>
</div>
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
