<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

if(isset($_POST['submit'])){
    if(isset($_SESSION['random_code']) && isset($_POST['code'])){
        $random = $_SESSION['random_code'];
        $code = $_POST['code'];
        if($random == $code){
            echo '<script>';
                echo 'window.location.href = "changePassword.php";';
            echo '</script>';
        }
        else {
            echo "
            <script>alert('Mã không trùng khớp');</script>
            ";
        }
    }
    else{
        echo "
            <script>alert('Vui lòng nhập mã xác nhận');</script>
            ";
    }
}

if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $row = getUsername($connect, $email);
   
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
    <title>Reset Password</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #e9ebee;">
        <div class="row border rounded-4 p-4 bg-white shadow box-area" style="max-width: 500px; max-height: 250px;">
            <form action="" method="post"> 
                <label for=""><h4>Gửi đến Email</h4></label>
                <div class="row">
                    <div class="left-box col-md-6">
                        <label for="">Nhập mã xác nhận gồm 6 số:</label>
                        <input type="text" class="form-control" name="code" aria-label="Verification Code" aria-describedby="button-addon2">
                        <input type="hidden" name="email" value="<?php echo $row['email'] ?>">
                    </div>
                    <div class="right-box col-md-6">
                        <label for="">Đã gửi mail đến: <?php echo $row['email'] ?></label>
                    </div>
                </div>
                <hr>
                <div class="text-end">
                    <a href="dangnhap.php" class="btn btn-secondary" type="button">Hủy</a>
                    <button class="btn btn-primary" type="submit" name="submit">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
//     } else {
//         echo "Không tìm thấy thông tin người dùng.";
//     }
// } else {
//     echo "Không có dữ liệu được gửi đi.";
}


include('includes/admin_footer.php');
?>
