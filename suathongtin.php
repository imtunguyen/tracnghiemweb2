<?php
include('includes/database.php');
include('includes/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$users = getUsernamebyID($connect, $id);
$user = $users->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <script src="../js/script.js"></script>
</head>
<body>
    <div class="w-100 card border-0 p-4">
        <div class="card-header bg-success bg-gradient ml-0 py-3">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="text-white py-2">Chỉnh sửa thông tin</h2>
                </div>
            </div>
        </div>
        <div class="card-body border p-4">
            <form id="editForm" method="post" class="row" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <div class="p-3">
                    <p>Họ Tên</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="fullname"   value="<?php echo $user['ho_va_ten'] ?>"/>
                        <label class="ms-2">Họ Tên </label>
                        <span class="error text-danger" id="fullname-error"></span>
                    </div>
                    <p>Email</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="email" value="<?php echo $user['email'] ?>"/>
                        <label class="ms-2">Email</label>
                        <span class="error text-danger" id="email-error"></span>
                    </div>
                    <p>Tên đăng nhập</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <label class="ms-2">Tên đăng nhập</label>
                        <span class="error text-danger" id="username-error"></span>
                    </div>
                    <p>Ngày Sinh</p>
                    <div class="form-floating py-1 col-12">
                        <input type="date" class="form-control border shadow" name="birthday" value="<?php echo htmlspecialchars($user['ngay_sinh']); ?>">
                        <label class="ms-2">Ngày Sinh</label>
                        <span class="error text-danger" id="birthday-error"></span>
                    </div>
                    <p>Avatar</p>
                        <label for="avatar" class="form-label"></label>
                        <input class="form-control" type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg, .gif, .bmp, .tiff, .raw, .webp, .svg">
                </div>

                <div class="row pt-2">
                    <div class="col-6 col-md-3">
                        <button type="submit" id="submitBtn" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Sửa
                        </button>
                    </div>
                    <div class="col-6 col-md-3">
                        <a class="btn btn-secondary w-100" href="../giaovien/dethi.php">
                            <i class="bi bi-x-circle"></i> Trở về
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        function isValidEmail(email) {
                // Biểu thức chính quy để kiểm tra định dạng email
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailPattern.test(email);
            }

            function isValidDate(dateString) {
                // Kiểm tra định dạng ngày (YYYY-MM-DD) sử dụng regex
                var datePattern = /^\d{4}-\d{2}-\d{2}$/;
                if (!datePattern.test(dateString)) return false;
                // Chuyển đổi chuỗi ngày thành đối tượng Date
                var dateObject = new Date(dateString);
                // Kiểm tra nếu ngày hợp lệ
                return !isNaN(dateObject.getTime());
            }

            const checkValidation = function() {
                const fullname = $('#fullname').val();
                const username = $('#username').val();
                const email = $('#email').val();
                const birthday = $("#birthday").val();
                console.log(birthday);
                if (fullname.length == 0) {
                    $("#fullname-error").text("Họ và tên không được để trống!");
                    return false;
                }
                if (/\d/.test(fullname)) {
                    $("#fullname-error").text("Tên không được chứa số!");
                    return false;
                }
                if (username.length == 0) {
                    $("#username-error").text("Tên tài khoản không được để trống!");
                    return false;
                }
                if (username.length < 6) {
                    $("#username-error").text("Tên tài khoản phải ít nhất 6 ký tự!");
                    return false;
                }
                if (email.length == 0) {
                    $("#email-error").text("Địa chỉ email không hợp lệ!");
                    return false;
                } else if (!isValidEmail(email)) {
                    $("#email-error").text("Địa chỉ email không hợp lệ!");
                    return false;
                }
                if (birthday == null) {
                    
                    $("#birthday-error").text("Vui lòng chọn ngày sinh!");
                    return false;
                } else if (!isValidDate(birthday)) {
                    $("#birthday-error").text("Ngày sinh không hợp lệ!");
                    return false;
                }
                return true;
            }
            $('#submitBtn').click(function() {
                $(".error").html("");
                var form = $('#editForm')[0];
                var data = new FormData(form);
                if (checkValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: 'xulythongtin.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            toastr.options.timeOut = 3000;
                            toastr.options.progressBar = true;
                            if (response == "Tên tài khoản bị trùng") toastr.error(response);
                            if (response == "Email đã tồn tại") toastr.error(response);
                            if (response == "Câp nhật thông tin thành công") {
                                toastr.success(response);
                                setTimeout(function() {
                                    window.location.href = 'trangchu.php';
                                }, 3000);

                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
    });
</script>


<?php
include('includes/footer.php');
?>