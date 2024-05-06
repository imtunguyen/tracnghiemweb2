<?php 
include('../includes/config.php');
include('../includes/admin_header.php');
include('../includes/database.php');
include('../includes/functions.php');
include('../includes/functionLopHoc.php');

$lophoc=getLopHoc($connect);
?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách Lớp học</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-7">
                <div class="form-group">
                    <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm lớp học" />
                </div>
            </div>
            <div class="col-5 text-end">
                <button class="btn btn-success" id="showFileBtn"><i class="bi bi-plus-circle"></i> Thêm lớp học mới</button>
            </div>
            
        </div>
        <div class="row p-3">
          <?php while($lophoc_record = $lophoc->fetch_assoc()){ ?>
        <div class="card ms-3 col-6" style="max-width: 250px;">
        <div class="card" >
            <button  class="card"><?php echo $lophoc_record['ten_lop'] ?></button>
            
                    <div class="card-body">
                        <div class="card-body">
                            <p class="card-text">Some quick example text </p>
                            <div class="d-flex">
                                <a type="button" class="btn btn-outline-primary me-1" style="width: auto; padding: 0 20px;white-space: nowrap;">Vào lớp</a>
                                <a type="button" class="btn btn-outline-danger">Xóa</a>
                            </div>
                        </div> 
            </div>
        </div>
        </div>  
        <?php } ?>
  </div>
        <div class="table-responsive" id="dynamic_dethi"></div>
     </div> 


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nhập mã mời: </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="" id="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary">Xác nhận</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchmh.php",
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
<?php 
  include('../includes/admin_footer.php');
?>
<!-- 
<div class="container">
    <div>Search</div>
  <div class="row p-3">
          <//?php while($monhoc_record = $result->fetch_assoc()){ ?>
        <div class="card ms-3 col-6" style="max-width: 500px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="images/hinh1.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><//?php echo $monhoc_record['ten_mon_hoc']?></h3>
                        <p class="card-text">Tên môn học: <//?php echo $monhoc_record['ten_mon_hoc']?>  <br> Tên giáo viên: </p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Tham gia lớp học
                        </button>
                    </div>
                </div>
            </div>
        </div>  
        <//?php } ?>
  </div>
</div>
-->