<?php
include('includes/database.php');
include('includes/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $mat_khau = $_POST['mat_khau'];
    $ngay_sinh = $_POST['ngay_sinh'];

    $errors = [];

    if (empty($ho_ten)) {
        $errors['ho_ten'] = "Vui lòng nhập họ tên";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Vui lòng nhập địa chỉ email hợp lệ";
    }

    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập";
    }

    if (empty($mat_khau)) {
        $errors['mat_khau'] = "Vui lòng nhập mật khẩu";
    }

    if (empty($ngay_sinh)) {
        $errors['ngay_sinh'] = "Vui lòng nhập ngày sinh";
    }

    // Update user in the database if no errors
    if (empty($errors)) {
        $stmt = $connect->prepare("UPDATE users SET ho_va_ten = ?, email = ?, username = ?, mat_khau = ?, ngay_sinh = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $ho_ten, $email, $username, $mat_khau, $ngay_sinh, $id);
        $stmt->execute();

        header("Location: trangchu.php");
        exit;
    }
} else {
    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

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
    <style>
        .error-message {
            color: red;
        }
    </style>
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
            <form id="addDeThiForm" method="post" class="row">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <div class="p-3">
                    <p>Họ Tên</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="ho_ten" value="<?php echo htmlspecialchars($user['ho_va_ten']); ?>">
                        <label class="ms-2">Họ Tên </label>
                        <span class="error-message"><?php echo isset($errors['ho_ten']) ? $errors['ho_ten'] : ''; ?></span>
                    </div>
                    <p>Email</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        <label class="ms-2">Email</label>
                        <span class="error-message"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                    </div>
                    <p>Tên đăng nhập</p>
                    <div class="form-floating py-1 col-12">
                        <input class="form-control border shadow" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <label class="ms-2">Tên đăng nhập</label>
                        <span class="error-message"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
                    </div>
                    <p>Mật khẩu</p>
                    <div class="form-floating py-1 col-12">
                        <input type="password" class="form-control border shadow" name="mat_khau" value="<?php echo htmlspecialchars($user['mat_khau']); ?>">
                        <label class="ms-2">Mật khẩu</label>
                        <span class="error-message"><?php echo isset($errors['mat_khau']) ? $errors['mat_khau'] : ''; ?></span>
                    </div>
                    <p>Ngày Sinh</p>
                    <div class="form-floating py-1 col-12">
                        <input type="date" class="form-control border shadow" name="ngay_sinh" value="<?php echo htmlspecialchars($user['ngay_sinh']); ?>">
                        <label class="ms-2">Ngày Sinh</label>
                        <span class="error-message"><?php echo isset($errors['ngay_sinh']) ? $errors['ngay_sinh'] : ''; ?></span>
                    </div>
                </div>

                <div class="row pt-2">
                    <div class="col-6 col-md-3">
                        <button type="submit" class="btn btn-success w-100">
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
</body>
</html>

<?php
include('includes/footer.php');
?>