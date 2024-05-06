<?php

function getDeThi($connect) {
    $stm = $connect->prepare('SELECT * FROM de_thi WHERE trang_thai = 1');
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function getDeThibyID($connect, $id) {
    $stm = $connect->prepare('SELECT * FROM de_thi WHERE ma_de_thi =?');
    $stm = $connect->prepare('SELECT * FROM de_thi WHERE ma_de_thi =?');
    $stm->bind_param('i', $id);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function addDeThi($connect, $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao) {
    $stm = $connect->prepare('INSERT INTO de_thi (ma_mon_hoc, trang_thai, thoi_gian_lam_bai, ten_de_thi, ma_nguoi_tao) VALUES (?, ?,?,?,?)');
        $stm->bind_param('sssss', $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao);
        $stm->execute();
        $stm->close();
}
function updateDeThi($connect, $ma_mon_hoc, $ma_de_thi, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao){
    $stm = $connect->prepare('UPDATE de_thi SET ma_mon_hoc=?, trang_thai=?, thoi_gian_lam_bai=?, ten_de_thi=?, ma_nguoi_tao=? WHERE ma_de_thi = ?');
        $stm->bind_param('iiisii', $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao, $ma_de_thi);
        $stm->execute();
        $stm->close();
}
function deleteDeThi($connect, $ma_de_thi){
    $stm = $connect->prepare('UPDATE de_thi SET trang_thai = 0 WHERE ma_de_thi = ?');
        $stm->bind_param('i', $ma_de_thi);
        $stm->execute();
        $stm->close();
}
function modalXoaDeThi($ma_de_thi){
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận xóa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn muốn xóa đề thi này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a class=" btn btn-danger mx-2" href="../admin/dethi.php?delete=<?php echo $ma_de_thi; ?>">Xóa Đề Thi</a>
                </div>
            </div>
        </div>
    </div>
<?php
}

function modalChitietDeThi($connect, $ma_de_thi, $modalID){
    ?>
    <div class="modal fade" id="<?php echo $modalID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">CHI TIẾT ĐỀ THI</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateDeThiForm" action="" method="post">
                <div class="modal-body" id="modalContent">
                    <?php 
                    $ma_de_thi;
                    $result = getDeThibyID($connect, $ma_de_thi);
                    $record = $result->fetch_assoc();
                    $monhoc = getMonHoc($connect);
                    ?>
                    <label for="">Tên đề thi</label>
                    <input type="text" class="form-control" name="tenDeThi" value="<?php echo $record['ten_de_thi']?>"><br>
                    <label for="">Thời gian làm bài:</label>
                    <input type="number" class="form-control" name="thoiGian" value="<?php echo $record['thoi_gian_lam_bai']?>"><br>
                    
                    <label for="">Chọn môn học:</label>
                    <select class="form-select" name="ma_mon_hoc" id="ma_mon_hoc">
                        <?php
                        while ($row = $monhoc->fetch_assoc()) {
                            $selected = ($record['ma_mon_hoc'] == $row['ma_mon_hoc']) ? 'selected' : '';
                            echo '<option value="' . $row['ma_mon_hoc'] . '" ' . $selected . '>' . $row['ten_mon_hoc'] . '</option>';
                        }
                        ?>
                    </select><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php }
?>
<script>
$(document).ready(function() {
    $('#thoiGian').hide();
    $('#dethi').hide();

    $('#addDeThiForm').submit(function(event) {
    var thoiGian = $('input[name="thoiGian"]').val();
    var tenDeThi = $('input[name="tenDeThi"]').val();
    var isValid = true;

    if (tenDeThi == null || tenDeThi.trim().length === 0) { 
            $('#dethi').show(); 
            isValid = false;
        } else {
            $('#dethi').hide();
        }

    if (thoiGian < 0 || thoiGian > 200 || thoiGian.trim().length === 0) {
    $('#thoiGian').show();
    isValid = false;
    } else {
    $('#thoiGian').hide();
    }
    if(maMonHoc == null){
        $('#monhoc').show();
        isValid = false;
    } else {
        $('#monhoc').hide();
    }

    if(!isValid){
        event.preventDefault();
    }
});
});
 </script>