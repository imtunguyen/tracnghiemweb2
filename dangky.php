<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Đăng Ký</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-4 p-4 bg-white shadow box-area">
            <div class="col-md-5 rounded-3 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="images/hinh1.jpg" class="img-fluid" style="width: 300px;">
                </div>
            </div>
            <div class="col-md-7 right-box">
                <form id="registerForm" method="POST" enctype="multipart/form-data">
                    <div class="row align-items-center">
                        <div class="header-text mb-4 text-center">
                            <h2>ĐĂNG KÝ</h2>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="fullname" name="fullname" placeholder="Họ và tên">
                            <span class="error text-danger" id="fullname-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="username" name="username" placeholder="Tên tài khoản">
                            <span class="error text-danger" id="username-error"></span>
                        </div>
                        <div class="form-group mb-3 gap-2">
                            <input class="form-check-input" type="checkbox" name="gender" id="gender" value="1">
                            <label class="form-check-label" for="gender-error">
                                Nam
                            </label>
                            <span class="error text-danger" id="gender-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="email" name="email" placeholder="Địa chỉ email">
                            <span class="error text-danger" id="email-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" id="password" name="password" placeholder="Mật khẩu">
                            <span class="error text-danger" id="password-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" id="repassword" name="rePassword" placeholder="Nhập lại mật khẩu">
                            <span class="error text-danger" id="repassword-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-check-label" for="birthday">
                                Năm sinh
                            </label>
                            <input type="date" class="form-control form-control-lg bg-light fs-6" id="birthday" name="birthday">
                            
                            <span class="error text-danger" id="birthday-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="avatar" class="form-label">Chọn Avatar</label>
                            <input class="form-control" type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg, .gif, .bmp, .tiff, .raw, .webp, .svg" onchange="displayFileName()">
                            <span class="error text-danger" id="avatar-error"></span>
                        </div>
                        <div id="file-name"></div>
                        <div class="form-group mb-3">
                            <select name="permission" id="permission" class="form-select" id="permission">
                                <option selected disabled>--Chọn quyền--</option>
                                <option>Giáo viên</option>
                                <option>Học sinh</option>
                            </select>
                            <span class="error text-danger" id="permission-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" id="submitBtn" class="btn btn-lg btn-primary w-100 fs-6">Đăng Ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        

        $(document).ready(function() {
            function isValidEmail(email) {
                // Biểu thức chính quy để kiểm tra định dạng email
                var emailPattern = /^[^\s@]+@gmail\.com$/;
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
                const password = $('#password').val();
                const repassword = $('#repassword').val();
                const gender = $("#gender").val();
                const email = $('#email').val();
                const permission = $('#permission').val();
                console.log(permission);
                const birthday = $("#birthday").val();
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
                if (password.length == 0) {
                    $("#password-error").text("Mật khẩu không được để trống!");
                    return false;
                }
                if (password.length < 6) {
                    $("#password-error").text("Mật khẩu phải có ít nhất 6 ký tự!");
                    return false;
                }
                if (!/(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+])/.test(password)) {
                    $("#password-error").text("Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt!");
                    return false;
                }

                if (repassword.length == 0) {
                    $("#repassword-error").text("Nhập lại mật khẩu không được để trống!");
                    return false;
                }
                if (password !== repassword) {
                    $("#repassword-error").text("Mật khẩu không khớp!");
                    return false;
                }
                if (birthday == null) {
                    
                    $("#birthday-error").text("Vui lòng chọn ngày sinh!");
                    return false;
                } else if (!isValidDate(birthday)) {
                    $("#birthday-error").text("Ngày sinh không hợp lệ!");
                    return false;
                } else if (permission == null) {
                    $("#permission-error").text("Vui lòng chọn quyền.");
                    return false;
                }
                return true;
            }
            $('#submitBtn').click(function() {
                $(".error").html("");
                var form = $('#registerForm')[0];
                var data = new FormData(form);
                if (checkValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: 'xulydangky.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("KEt qua tra ve: " + response);
                            if (response == "Tên tài khoản bị trùng") toastr.error(response);
                            if (response == "Đăng ký thất bại") toastr.error(response);
                            if(response == "Failed to upload file") toastr.error(response);
                            if (response == "Email đã tồn tại") toastr.error(response);
                            if (response == "Đăng ký thành công đang chuyển hướng đến trang đăng nhập...") {
                                toastr.success(response);
                                setTimeout(function() {
                                    window.location.href = 'dangnhap.php';
                                }, 2000);

                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $('#registerForm').keypress(function(e) {
                if (e.which == 13) {
                    // Ngăn chặn hành động mặc định của nút submit
                    e.preventDefault();
                    $(".error").html("");
                    var form = $('#registerForm')[0];
                    var data = new FormData(form);
                    if (checkValidation()) {
                        $.ajax({
                            type: 'POST',
                            url: 'xulydangky.php',
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log("Kết quả trả về: " + response);
                                if (response == "Tên tài khoản bị trùng") toastr.error(response);
                                if (response == "Đăng ký thất bại") toastr.error(response);
                                if (response == "Failed to upload file") toastr.error(response);
                                if (response == "Email đã tồn tại") toastr.error(response);
                                if (response == "Đăng ký thành công đang chuyển hướng đến trang đăng nhập...") {
                                    toastr.success(response);
                                    setTimeout(function() {
                                        window.location.href = 'dangnhap.php';
                                    }, 1000);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                }
            });

        });
    </script>
</body>

</html>