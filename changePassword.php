<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
   
    <title>Login</title>
</head>
<body>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 600px; height: 350px">
        <form id="changeForm"  method="post"> 
            <label for=""><h4>Đổi mật khẩu</h4></label><hr>
            <label for="">Nhập mật khẩu mới:</label><br>
            <input type="text" class="form-control" id="newPassword" name="newPassword"><br>
            <label for="">Xác nhận mật khẩu:</label><br>
            <input type="text" class="form-control" id="reNewPassword" name="reNewPassword">
            <span class="error text-danger" id="password-error"></span>
            <hr>
            <div class="text-end">
            <a href="dangnhap.php" class="btn btn-secondary">Hủy</a>
            <button class="btn btn-primary"type="button" name="submit" id="submitBtn" >Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        const checkValidation = function() {
                const password = $('#newPassword').val();
                const repassword = $('#reNewPassword').val();
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
                    $("#password-error").text("Nhập lại mật khẩu không được để trống!");
                    return false;
                }
                if (password !== repassword) {
                    $("#password-error").text("Mật khẩu không khớp!");
                    return false;
                }
                return true;
            }
            $('#submitBtn').click(function() {
                $(".error").html("");
                var form = $('#changeForm')[0];
                var data = new FormData(form);
                if (checkValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: 'xulydoimk.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            if (response != "") {
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

            $('#submitBtn').keypress(function(e) {
        if (e.which == 13) {
            e.preventDefault();
            $(".error").html("");
                var form = $('#changeForm')[0];
                var data = new FormData(form);
                if (checkValidation()) {
                    $.ajax({
                        type: 'POST',
                        url: 'xulydoimk.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            if (response != "") {
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
        }
    });

    });
</script>