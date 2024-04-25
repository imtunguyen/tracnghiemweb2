<?php
function getLopHoc($connect){
    $stm=$connect->prepare('SELECT * from lop where trang_thai = 1');
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}
function addLopHoc($connect,$ten_lop, $trang_thai,$ma_moi){
    $stm=$connect->prepare('INSERT Into lop (ten_lop, trang_thai,ma_moi ) Values (? ,?,?');
    $stm->blind_param('sss',$ten_lop, $trang_thai, $ma_moi);
    $stm->execute();
    $stm->close();
}
function updateLopHoc($connect,$ten_lop,$ma_lop,$ma_moi){
    $stm=$connect->prepare('UPDATE lop set ten_lop=?, ma_moi=? where ma_lop=?');
    $stm->bind_param('si', $ten_lop,$ma_moi, $ma_lop);
    $stm->execute();
    $stm->close();
}
function deleteLopHoc($connect,$ma_lop){
    $stm=$connect->prepare('UPDATE lop set trang_thai=1 where ma_lop=?');
    $stm->bind_param('si',$ma_lop);
    $stm->execute();
    $stm->close();
}
function getlophocByID($connect, $ma_lop){
    $stm = $connect->prepare('SELECT ten_lop FROM lop WHERE ma_lop = ?');
    $stm->bind_param('i', $ma_lop);
    $stm->execute();
    $result = $stm->get_result(); 
    $row = $result->fetch_assoc(); 
    $stm->close();
    return $row['ten_lop'];
}

function searchLopHoc($connect, $search){
    $stm = $connect->prepare("SELECT * FROM lop WHERE trang_thai = 1 AND ten_lop LIKE '%$search%'");
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}