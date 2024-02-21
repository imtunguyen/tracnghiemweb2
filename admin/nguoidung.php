<?php
include('../includes/admin_header.php');
?>
<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách người dùng</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="row pb-3">
            <div class="col-6 offset-6 text-end">
                <a class="btn btn-secondary" href="../admin/nguoidung_add.php">
                    <i class="bi bi-plus-circle"></i> Thêm người dùng mới
                </a>
            </div>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên ca sĩ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>
</div>
<?php
include('../includes/admin_footer.php');
?>