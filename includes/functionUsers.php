<?php


function getUsername($connect, $usernameOrEmail)
{
    $stm = $connect->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stm->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    return $result->fetch_assoc();
}
function getUsernamebyID($connect, $userId)
{
    $stm = $connect->prepare('SELECT * FROM users WHERE id = ?');
    $stm->bind_param('i', $userId);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    return $result;
    
}
function getImage($connect, $userId)
{
    $stm = $connect->prepare('SELECT * FROM users WHERE id = ?');
    $stm->bind_param('s', $userId);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['avatar'];
    } else {
        return null;
    }
    
}

function updatePassword($connect, $usernameOrEmail, $password)
{
    $stm = $connect->prepare('UPDATE users SET mat_khau = ? WHERE username = ? OR email = ?');
    $stm->bind_param('sss', $password, $usernameOrEmail, $usernameOrEmail);
    $stm->execute();
    $stm->close();
}


function random_number($length) {
    $min = pow(10, $length -1);
    $max = pow(10,$length)-1;
    return rand($min, $max);
}

function deleteNguoiDung($connect, $id) {
    $query = "UPDATE users ";
    $query .= "SET trang_thai = 0 WHERE id = $id ";

    $create_query = mysqli_query($connect, $query); 
}

