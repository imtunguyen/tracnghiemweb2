<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

if(isset($_POST["submit"])){
    if(isset($_POST['usernameOrEmail'])){
        $usernameOrEmail = $_POST['usernameOrEmail'];
        $userInfo = getUsername($connect, $usernameOrEmail);
        if($userInfo !== null && $userInfo->num_rows > 0) {
            $row = $userInfo->fetch_assoc(); 
            echo $row['email'] . '<br>';
            echo $row['username'] . '<br>';
            $random = random_number(6);
            echo $random;
            
            echo '<script>';
            echo 'window.location.href = "changePassword.php?usernameOrEmail='.$usernameOrEmail.'";';
            echo '</script>';
        } 
        else{
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
    }
}
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
   
    <title>Login</title>
</head>
<body>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
    <div class="row border rounded-4 p-4 bg-white shadow box-area" style="width: 500px; height: 300px">
        <form action="" method="post"> 
            <label for=""><h4>Nhập Username hoặc Email</h4></label><hr>
            <label for="">Nhập Username hoặc Email để thay đổi mật khẩu:</label><br><br>
            <input type="text" class="form-control" name="usernameOrEmail"aria-label="Recipient's username" aria-describedby="button-addon2"><hr>
            <div class="text-end">
            <button class="btn btn-secondary">Hủy</button>
            <button class="btn btn-primary"type="submit" name="submit"  data-bs-toggle="modal" data-bs-target="#exampleModal">Xác nhận</button>
            </div>
        </form>
    </div>
</div>
<?php
include('includes/admin_footer.php');
?>
