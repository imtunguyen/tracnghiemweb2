<?php

function getDeThi($connect) {
    $stm = $connect->prepare('SELECT * FROM de_thi WHERE trang_thai = 1');
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
        $stm->bind_param('ssssss', $ma_mon_hoc, $trang_thai, $thoi_gian_lam_bai, $ten_de_thi, $ma_nguoi_tao, $ma_de_thi);
        $stm->execute();
        $stm->close();
}
function deleteDeThi($connect, $ma_de_thi){
    $stm = $connect->prepare('UPDATE de_thi SET trang_thai = 0 WHERE ma_de_thi = ?');
        $stm->bind_param('i', $ma_de_thi);
        $stm->execute();
        $stm->close();
}