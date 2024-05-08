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
    <title>Quên mật khẩu</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
        <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 500px; height: 300px">
            <form id="editForm" method="post"> 
                <label for=""><h4>Nhập Username hoặc Email</h4></label><hr>
                <label for="">Nhập Username hoặc Email để thay đổi mật khẩu:</label><br><br>
                <input type="text" id="usernameOrEmail" class="form-control" name="usernameOrEmail" aria-label="Recipient's username" aria-describedby="button-addon2">
                <span class="error text-danger" id="usernameOrEmail-error"></span>
                <hr>
                <div class="text-end">
                    <a href="dangnhap.php" class="btn btn-secondary">Hủy</a>
                    <button class="btn btn-primary" id="submitBtn" type="button" name="submit">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
    <script>

    $(document).ready(function() {

            const checkValidation = function() {
                const usernameOrEmail = $('#usernameOrEmail').val();
              
                if (usernameOrEmail.length == 0) {
                    $("#usernameOrEmail-error").text("Vui lòng nhập Username hoặc Email!");
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
                        url: 'checkUsername.php',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log('ket qua'+response);
                            toastr.options.timeOut = 3000;
                            toastr.options.progressBar = true;
                            if (response != "Không tìm thấy Username hoặc Email") {
                                setTimeout(function() {
                                    window.location.href = `confirmUsername.php?username=${response}`;
                                    
                                    
                                }, 1000);

                            }else{
                                toastr.error(response);
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
