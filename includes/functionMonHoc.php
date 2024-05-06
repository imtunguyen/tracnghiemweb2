<?php
function getMonHoc($connect) {
    $stm = $connect->prepare('SELECT * FROM mon_hoc WHERE trang_thai = 1');
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function get5MonHoc($connect, $start, $rows_per_page) {
    $stm = $connect->prepare('SELECT * FROM mon_hoc WHERE trang_thai = 1 LIMIT ?, ?');
    $stm->bind_param("ii", $start, $rows_per_page); 
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function addMonHoc($connect, $ten_mon_hoc, $trang_thai) {
    $stm = $connect->prepare('INSERT INTO mon_hoc (ten_mon_hoc, trang_thai) VALUES (?, ?)');
        $stm->bind_param('si', $ten_mon_hoc, $trang_thai);
        $stm->execute();
        $stm->close();
}
function updateMonHoc($connect, $ten_mon_hoc, $ma_mon_hoc){
    $stm = $connect->prepare('UPDATE mon_hoc SET ten_mon_hoc = ? WHERE ma_mon_hoc = ?');
        $stm->bind_param('si', $ten_mon_hoc, $ma_mon_hoc);
        $stm->execute();
        $stm->close();
}
function deleteMonHoc($connect, $ma_mon_hoc){
    $stm = $connect->prepare('UPDATE mon_hoc SET trang_thai = 0 WHERE ma_mon_hoc = ?');
        $stm->bind_param('i', $ma_mon_hoc);
        $stm->execute();
        $stm->close();
}
function getmonhocByID($connect, $ma_mon_hoc){
    $stm = $connect->prepare('SELECT ten_mon_hoc FROM mon_hoc WHERE ma_mon_hoc = ?');
    $stm->bind_param('i', $ma_mon_hoc);
    $stm->execute();
    $result = $stm->get_result(); // Lấy kết quả từ câu truy vấn
    $row = $result->fetch_assoc(); // Lấy hàng đầu tiên từ kết quả
    $stm->close();
    return $row['ten_mon_hoc']; // Trả về tên môn học
}

function searchMonHoc($connect, $search){
    $stm = $connect->prepare("SELECT * FROM mon_hoc WHERE trang_thai = 1 AND ten_mon_hoc LIKE '%$search%'");
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function xacNhanXoaMH($ma_mon_hoc, $modalXoaID){
    ?>
    <div class="modal fade" id="<?php echo $modalXoaID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận xóa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn muốn xóa môn học này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a class=" btn btn-danger mx-2" href="../admin/monhoc.php?delete=<?php echo $ma_mon_hoc; ?>">Xóa Môn Học</a>
                </div>
            </div>
        </div>
    </div>
<?php
}
