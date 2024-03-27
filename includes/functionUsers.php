<?php

function getUsername($connect, $usernameOrEmail)
{
    $stm = $connect->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stm->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    return $result;
}

function updatePassword($connect, $usernameOrEmail, $password)
{
    $stm = $connect->prepare('UPDATE users SET mat_khau = ? WHERE username = ? OR email = ?');
    $stm->bind_param('sss', $password, $usernameOrEmail, $usernameOrEmail);
    $stm->execute();
    $stm->close();
}

function random_number($length = 6)
{
    $min = pow(10, $length - 1);
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}
