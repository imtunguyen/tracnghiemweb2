<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');


?>

<style>
    .error-message {
        color: red;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   
    <title>Quên mật khẩu</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
        <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 500px; height: 300px">
            <form id="getUsername" action="confirmUsername.php" method="post"> 
                <label for=""><h4>Nhập Username hoặc Email</h4></label><hr>
                <label for="">Nhập Username hoặc Email để thay đổi mật khẩu:</label><br><br>
                <input type="text" class="form-control" name="usernameOrEmail" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="error-message" id="usernameOrEmailError">Vui lòng nhập Username hoặc Email</div>
                <div class="error-message" id="checkUsernameError">Username hoặc Email không tồn tại</div>
                <hr>
                <div class="text-end">
                    <a href="dangnhap.php" class="btn btn-secondary">Hủy</a>
                    <button class="btn btn-primary" type="submit" name="submit">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
    $('#usernameOrEmailError').hide();
    $('#checkUsernameError').hide();

    $('#getUsername').submit(function(e){
        e.preventDefault(); // Prevent form submission

        var usernameOrEmail = $('input[name="usernameOrEmail"]').val();

        if(usernameOrEmail == ''){
            $('#usernameOrEmailError').show();
            $('#checkUsernameError').hide(); // Make sure to hide checkUsernameError when input is empty
        } else {
            $.ajax({
                url: 'checkUsername.php', 
                method: 'POST',
                data: { usernameOrEmail: usernameOrEmail },
                success: function(response){
                    if(response == 'not_found'){
                        $('#usernameOrEmailError').hide();
                        $('#checkUsernameError').show(); // Show checkUsernameError only when not found
                    } else {
                        $('#usernameOrEmailError').hide();
                        $('#checkUsernameError').hide();
                        $('#getUsername').unbind('submit').submit(); 
                    }
                }
            });
        }
    });
});



    </script>

<?php 
    include('includes/admin_footer.php');
?>
