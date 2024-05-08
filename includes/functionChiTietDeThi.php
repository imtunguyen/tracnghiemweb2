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
function AddCHDethi($connect, $ma_de_thi){
    $stm=$connect->prepare('SELECT ch.ma_cau_hoi FROM cau_hoi ch   WHERE ch.ma_cau_hoi NOT IN (SELECT ct.ma_cau_hoi FROM chi_tiet_de_thi ct JOIN de_thi dt ON dt.ma_de_thi = ct.ma_de_thi WHERE dt.ma_de_thi = ?)');
    $stm->bind_param('i', $ma_de_thi);
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}