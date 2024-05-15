<?php
function addChiTietDeThi($connect, $ma_de_thi, $ma_cau_hoi) {
    $stm = $connect->prepare('INSERT INTO chi_tiet_de_thi (ma_de_thi, ma_cau_hoi) VALUES (?, ?)');
        $stm->bind_param('ss', $ma_de_thi, $ma_cau_hoi);
        $stm->execute();
        $stm->close();
}
function updateChiTietDeThi($connect,  $ma_de_thi, $ma_cau_hoi){
    $stm = $connect->prepare('UPDATE chi_tiet_de_thi SET ma_cau_hoi=? WHERE ma_de_thi =?');
        $stm->bind_param('ss', $ma_cau_hoi, $ma_de_thi);
        $stm->execute();
        $stm->close();
}
function deleteChiTietDeThi($connect, $ma_de_thi){
    $stm = $connect->prepare('DELETE FROM chi_tiet_de_thi WHERE ma_de_thi = ?');
    $stm->bind_param('s', $ma_de_thi);
    $stm->execute();
    $stm->close();
}
function getChiTietDeThibyId($connect, $ma_de_thi) {
    $stm = $connect->prepare('SELECT ma_cau_hoi FROM chi_tiet_de_thi WHERE ma_de_thi=?');
    $stm->bind_param('i', $ma_de_thi);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function AddCHDethi($connect, $ma_de_thi,$ma_nguoi_tao){
    $stm=$connect->prepare('SELECT ch.ma_cau_hoi FROM cau_hoi ch   WHERE ch.trang_thai=1 AND ch.ma_nguoi_tao= ? AND ch.ma_cau_hoi NOT IN (SELECT ct.ma_cau_hoi FROM chi_tiet_de_thi ct JOIN de_thi dt ON dt.ma_de_thi = ct.ma_de_thi WHERE dt.ma_de_thi = ?)');
    $stm->bind_param('ii',$ma_nguoi_tao, $ma_de_thi);
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}
function modalChiTietDT($connect, $ma_de_thi, $modalID){
    ?>
    <div class="modal fade" id="<?php echo $modalID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Câu hỏi trong đề thi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Câu hỏi</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                <?php 
                    $cauhoi = getChiTietDeThibyId($connect, $ma_de_thi);
                    $i = 1;
                    while ($row = $cauhoi->fetch_assoc()) {
                        $ma_cau_hoi = $row['ma_cau_hoi'];
                        $stm = $connect->prepare('SELECT noi_dung FROM cau_hoi WHERE ma_cau_hoi = ?');
                        $stm->bind_param('i', $ma_cau_hoi);
                        $stm->execute();
                        $result = $stm->get_result();
                        $row = $result->fetch_assoc();
                        $noi_dung = $row['noi_dung'];
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $noi_dung; ?></td>
                        </tr>
                    <?php } ?>  
                </tbody>
            </table>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<?php
}
