<?php 

require_once('../includes/functionUsers.php');
require_once('../includes/database.php');

if(isset($_GET['delete'])) {
  $id = $_GET['delete'];
    deleteNguoiDung($connect, $id);
  ?>
  <script>window.location.href = "nguoidung.php";</script>
  <?php
}

?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách người dùng</h2>
            </div>
        </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <input type="text" name="search_box" id="search_box" class="form-control" placeholder="Type your search here" style="width: 50%; float: right;"/>
        </div>
      </div>
      <div class="table-responsive" id="dynamic_content">
      </div>
    </div>
</div>