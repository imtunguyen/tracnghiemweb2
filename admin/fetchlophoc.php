<?php 
include('../includes/database.php');
include('../include/functionLopHoc.php');
$limit='10';
$page=1;
if(isset($_POST['page'])&& $_POST['page'>1]){
    $start=(($_POST['page']-1)*$limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}
$query = "SELECT * FROM lop WHERE trang_thai = 1";

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= ' AND ten_lop LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ';
}
$query .= ' ORDER BY ma_lop ASC ';

$filter_query = $query . ' LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$statement->store_result();
$total_data = $statement->num_rows;

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->get_result(); 
$total_filter_data = $result->num_rows;
if($total_data>0){
    
}