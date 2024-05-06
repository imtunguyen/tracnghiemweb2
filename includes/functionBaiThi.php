<?php 
function loadBaiThi($connect,$ma_lop){
    $stm=$connect->prepare('SELECT * FROM bai_thi WHERE ma_lop= ?');
    $stm->bind_param('i',$ma_lop);
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}
?>