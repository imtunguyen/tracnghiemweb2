<?php
function addChiTietDeThi($connect, $ma_de_thi, $ma_cau_hoi) {
    $stm = $connect->prepare('INSERT INTO chi_tiet_de_thi (ma_de_thi, ma_cau_hoi) VALUES (?, ?)');
        $stm->bind_param('ii', $ma_de_thi, $ma_cau_hoi);
        $stm->execute();
        $stm->close();
}
function updateChiTietDeThi($connect,  $ma_de_thi, $ma_cau_hoi){
    $stm = $connect->prepare('UPDATE chi_tiet_de_thi SET ma_cau_hoi=? WHERE ma_de_thi =?');
        $stm->bind_param('ii', $ma_cau_hoi, $ma_de_thi);
        $stm->execute();
        $stm->close();
}
function deleteChiTietDeThi($connect, $ma_de_thi){
    $stm = $connect->prepare('DELETE FROM chi_tiet_de_thi WHERE ma_de_thi = ?');
    $stm->bind_param('i', $ma_de_thi);
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
function AddCHDethi($connect, $ma_de_thi){
    $stm=$connect->prepare('SELECT ma_cau_hoi FROM cau_hoi WHERE ma_cau_hoi NOT IN (SELECT ma_cau_hoi FROM chi_tiet_de_thi ) AND trang_thai = 1 ');
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}