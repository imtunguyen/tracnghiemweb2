<<<<<<< HEAD:admin/dethi_edit.php
<?php
ob_start();
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionMonHoc.php');
include('../includes/functionDeThi.php');

$result = getMonHoc($connect);
if (isset($_POST['ten_de_thi']) && isset($_POST['thoi_gian_lam_bai']) && isset($_POST['ma_mon_hoc'])) {
    $ten_de_thi = trim($_POST['ten_de_thi']);
    $thoi_gian_lam_bai = trim($_POST['thoi_gian_lam_bai']);
    $ma_mon_hoc = trim($_POST['ma_mon_hoc']);
    $trang_thai = 1;
    $ma_nguoi_tao = 1;
    addDeThi($connect, $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao);
    $_SESSION['toastr'] = 'Sửa đề thi thành công';
    header('Location: dethi.php');
    
}

ob_end_flush();
if(isset($_GET['id'])){
    $ma_de_thi = $_GET['id'];
    $dethi = getDeThibyID($connect, $ma_de_thi);
    $dethi_record = $dethi->fetch_assoc();
    if($dethi->num_rows > 0){
?>
<style>
    .error-message {
        color: red;
}
</style>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa đề thi</h2>
=======
<?php 
    include '../includes/config.php';
    include '../includes/database.php';
    include '../includes/functionCauHoi.php';
    include '../includes/functions.php';
    include '../includes/functionDeThi.php';
    include '../includes/functionChiTietDeThi.php';
    include '../includes/functionCauTraLoi.php';
    include '../includes/functionMonHoc.php';

    $cauhoi = getCauHoi($connect);
    $monhoc = getMonHoc($connect);
    $addchdethi=AddCHDethi($connect,$_GET['id']);
    $dethi = getChiTietDeThibyId($connect, $_GET['id']);
    $_SESSION['ma_de_thi'] = $_GET['id'];


    if(isset($_POST['submit'])){
        $ma_cau_hoi_array = $_POST['ma_cau_hoi'];
        echo 'array';
        print_r($ma_cau_hoi_array);
        $ma_de_thi = $_SESSION['ma_de_thi'];
        deleteChiTietDeThi($connect, $ma_de_thi);
        foreach($ma_cau_hoi_array as $ma_cau_hoi){
            echo "ma cau hoi" .$ma_cau_hoi;
            addChiTietDeThi($connect, $ma_de_thi,$ma_cau_hoi);
        }
         header("Location: dethi.php");
         $_SESSION['toastr'] = 'Thêm câu hỏi vào đề thi thành công';
         exit;
    }   
    
    ?>
    <script>
        $(document).ready(function() {
            $('.tables_ui tbody tr').click(function() {
                $(this).toggleClass('selected');
            });
        });
    </script>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đề thi Edit</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css"> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>

    <div class="container">
        <div class="row gx-5">
            <div class="col-12 mb-3 sticky-top">
                <div class="row">
                    <div class="col-3">
                        <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Tìm kiếm câu hỏi" />
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_monhoc" id="filter_monhoc">
                            <option disabled selected>Môn học</option>
                            <?php while($monhoc_record = $monhoc->fetch_assoc()) { ?>
                                <option value="<?php echo $monhoc_record['ma_mon_hoc']; ?>"><?php echo $monhoc_record['ten_mon_hoc']; ?></option>
<?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <select class="form-select" name="filter_dokho" id="filter_dokho">
                            <option disabled selected>Độ khó</option>
                            <option value="Dễ">Dễ</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Khó">Khó</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-info" id="refresh">REFRESH</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-5 border overflow-y-scroll" style="height: 600px;">
                <div class="p-3">Câu hỏi</div>
                <table class=" table-striped " id="t_draggable1">
                <tbody class="t_sortable">
                    <tr>
                        <th>STT</th>
                        <th>Nội dung câu hỏi</th>
                    </tr>
                    <?php
                    $stt = 1; 
                    
                    while ($cauhoi_record = $addchdethi->fetch_assoc()) { 
                        $noidung = getCauHoibyID($connect, $cauhoi_record["ma_cau_hoi"]);
                        $chdethi = $noidung->fetch_assoc(); ?>
                        <tr>
                        <td> <?php echo $stt ?> </td>
                        <td> <?php echo $chdethi["noi_dung"] ?></td>
                        <input type="hidden" name="ma_cau_hoi[]" value=" <?php echo $cauhoi_record['ma_cau_hoi'] ?> ">
                        </tr>
                    <?php
                        $stt++;
                    }?>
                    </tbody>
                </table>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center">
                <div class="btn-group-vertical">
                    <button class="btn btn-primary mb-3" id=tabAll_2>>></button>
                    <button class="btn btn-primary mb-3" id=tabAll_1><<</button>
                    <button class="btn btn-primary mb-3" id="tab1_2">></button>
                    <button class="btn btn-primary mb-3" id="tab2_1"><</button>
                </div>
            </div>
            <div class="col-5 border overflow-y-scroll " style="height: 600px;">
                <div class="p-3">Câu hỏi trong đề thi</div>
                <form action="" method="post">
                    <table class="table-striped" id="t_draggable2">
                    <tbody class="t_sortable ">
                        <tr>
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                        </tr>
                        
                        <?php
                        if ($dethi->num_rows > 0) {
$stt = 1;
                            while ($chiTiet = $dethi->fetch_assoc()) {
                                $noidung = getCauHoibyID($connect, $chiTiet["ma_cau_hoi"]);
                                $noidungch = $noidung->fetch_assoc();
                                echo '<tr>';
                                echo '<td>' . $stt . '</td>';
                                echo '<td>' . $noidungch["noi_dung"] . '</td>';
                                echo '<input type="hidden" name="ma_cau_hoi[]" value="' .$noidungch['ma_cau_hoi'] .'">';
                                echo '</tr>';
                                $stt++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
>>>>>>> dev:giaovien/dethi_chitiet.php
            </div>
            
        </div>
        <div class="text-end mt-3">
                <button class="btn btn-primary" type="submit" name="submit">Save</button>
            </form>
        </div>
    </div>
<<<<<<< HEAD:admin/dethi_edit.php
    <div class="card-body border p-4">
        <form  id="addDeThiForm" method="post" class="row">
            <div class="p-3">
                <p>Sửa tên đề thi</p>
                <div class="form-floating py-1 col-12">
                    <input class="form-control border shadow" name="ten_de_thi" value="<?php echo $dethi_record['ten_de_thi'];?>" />
                    <label class="ms-2">Tên đề thi </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="dethi">Vui lòng nhập tên đề thi</div>
                <p>Sửa thời gian làm bài</p>
                <div class="form-floating py-1 col-12">
                    <input type="number" class="form-control border shadow" name="thoi_gian_lam_bai" value="<?php echo $dethi_record['thoi_gian_lam_bai'];?>"/>
                    <label class="ms-2">Thời gian làm bài </label>
                    <span></span>
                </div><br>
                <div class="error-message" id="thoiGian">Vui lòng nhập đúng thời gian (0 < Thời gian làm bài < 200 )</div>
                <p>Sửa môn học</p>
 
                    <select class="form-select" name="ma_mon_hoc" id="ma_mon_hoc">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($dethi_record['ma_mon_hoc'] == $row['ma_mon_hoc']) ? 'selected' : '';
                            echo '<option value="' . $row['ma_mon_hoc'] . '" ' . $selected . '>' . $row['ten_mon_hoc'] . '</option>';
                        }
                        ?>
                    </select><br>
                <div class="error-message" id="monhoc">Vui lòng chọn môn học</div>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/dethi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#thoiGian').hide();
    $('#monhoc').hide();
    $('#dethi').hide();

    $('#addDeThiForm').submit(function(event) {
    var thoiGian = $('input[name="thoi_gian_lam_bai"]').val();
    var maMonHoc = $('select[name="ma_mon_hoc"]').val();
    var tenDeThi = $('input[name="ten_de_thi"]').val();
    var isValid = true;

    if (tenDeThi == null || tenDeThi.trim().length === 0) { 
            $('#dethi').show(); 
            isValid = false;
        } else {
            $('#dethi').hide();
        }

    if (thoiGian < 0 || thoiGian > 200 || thoiGian.trim().length === 0) {
    $('#thoiGian').show();
    isValid = false;
} else {
    $('#thoiGian').hide();
}

    if(maMonHoc == null){
        $('#monhoc').show();
        isValid = false;
    } else {
        $('#monhoc').hide();
    }

    if(!isValid){
        event.preventDefault();
    }
});

});
</script>
<?php
    }
}
include('../includes/admin_footer.php');
?>
=======

    <script>
    $(document).ready(function() {
        $("#t_draggable1 tbody").on('click', 'tr', function() {
            if (!$(this).is(':first-child')) {
                var selectRow = $(this).toggleClass('selected');
            }  
        });
        
        $("#t_draggable2 tbody").on('click', 'tr', function() {
            if (!$(this).is(':first-child')) {
                var selectRow = $(this).toggleClass('selected');
            }  
        });

        $('#tabAll_2').click(function() {
            var selectedRow=$('#t_draggable1 tbody tr:not(:first-child)');
            var table=$('#t_draggable2 tbody');
            moveRow(selectedRow,table);
        });

        // Di chuyển tất cả hàng từ bảng 2 sang bảng 1
        $('#tabAll_1').click(function() {
            var selectedRow=$('#t_draggable2 tbody tr:not(:first-child)');
            var table=$('#t_draggable1 tbody');
            moveRow(selectedRow,table);
        });

        // Di chuyển hàng đã chọn từ bảng 2 sang bảng 1
        $('#tab2_1').click(function() {
            var selectedRow=$('#t_draggable2 .selected');
            var table=$('#t_draggable1 tbody');
            moveRow(selectedRow,table);
        });
        $('#tab1_2').click(function() {
            var selectedRow=$('#t_draggable1 .selected');
            var table=$('#t_draggable2 tbody');
            moveRow(selectedRow,table);
        });

        function moveRow(row, table) {
            row.each(function() {
                var hiddenInput = $(this).find("input[name='ma_cau_hoi[]']");
                hiddenInput.appendTo(table);

                var ma_cau_hoi = hiddenInput.val();
                console.log('Mã câu hỏi vừa di chuyển: ' + ma_cau_hoi);
            });

            row.appendTo(table);
            row.removeClass('selected');
        }
      
        
    });
</script>


<script>
    $(document).ready(function() {
$('#search_box, #filter_monhoc, #filter_dokho').change(function() {
        var searchText = $('#search_box').val();
        var monHoc = $('#filter_monhoc').val();
        var doKho = $('#filter_dokho').val();
        $.ajax({
            url: 'dethi_search.php',
            type: 'GET',
            data: {search_text: searchText, mon_hoc: monHoc, do_kho: doKho},
            success: function(response) {
                $('#t_draggable1 tbody').html(response);
            }
        });
    });
});
</script>

    </body>
    </html>
>>>>>>> dev:giaovien/dethi_chitiet.php
