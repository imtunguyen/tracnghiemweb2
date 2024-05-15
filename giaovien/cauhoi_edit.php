<?php
ob_start();
include('../includes/database.php');
include('../includes/header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

if(isset($_POST['cau_hoi'])){
    $trang_thai =1;
    $ma_nguoi_tao =$_SESSION['userId'];
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $do_kho = $_POST['do_kho'];
    $noi_dung = $_POST['cau_hoi'];
    $ma_cau_hoi = $_GET['id'];
    $result = getCauTraLoi($connect, $ma_cau_hoi);
    updateCauHoi($connect, $ma_cau_hoi, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho);

    if(isset($_POST['cau_tra_loi'])){
        // Xóa tất cả các câu trả lời cũ
        $result = getCauTraLoi($connect, $ma_cau_hoi);
        while ($cautraloi_record = $result->fetch_assoc()) {
            delCauTraLoi($connect, $cautraloi_record['ma_cau_tra_loi']);
        }
    
        // Thêm câu trả lời mới
        foreach($_POST['cau_tra_loi'] as $index => $cau_tra_loi){
            $dap_an = ($_POST['flexRadioDefault'] == ($index + 1)) ? 1 : 0;
            addCauTraLoi($connect, $ma_cau_hoi, $cau_tra_loi, $dap_an);
        }
    
        $_SESSION['toastr'] = 'Sửa câu hỏi thành công';
        header('Location: cauhoi.php');
        ob_end_flush();
    }
}
if(isset($_GET['id'])){
    $ma_cau_hoi = $_GET['id'];
    $cauhoi = getCauHoibyID($connect, $ma_cau_hoi, $_SESSION['userId']);
    $cauhoi_record = $cauhoi->fetch_assoc();
    $ma_mon_hoc = $cauhoi_record['ma_mon_hoc'];
    $monhoc = getMonHoc($connect);
    $ten_mon_hoc = getmonhocByID($connect,  $ma_mon_hoc);
    $cautraloi = getCauTraLoi($connect, $_GET['id']);

    if($cauhoi->num_rows > 0){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý trắc nghiệm</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
<style>
    .error-message {
        color: red; /* Đổi màu chữ thành màu đỏ */
    }
</style>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="pb-3">
            <p>Câu hỏi</p>
        </div>
        <form id="addQuestionForm" method="post" class="row">
            <div class="row pb-3">
                <div class="col-5">
                    <select class="form-select" name="ma_mon_hoc">
                        <option disabled>--Chọn môn học--</option>
                        <?php
                        while($monhoc_record = $monhoc->fetch_assoc()){
                            if($monhoc_record['ma_mon_hoc'] == $cauhoi_record['ma_mon_hoc']) {
                                echo '<option value="' . $monhoc_record['ma_mon_hoc'] . '" selected>' . $monhoc_record['ten_mon_hoc'] . '</option>';
                            } else {
                                echo '<option value="' . $monhoc_record['ma_mon_hoc'] . '">' . $monhoc_record['ten_mon_hoc'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-select" name="do_kho">
                        <option disabled>--Chọn độ khó--</option>
                        <?php
                        $do_kho_values = array('Dễ', 'Trung bình', 'Khó');
                        foreach ($do_kho_values as $value) {
                            if ($value == $cauhoi_record['do_kho']) {
                                echo '<option value="' . $value . '" selected>' . $value . '</option>';
                            } else {
                                echo '<option value="' . $value . '">' . $value . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="p-3 pt-0">
                <div id="fileContent">
                </div>
                <div class="input-group align-items-center">
                    <div class="form-floating py-1 col-12">
                        <input type="text" class="form-control border shadow" id="floatingInput" placeholder="Nội dung" name="cau_hoi" value="<?php echo $cauhoi_record['noi_dung'];?>">
                        <label for="floatingInput" class="ms-2">Nội dung</label>
                        <div class="error-message" id="question">Vui lòng nhập thông tin Câu hỏi</div>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <p>Câu trả lời</p>
                <select class="form-select" name="" id="answerCount">
                    <option>--Chọn số câu trả lời--</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div id="answerContainer">
                <?php 
                $i = 0;
                while($cautraloi_record = $cautraloi->fetch_assoc()){
                    echo "<div class='p-3 pt-0'>";
                    echo "<div class='input-group'>";
                    echo "<div class='input-group-text btn'>";
                    echo "<input class='form-check-input' type='radio' value='" . ($i+1) . "' name='flexRadioDefault' id='flexRadioDefault" . ($i+1) . "'";
                    if ($cautraloi_record['la_dap_an'] == 1) echo ' checked'; // Kiểm tra và thêm 'checked' nếu là đáp án
                    echo ">";
                    echo "</div>";
                    echo "<input type='text' class='form-control' name='cau_tra_loi[]' id='cau_tra_loi{$cautraloi_record['ma_cau_tra_loi']}' value='{$cautraloi_record['noi_dung']}'>";
                    
                    echo "</div>";
                    echo "<div class='error-message answer' id='answer{$i}'>Vui lòng nhập thông tin Câu trả lời</div>";
                    echo "</div>";
                    $i++;
                }
                ?>
            </div>
            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../giaovien/cauhoi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    $('#question').hide();
    $('.answer').hide();

    $('#addQuestionForm').submit(function(event) {
        // Kiểm tra dữ liệu trước khi submit
        var cauhoi = $('#floatingInput').val().trim();
        var count = $('#answerCount').val();
        var isValid = true;

        if (cauhoi === '') {
            $('#question').text('Vui lòng nhập thông tin Câu hỏi').show();
            isValid = false;
        } else {
            $('#question').hide();
        }

        for (var i = 1; i <= count; i++) {
            var cautraloi = $('#cau_tra_loi' + i).val().trim();
            if (cautraloi === '') {
                $('#answer' + i).html('Vui lòng nhập thông tin Câu trả lời').show();
                isValid = false;
            } else {
                $('#answer' + i).hide();
            }
        }

        var selectedDapAn = $("input[name='flexRadioDefault']:checked").val();
        if (selectedDapAn === undefined) {
            $('#dapAnMessage').text('Vui lòng chọn đáp án').show(); 
            isValid = false;
        } else {
            $('#dapAnMessage').hide(); 
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    $('#answerCount').change(function() {
        var count = this.value;
        var container = $('#answerContainer');
        container.empty();

        for (var i = 1; i <= count; i++) {
            container.append(`
                <div class="p-3 pt-0">
                    <div class="input-group">
                        <div class="input-group-text btn">
                            <input class="form-check-input" type="radio" value="${i}" name="flexRadioDefault" id="flexRadioDefault${i}">
                        </div>
                        <input class="form-control" name="cau_tra_loi[]" id="cau_tra_loi${i}">
                        <div class="input-group-text">
                            <i class="bi bi-card-image"></i>
                        </div>
                    </div>
                    <div id="dapAnMessage" class="error-message">Vui lòng chọn đáp án</div>
                    <div class="error-message answer" id="answer${i}">Vui lòng nhập thông tin Câu trả lời</div>
                </div>
               
            `);
            $('#answer' + i).hide(); // Ẩn thông báo lỗi khi tạo ô mới
        }
        
    });
});
</script>
<?php
    }
}

include('../includes/footer.php');
?>
