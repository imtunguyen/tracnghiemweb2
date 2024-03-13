<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2>Danh sách quyền</h2>
            </div>
        </div>    
    </div>
    <table class="table table-bordered table-striped align-middle text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Quyền</th>
                <th>Chức Năng</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <?php 
        
        $query = "select distinct q.* from quyen q join chi_tiet_chuc_nang ctcn on ctcn.ma_quyen = q.ma_quyen join chuc_nang cn on cn.ma_chuc_nang = ctcn.ma_chuc_nang
        where cho_phep = 1;";
        $select_roles = mysqli_query($connect, $query);  
        while($row = mysqli_fetch_assoc($select_roles)) {
            $role_id  = $row['ma_quyen'];
            $role_name = $row['ten_quyen'];

            echo "

            <tr>
                <td>$role_id</td>
                <td>$role_name </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            ";
        }

        ?>
    </table>
</div>