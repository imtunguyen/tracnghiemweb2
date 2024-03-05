<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

if(isset($_POST['cau_hoi'])){
    $trang_thai = 1;
    $ma_nguoi_tao = 1;
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $do_kho = $_POST['do_kho'];
    $noi_dung = $_POST['cau_hoi'];
    
    addCauHoi($connect, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho);
    
    if(isset($_POST['cau_tra_loi'])){
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
    }
}

$result = getMonHoc($connect);


?>

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
        <form method="post" class="row">
            <div class="row pb-3">
                <div class="col-5">
                    <select class="form-select" name="ma_mon_hoc">
                        <option>--Chọn môn học--</option>
                        <?php while($record = $result->fetch_assoc()){?>
                            <option value="<?php echo $record['ma_mon_hoc'];?>"><?php echo $record['ten_mon_hoc'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-select" name="do_kho">
                        <option>--Chọn độ khó--</option>
                        <option value="Dễ">Dễ</option>
                        <option value="Trung bình">Trung bình</option>
                        <option value="Khó">Khó</option>
                    </select>
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
                        <input type="text" class="form-control border shadow" id="floatingInput" placeholder="Nội dung" name="cau_hoi">
                        <label for="floatingInput" class="ms-2">Nội dung</label>
                    </div>
                    <div class="input-group-text btn">
                        <i class="bi bi-card-image"></i>
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
            <div id="answerContainer"></div>
            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
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
    var file = this.files[0];
    var formData = new FormData();
    formData.append('fileToUpload', file);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Xử lý nội dung file được trả về từ máy chủ
                document.getElementById('fileContent').innerHTML = xhr.responseText;
            } else {
                // Xử lý lỗi nếu có
                console.error('Đã xảy ra lỗi: ' + xhr.status);
            }
        }
    };

    // Gửi yêu cầu đến máy chủ với tệp tin đã chọn
    xhr.open('POST', 'process_file.php', true);
    xhr.send(formData);
});
</script>
<?php
include('../includes/admin_footer.php');
?>
