<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionMonHoc.php');
include('../includes/functions.php');
include('../includes/functionDeThi.php');

thongBao();
$monhoc = getMonHoc($connect);
if(isset($_GET['delete'])){
    deleteMonHoc($connect, $_GET['delete']);
    $_SESSION['toastr'] = 'Xóa đề thi thành công';
    header('Location: monhoc.php');
}

if(isset($_POST['submitted']) && isset($_POST['submit'])){
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $trang_thai = 1;
    $thoi_gian_lam_bai = $_POST['thoiGian'];
    $ten_de_thi = $_POST['tenDeThi'];
    $ma_nguoi_tao = 1;
    addDeThi($connect, $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao);
}

$dethi = getDeThi($connect);
?>
    <div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách đề thi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-7">
                <div class="form-group">
                    <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm môn học" />
                </div>
               
                    
            </div>
            <div class="col-5 text-end">
                <button class="btn btn-success" id="showFileBtn"><i class="bi bi-plus-circle"></i> Thêm đề thi mới</button>
            </div>
            
        </div>
        <div class="row p-3">
          <?php while($dethi_record = $dethi->fetch_assoc()){ ?>
        <div class="card ms-3 col-6" style="max-width: 500px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="../images/hinh1.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $dethi_record['ten_de_thi']?></h3>
                    </div>
                </div>
            </div>
        </div>  
        <?php } ?>
  </div>
        <div class="table-responsive" id="dynamic_dethi"></div>
     </div> 
     <div class="overlay" id="overlay">
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 600px; height: 400px">
                <form method="post"> 
                    <!-- Thêm tham số submitted vào URL -->
                    <input type="hidden" name="submitted" value="1">
                    <label for=""><h4>THÊM ĐỀ THI</h4></label><hr>
                    <label for="">Nhập tên đề thi</label>
                    <input type="text" class="form-control" name="tenDeThi"><br>
                    <label for="">Nhập thời gian làm bài:</label>
                    <input type="number" class="form-control" name="thoiGian"><br>
                    <label for="">Chọn môn học:</label>
                    <select class="form-select" name="ma_mon_hoc">
                        <option disabled selected>--Chọn môn học--</option>
                        <?php while($record = $monhoc->fetch_assoc()){?>
                            <option value="<?php echo $record['ma_mon_hoc'];?>"><?php echo $record['ten_mon_hoc'];?></option>
                        <?php } ?>
                    </select><br>
                    <div class="text-end">
                        <button class="btn btn-secondary" type="button" onclick="cancelForm()">Hủy</button>
                        <button class="btn btn-primary" type="submit" name="submit">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function cancelForm() {
        var overlay = document.getElementById('overlay');
        overlay.style.display = 'none';
    }
    document.getElementById('showFileBtn').addEventListener('click', function(){
        var overlay = document.getElementById('overlay');
        overlay.style.display = 'block';
    });
</script>
<!-- <script>
$(document).ready(function(){
    load_data(1);

    function load_data(page, query = '')
    {
        $.ajax({
            url:"fetchdethi.php",
            method:"POST",
            data:{page:page, query:query},
            success:function(data)
            {
                $('#dynamic_dethi').html(data);
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
</script> -->
<?php 
    include('../includes/admin_footer.php');
?>
