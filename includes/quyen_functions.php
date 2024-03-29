<?php
function checkExistedName($connect, $name) {
    $query = "select * from quyen where ten_quyen = '$name'";
    $rowcount = 0;
    if ($result = mysqli_query($connect, $query))
    {
        $rowcount=mysqli_num_rows($result);
    }
    if($rowcount > 0) {
        return true;
    }
    else {
        return false;
    }
}

function validate($connect, $name) {
    if(checkExistedName($connect, $name)) {
        return "da_ton_tai";
    }
    if($name == "") {
        return "rong";
    }
    return "hop_le";
}


function getIdTheoTen($connect, $ten) {
    $id = "";
    $query = "select ma_chuc_nang from chuc_nang where ten_chuc_nang = '$ten'";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['ma_chuc_nang'];
    }
    return $id;
}

function addQuyen($connect, $ten) {
    $query = "INSERT INTO quyen(ten_quyen, trang_thai) ";
    $query .= "VALUES('{$ten}', 1) "; 
    $create_query = mysqli_query($connect, $query);  

    $new_id = mysqli_insert_id($connect);

    return $new_id;
}

function addChiTietChucNang($connect, $ma_quyen, $ma_chuc_nang) {
    $query = "INSERT INTO chi_tiet_chuc_nang(ma_quyen, ma_chuc_nang, cho_phep) ";
    $query .= "VALUES($ma_quyen, $ma_chuc_nang, 1)";

    $create_query = mysqli_query($connect, $query); 
}

function updateChiTietChucNang($connect, $ma_quyen, $ma_chuc_nang, $cho_phep) {
    $query = "UPDATE chi_tiet_chuc_nang ";
    $query .= "SET cho_phep = $cho_phep WHERE ma_quyen = $ma_quyen AND ma_chuc_nang = $ma_chuc_nang";

    $create_query = mysqli_query($connect, $query); 
}

function checkExistedCheckBox($connect, $ma_quyen, $ten_chuc_nang) {
    
    $query = "SELECT * FROM quyen q
                JOIN chi_tiet_chuc_nang ctcn ON ctcn.ma_quyen = q.ma_quyen
                JOIN chuc_nang cn ON cn.ma_chuc_nang = ctcn.ma_chuc_nang
                WHERE cho_phep = 1 AND q.ma_quyen = $ma_quyen AND cn.ten_chuc_nang = '{$ten_chuc_nang}';";
    $rowcount = 0;
    if ($result = mysqli_query($connect, $query))
    {
        $rowcount=mysqli_num_rows($result);
    }
    if($rowcount > 0) {
        return true;
    }
    else {
        return false;
    }
}

function deleteQuyen($connect, $ma_quyen) {
    $query = "UPDATE quyen ";
    $query .= "SET trang_thai = 0 WHERE ma_quyen = $ma_quyen ";

    $create_query = mysqli_query($connect, $query); 
}

function getNameById($connect, $id) {
    $name = "";
    $query = "select ten_quyen from quyen where ma_quyen = '$id'";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $name = $row['ten_quyen'];
    }
    return $name;
}

?>