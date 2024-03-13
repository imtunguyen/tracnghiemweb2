<?php 
include('includes/config.php');
include('includes/header.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/functionMonHoc.php');

$result = getMonHoc($connect);

?>

<div class="container">
    <div>Search</div>
    <div class="row p-3">
        <?php while($monhoc_record = $result->fetch_assoc()){ ?>
        <div class="card mb-3 col-6" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="images/hinh1.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $monhoc_record['ten_mon_hoc']?></h3>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Tham gia lớp
                        </button>
                    </div>
                </div>
            </div>
        </div>  
       <?php } ?>

    </div>
    <!-- Modal -->
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
<?php 
include('includes/footer.php');
?>