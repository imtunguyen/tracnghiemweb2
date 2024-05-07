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
    <title>Login</title>
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
                <form id="loginForm" method="POST">
                    <div class="row align-items-center">
                        <div class="header-text mb-4 text-center">
                            <h2>ĐĂNG NHẬP</h2>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="username" name="username" placeholder="Tên tài khoản hoặc Email">
                            <span class="error text-danger" id="username-error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" id="password" name="password" placeholder="Mật khẩu">
                            <span class="error text-danger" id="password-error"></span>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check" style="cursor: pointer;">
                                <input type="checkbox" class="form-check-input" id="formCheck" style="cursor: pointer;">
                                <label for="formCheck" class="form-check-label text-secondary" style="cursor: pointer;"><small>Hiện mật khẩu</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="getUsername.php">Quên mật khẩu?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="button" id="submitBtn" class="btn btn-lg btn-primary w-100 fs-6">Đăng nhập</button>
                        </div>
                        <div class="forgot">
                            <small><a href="dangky.php">Chưa có tài khoản? Đăng ký!</a></small>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const checkBox = $("#formCheck");
            const passwordField = $("#password");

            checkBox.on("change", function() {
                if (checkBox.prop("checked")) {
                    passwordField.attr("type", "text");
                } else {
                    passwordField.attr("type", "password");
                }
            });

            function checkValidation() {
                const username = $("#username").val();
                const password = $("#password").val();
                if (username.length == 0) {
                    $("#username-error").text("Vui lòng nhập username hoặc email");
                    return false;
                }
                if (password.length == 0) {
                    $("#password-error").text("Vui lòng nhập password");
                    return false;
                }
                return true;
            }
            $('#submitBtn').click(function() {
                $(".error").html("");
                var form = $('#loginForm')[0];
                var data = new FormData(form);
                console.log(checkValidation());
                if (checkValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: 'xulydangnhap.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response == "Sai tên đăng nhập hoặc mật khẩu") {
                                toastr.error(response);
                            }else {
                                window.location.href = 'trangchu.php';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>