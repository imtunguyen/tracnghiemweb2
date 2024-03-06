
<?php
include('../includes/admin_header.php');

?>

<div class="mb-3">
    <label for="fileToUpload" class="btn btn-primary">Thêm từ File</label>
    <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf, .doc, .docx" style="display: none;">
</div>
<div id="fileContent"></div>
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
