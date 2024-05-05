<?php
session_start();
require_once('./includes/functions.php');
require_once('./includes/database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý trắc nghiệm</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
            <use xlink:href="#bootstrap"></use>
          </svg>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <?php 
        $roles = getQuyen($connect, $_SESSION['userId']);
        if ($roles !== null) {
            if (in_array('admin', $roles)) { ?>
                <li><a href="#" class="nav-link px-2 link-secondary">Trang Chủ</a></li>
                <li><a href="admin/nguoidung.php" class="nav-link px-2">Người dùng</a></li>
                <li><a href="admin/phanquyen.php" class="nav-link px-2">Phân Quyền</a></li>
            <?php } elseif (in_array('giao_vien', $roles)) { ?>
                <li><a href="#" class="nav-link px-2 link-secondary">Trang Chủ</a></li>
                <li><a href="lophoc." class="nav-link px-2">Lớp Học</a></li>
                <li><a href="#" class="nav-link px-2">Đề Thi</a></li>
                <li><a href="#" class="nav-link px-2">Câu Hỏi</a></li>
                <li><a href="#" class="nav-link px-2">Môn Học</a></li>
                <li><a href="#" class="nav-link px-2">Thống Kê</a></li>
            <?php } else { ?>
                <li><a href="#" class="nav-link px-2 link-secondary">Trang Chủ</a></li>
                <li><a href="lophoc.php" class="nav-link px-2">Lớp Học</a></li>
                <li><a href="#" class="nav-link px-2">Thống Kê</a></li>
            <?php }
        } else {
            // Xử lý khi $roles là null
        }
        ?>
      </ul>

      <div class="col-md-3 text-end">
        <?php
          if (isset($_SESSION['username']) && isset($_SESSION['userId'])) { ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script type="text/javascript">
                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "0",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }
            toastr.info("<?php echo "Xin Chào ". $_SESSION['username'] ." Bạn Có Các Chức Năng: " .getChucNangCuaNguoiDung($connect, $_SESSION['userId']); ?>");
          </script>
          <?php
          }  
        ?>
        <a href="dangxuat.php" class="btn btn-outline-primary me-2">Đăng xuất</a>
        <?php 
        $id = $_SESSION['userId'];
        if(check($connect, $id, "them_nguoidung") || check($connect, $id, "sua_nguoidung") || check($connect, $id, "xoa_nguoidung") || check($connect, $id, "them_quyen") || check($connect, $id, "sua_quyen") || check($connect, $id, "xoa_quyen")) {
            echo '<a href="admin/index.php" class="btn btn-outline-primary me-2">Admin</a>';
        }

        ?>
        <div id="extwaiokist" style="display:none" v="hffpf" q="47eb450c" c="190.7" i="197" u="16.87" s="02082404" sg="svr_undefined-ga_02082404-bai_02072413" d="1" w="false" e="" a="2" m="BMe=" vn="9zlar">
          <div id="extwaigglbit" style="display:none" v="hffpf" q="47eb450c" c="190.7" i="197" u="16.87" s="02082404" sg="svr_undefined-ga_02082404-bai_02072413" d="1" w="false" e="" a="2" m="BMe="></div>
        </div>
    </header>
  </div>