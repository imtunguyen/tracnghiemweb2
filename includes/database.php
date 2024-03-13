<?php
$connect = mysqli_connect('localhost', 'root', '301232', 'quan_ly_trac_nghiem');

if (mysqli_connect_errno()){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}