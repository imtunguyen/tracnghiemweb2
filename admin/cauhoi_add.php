<?php
ob_start();
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');
require_once '../vendor/autoload.php';

    if(isset($_POST['cau_hoi']) && isset($_POST['ma_mon_hoc']) && isset($_POST['do_kho']) && isset($_POST['cau_tra_loi'])){
        $trang_thai = 1;
        $ma_nguoi_tao = 1;
        $ma_mon_hoc = $_POST['ma_mon_hoc'];
        $do_kho = $_POST['do_kho'];
        $noi_dung = $_POST['cau_hoi'];

        addCauHoi($connect, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho);
        $result = getLastCauHoi($connect);
        $record = $result->fetch_assoc();
        $dap_an_dung = $_POST['flexRadioDefault'];

        foreach($_POST['cau_tra_loi'] as $index => $cau_tra_loi){
            $id = $index + 1;
            $dap_an = ($dap_an_dung == $id) ? 1 : 0;
            addCauTraLoi($connect, $record['ma_cau_hoi'], $cau_tra_loi, $dap_an);
        }

        $_SESSION['toastr'] = 'Thêm câu hỏi thành công';
        header('Location: cauhoi.php');
        exit();
    }

$result = getMonHoc($connect);
ob_end_flush();
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
                <h2 class="text-white py-2">Thêm câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="pb-3">
            <p>Câu hỏi</p>
        </div>
        <form id="addQuestionForm" method="post" class="row" enctype="multipart/form-data" >
            <div class="row pb-3">
                <div class="col-5">
                    <select class="form-select" name="ma_mon_hoc">
                        <option disabled selected>--Chọn môn học--</option>
                        <?php while($record = $result->fetch_assoc()){?>
                            <option value="<?php echo $record['ma_mon_hoc'];?>"><?php echo $record['ten_mon_hoc'];?></option>
                        <?php } ?>
                    </select>
                    <div class="error-message" id="monhoc">Vui lòng chọn môn học</div>
                </div>
                
                <div class="col-4">
                    <select class="form-select" name="do_kho">
                        <option disabled selected>--Chọn độ khó--</option>
                        <option value="Dễ">Dễ</option>
                        <option value="Trung bình">Trung bình</option>
                        <option value="Khó">Khó</option>
                    </select>
                    <div class="error-message" id="dokho">Vui lòng chọn độ khó</div>
                </div>
                <div class="col-3">
                    <div class="mb-3">
                        <label for="fileToUpload" class="btn btn-primary">Thêm từ File</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf, .doc, .docx" style="display: none;">
                        
                    </div>
                </div>
            </div>
            <div class="p-3 pt-0">
            <div id="fileContent">
                
            </div>
                <div class="input-group align-items-center">
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" id="floatingInput" placeholder="Nội dung" name="cau_hoi"  rows="10" cols="80">
                        <label for="floatingInput" class="ms-2">Nội dung</label>
                        <div class="error-message" id="question">Vui lòng nhập thông tin Câu hỏi</div>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <p>Câu trả lời</p>
                <select class="form-select" name="" id="answerCount">
                    <option disabled selected>--Chọn số câu trả lời--</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div id="answerContainer"></div>
            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100" >
                        <i class="bi bi-check-circle"></i> Thêm
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/cauhoi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('fileToUpload').addEventListener('change', function() {
    var ma_mon_hoc = $('[name="ma_mon_hoc"]').val();
    var isValid = true;

    if (ma_mon_hoc === null) {
        $('#monhoc').text("Vui lòng chọn môn học").show();
        isValid = false;
    } else {
        $('#monhoc').hide(); 
        var file = this.files[0];
        var formData = new FormData();
        formData.append('fileToUpload', file);
        formData.append('ma_mon_hoc', ma_mon_hoc);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('fileContent').innerHTML = xhr.responseText;
                } else {
                    console.error('Đã xảy ra lỗi: ' + xhr.status);
                }
            }
        };
        xhr.open('POST', 'process_file.php', true);
        xhr.send(formData);
    }
});
</script>
<script>
$(document).ready(function() {
    // Ẩn thông báo lỗi ban đầu
    $('#question').hide();
    $('#dokho').hide();
    $('#monhoc').hide();
    $('.answer').hide();
    $('#dapAnMessage').hide();    

    $('#addQuestionForm').submit(function(event) {
        // Kiểm tra dữ liệu trước khi submit
        var cauhoi = $('#floatingInput').val().trim();
        var count = $('#answerCount').val();
        var maMonHoc = $('[name="ma_mon_hoc"]').val();
        var doKho = $('[name="do_kho"]').val();
        var isValid = true;

        if (cauhoi === '') {
            $('#question').text('Vui lòng nhập thông tin Câu hỏi').show();
            isValid = false;
        } else {
            $('#question').hide();
        }

        if (maMonHoc === null) {
            $('#monhoc').text('Vui lòng chọn môn học').show();
            isValid = false;
        } else {
            $('#monhoc').hide();
        }

        if (doKho === null) {
            $('#dokho').text('Vui lòng chọn độ khó').show();
            isValid = false;
        } else {
            $('#dokho').hide();
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
            $('#dapAnMessage').text('Vui lòng chọn đáp án').show(); // Hiển thị thông báo chưa chọn đáp án
            isValid = false;
        } else {
            $('#dapAnMessage').hide(); // Ẩn thông báo nếu đã chọn đáp án
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
include('../includes/admin_footer.php');
?>
