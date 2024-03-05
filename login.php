<?php 

if(isset($_POST["forgot"])){
    echo "bfubverdfnbvodknvpengpierfnbipermv";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
        <form action="" method="post">
          <div class="row align-items-center">
          <div class="header-text mb-4 text-center">
                     <h2>ĐĂNG NHẬP</h2>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                </div>
                <div class="input-group mb-1">
                    <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" id="password-input">
                </div>


                <div class="input-group mb-5 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Hiện mật khẩu</small></label>
                    </div>
                    <div class="forgot">
                        <small><a href="quenmatkhau.php" >Quên mật khẩu?</a></small>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" name="dang_nhap" class="btn btn-lg btn-primary w-100 fs-6">Đăng nhập</button>
                    
                </div>
          </div>
          
       </div> 
       </form>
      </div>
    </div>
</body>
</html>