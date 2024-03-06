    <?php
    include('../includes/config.php');
    include('../includes/database.php');
    include('../includes/admin_header.php');
    include('../includes/functionMonHoc.php');
    include('../includes/functions.php');

    thongBao();

    if(isset($_GET['delete'])){
        deleteMonHoc($connect, $_GET['delete']);
        $_SESSION['toastr'] = 'Xóa môn học thành công';
        header('Location: monhoc.php');
    }
    if(isset($_POST['records-limit'])){
        $_SESSION['records-limit'] = $_POST['records-limit'];
    }
    $limitPerPage = isset($_SESSION['records-limit']) ? $_SESSION['records-limit'] : 5;
    
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;
    $paginationStart = ($page - 1) * $limitPerPage;
    
    $mon_hoc = $connect->query("SELECT * FROM mon_hoc LIMIT $paginationStart, $limitPerPage");
    $monhoc_result = $mon_hoc->fetch_all(MYSQLI_ASSOC);
    
    $sql = $connect->query("SELECT count(ma_mon_hoc) AS ma_mon_hoc FROM mon_hoc");
    $result1 = $sql->fetch_all(MYSQLI_ASSOC);
    
    $allRecrods = $result1[0]['ma_mon_hoc'];
    
    $totoalPages = ceil($allRecrods / $limitPerPage);
    
    $prev = $page-1;
    $next = $page+ 1;
    $result = getMonHoc($connect);
    if ($result->num_rows >=0 ) {
    ?>

    <div class="w-100 card border-0 p-4">
        <div class="card-header bg-success bg-gradient ml-0 py-3">
            <div class="row">
                <div class="col-12 text-center text-white">
                    <h2>Danh sách môn học</h2>
                </div>
            </div>
        </div>
        <div class="card-body border p-4">
            <div class="row pb-3">
                <div class="col-7">
                    <form action="../admin/monhoc_search.php" method=post>
                    <div class="input-group mb-3 ">
                        <input type="text" class="form-control" name="search" id="floatingInputGroup1" placeholder="Tìm kiếm môn học">
                        <button type="submit" name="submit" class="input-group-text btn"><i class="bi bi-search"></i></button>
                    </div>
                    </form>
                </div>

                <div class="col-5  text-end">
                    <a class="btn btn-success" href="../admin/monhoc_add.php">
                        <i class="bi bi-plus-circle"></i> Thêm môn học mới
                    </a>
                </div>
            </div>
            <!-- Select dropdown -->
            <div class="d-flex flex-row-reverse bd-highlight mb-3">
                <form action="monhoc.php" method="post">
                    <select name="records-limit" id="records-limit" class="custom-select">
                        <option disabled selected>Records Limit</option>
                        <?php foreach([5,10,25,50] as $limit) : ?>
                        <option
                            <?php if(isset($_SESSION['records-limit']) && $_SESSION['records-limit'] == $limit) echo 'selected'; ?>
                            value="<?= $limit; ?>">
                            <?= $limit; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <table class="table table-bordered table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên môn học</th>
                        <th>Sửa | Xóa</th>
                    </tr>
                </thead>
                <?php $i=1; while($record = mysqli_fetch_assoc($result)){ ?> 
                <tbody>
                    <td> <?php echo $i++;?></td>
                    <td><?php echo $record['ten_mon_hoc'];?></td>
                    <td>
                        <div class="w-75 btn-group" role="group">
                            <a class=" btn btn-warning mx-2"
                                href="../admin/monhoc_edit.php?id=<?php echo $record['ma_mon_hoc']; ?>">
                                <i class=" bi bi-pencil-square"></i> Sửa
                            </a>
                            <a class=" btn btn-danger mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            >
                                <i class="bi bi-trash"></i> Xóa
                            </a>
                        </div>
                    </td>
                    <?php xacNhanXoaMH($record['ma_mon_hoc']);?>
                </tbody>
                <?php } ?> 
            </table>
        </div>
    </div>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation example mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link"
                            href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
                    </li>

                    <?php for($i = 1; $i <= $totoalPages; $i++ ): ?>
                    <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                        <a class="page-link" href="monhoc.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                    </li>
                    <?php endfor; ?>

                    <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
                        <a class="page-link"
                            href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- jQuery + Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#records-limit').change(function () {
                    $('form').submit();
                })
            });
        </script>
    <?php
    }


    include('../includes/admin_footer.php');
    ?>