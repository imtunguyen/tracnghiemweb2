<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script
  src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css"/> -->
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light border-bottom box-shadow">
            <div class="container-fluid d-flex justify-content-between">
                <a class="navbar-brand" href="../admin/index.php">Logo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>   
                </button>
            </div>

        </nav>
    </header>
    <div class="container-fluid">
        <div class="loading spinner" style="display:none;"></div>
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark text-light sidebar collapse">
                <div class="position-static pt-3">
                    <ul class="navbar-nav">
                        <li>
                            <div class="small fw-bold text-uppercase px-3 mt-2">
                                Quản lý
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/cauhoi.php">
                                <span class="me-2"><i class="bi bi-house-door"></i></span>
                                <span>Câu hỏi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/monhoc.php">
                                <span class="me-2"><i class="bi bi-list-ol"></i></i></span>
                                <span>Môn học</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="me-2"><i class="bi bi-building"></i></span>
                                <span>Lớp học</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="me-2"><i class="bi bi-building"></i></span>
                                <span>Đề thi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/nguoidung.php">
                                <span class="me-2"><i class="bi bi-building"></i></span>
                                <span>Người dùng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <span class="me-2"><i class="bi bi-journal-plus"></i></span>
                                <span>Kết quả</span>
                            <a class="nav-link" href="../admin/phanquyen.php">
                                <span class="me-2"><i class="bi bi-building"></i></span>
                                <span>Phân Quyền</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 w-100">