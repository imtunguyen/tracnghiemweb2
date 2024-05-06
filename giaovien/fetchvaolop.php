<?php 
include('../includes/database.php');
include('../includes/functionBaiThi.php');
include('../includes/config.php');
include('../includes/functionDeThi.php');
include('../includes/functions.php');

$dsbaithi = loadBaiThi($connect, $_SESSION['ma_lop']);
$dsbaithi_record = $dsbaithi->fetch_all(MYSQLI_ASSOC);
$limit='5';
$page=1;

if(isset($_POST['page']) && $_POST['page'] > 1){
    $start=(($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}

$output = '
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên đề thi</th>
        <th>Sửa | Chi Tiết | Xóa</th>
    </tr>
    </thead>
';
$total_data = 0;
foreach ($dsbaithi_record as $record) {
    $ma_de_thi = $record['ma_de_thi'];
    $query = "SELECT * FROM de_thi WHERE trang_thai = 1 AND ma_de_thi = $ma_de_thi";

    if(isset($_POST['query']) && $_POST['query'] != '') {
        $query .= ' AND ten_de_thi LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ';
    }

    $query .= ' ORDER BY ten_de_thi ASC ';
    $filter_query = $query . ' LIMIT '.$start.', '.$limit.'';

    $statement = $connect->prepare($query);
    $statement->execute();
    $statement->store_result();
    $total_data = $statement->num_rows;

    $statement = $connect->prepare($filter_query);
    $statement->execute();
    $result = $statement->get_result();
    $total_filter_data = $result->num_rows; 

    if($total_data > 0) {   
        $start_index = ($page - 1) * $limit + 1;
        foreach($result as $row) {
            $modalID = "chiTietModal" . $start_index;
            $modalXoaID = "xoaModal" . $start_index;
            $output .= '
            <tbody data-bs-toggle="modal" data-bs-target="#' . $modalID . '">
                <td>'.$start_index++.'</td>
                <td>'.$row["ten_de_thi"].'</td>
                <td>
                    <div class=" btn-group" role="group">
                        <a class=" btn btn-success mx-2 " href="../giaovien/dethi_edit.php?id=' . $row['ma_de_thi'] . '">
                            <i class=" bi bi-pencil-square"></i> Sửa
                        </a>
                        <a class=" btn btn-warning mx-2 " href="../giaovien/dethi_chitiet.php?id=' . $row['ma_de_thi'] . '">
                            <i class=" bi bi-pencil-square"></i> Chi Tiết
                        </a>
                        <a class=" btn btn-danger mx-2 " data-bs-toggle="modal" data-bs-target="#' . $modalXoaID . '">
                            <i class="bi bi-trash"></i> Xóa
                        </a>
                    </div>
                </td>
            </tbody>';
            // modalXoaDeThi($row['ma_de_thi'], $modalXoaID); 
            // modalChitietDeThi($connect, $row['ma_de_thi'], $modalID); 
        }
    } else {
        $output .= '
        <tr>
            <td colspan="3" align="center">No Data Found</td>
        </tr>
        ';
    }
}

$output .= '
</table>
<br />
<label>Tổng:  '.$total_data.'</label>
<div align="center">
    <ul class="pagination">
';
$total_links = ceil($total_data/$limit);

if($total_links > 1) {
    // Hiển thị nút Previous
    if($page > 1) {
        $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page - 1) . '">Previous</a></li>';
    } else {
        $output .= '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }
    
    // Hiển thị danh sách các trang
    for($count = 1; $count <= $total_links; $count++) {
        if($count == $page) {
            $output .= '<li class="page-item active"><a class="page-link" href="#">' . $count . ' <span class="sr-only"></span></a></li>';
        } else {
            $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $count . '">' . $count . '</a></li>';
        }
    }

    // Hiển thị nút Next
    if($page < $total_links) {
        $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page + 1) . '">Next</a></li>';
    } else {
        $output .= '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }
}

$output .= '</ul></div>';

echo $output;
