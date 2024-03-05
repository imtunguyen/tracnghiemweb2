<?php

function addCauTraLoi($connect, $ma_cau_hoi,$cau_tra_loi, $dap_an){
    $stm = $connect->prepare('INSERT INTO cau_tra_loi (ma_cau_hoi, noi_dung, la_dap_an) VALUES (?,?,?)');
    $stm->bind_param('sss', $ma_cau_hoi, $cau_tra_loi, $dap_an);
    $stm->execute();
    $stm->close();
}
function updateCauTraLoi($connect, $ma_cau_hoi, $cau_tra_loi, $dap_an){
    $stm = $connect->prepare('UPDATE cau_tra_loi SET noi_dung = ?, la_dap_an = ? WHERE ma_cau_hoi = ?');
    $stm->bind_param('sss', $ma_cau_hoi, $cau_tra_loi, $dap_an);
    $stm->execute();
    $stm->close();
}

function getCauTraLoi($connect, $ma_cau_hoi){
    $stm = $connect->prepare('SELECT * FROM cau_tra_loi WHERE ma_cau_hoi = ?');
    $stm->bind_param('s', $ma_cau_hoi);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    return $result;
}
