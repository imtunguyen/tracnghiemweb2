<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/functions.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

$limit = 5;
$page = 1;

if(isset($_POST['page']) && $_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}

$query = "SELECT * FROM cau_hoi WHERE trang_thai = 1 AND ma_nguoi_tao = " .$_SESSION['userId'];

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= " AND noi_dung LIKE '%" . str_replace(' ', '%', $_POST['query']) . "%' ";
}

$query .= " ORDER BY ma_cau_hoi ASC ";

$filter_query = $query . " LIMIT " . $start . ", " . $limit;

$statement = $connect->prepare($query);
$statement->execute();
$statement->store_result();
$total_data = $statement->num_rows;

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->get_result();
$total_filter_data = $result->num_rows; 

$output = '
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>STT</th>
        <th>Nội dung câu hỏi</th>
        <th>Sửa | Xóa</th>
    </tr>
    </thead>
';

if($total_data > 0) {
    $start_index = ($page - 1) * $limit + 1;
    foreach($result as $row) {
        $modalID = "chiTietModal" . $start_index;
        $modalXoaID = "xoaModal" . $start_index;
        
        $output .= '
        <tbody data-bs-toggle="modal" data-bs-target="#' . $modalID . '">
            <td>' . $start_index++ . '</td>
            <td>' . $row['noi_dung'] . '</td>
            <td>
                <div class=" btn-group" role="group">';
                if(check($connect, $_SESSION['userId'], 'sua_cauhoi')) {
                $output .= '
                    <a class=" btn btn-warning mx-2 " href="../giaovien/cauhoi_edit.php?id=' . $row['ma_cau_hoi'] . '">
                        <i class=" bi bi-pencil-square"></i> Sửa
                    </a>';
                }
                if(check($connect, $_SESSION['userId'], 'xoa_cauhoi')) {
                    $output .= '
                    <a class=" btn btn-danger mx-2 " data-bs-toggle="modal" data-bs-target="#' . $modalXoaID . '">
                        <i class="bi bi-trash"></i> Xóa
                    </a>';
                } 
                    $output .= '
                </div>
            </td>
        </tbody>';

        modalXoaCH($row['ma_cau_hoi'], $modalXoaID);
        modalChitietCH($connect, $row['ma_cau_hoi'], $modalID); 
    }
} else {
    $output .= '
    <tr>
        <td colspan="3" align="center">No Data Found</td>
    </tr>
    ';
}

$output .= '
</table>
<br />
<label>Tổng:  ' . $total_data . '</label>
<div align="center">
    <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 1) {
    // Hiển thị nút Previous
    if($page > 1) {
        $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page - 1) . '">Previous</a></li>';
    } else {
        $output .= '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }
    
    // Hiển thị danh sách các trang
    $range = 2; 
    $initial_num = max(2, $page - $range+2);
    $last_num = min($page + $range, $total_links - 1);

    $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="1">1</a></li>'; // Trang đầu tiên

    if($initial_num > 2) {
        $output .= '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Dấu "..." nếu có nhiều trang
    }

    for($count = $initial_num; $count <= $last_num; $count++) {
        if($count == $page) {
            $output .= '<li class="page-item active"><a class="page-link" href="#">' . $count . ' <span class="sr-only"></span></a></li>';
        } else {
            $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $count . '">' . $count . '</a></li>';
        }
    }

    if($last_num < $total_links - 1) {
        $output .= '<li class="page-item disabled"><span class="page-link">...</span></li>'; // Dấu "..." nếu có nhiều trang
    }

    if($total_links > 1) {
        $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $total_links . '">' . $total_links . '</a></li>'; // Trang cuối cùng
    }

    // Hiển thị nút Next
    if($page < $total_links) {
        $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page + 1) . '">Next</a></li>';
    } else {
        $output .= '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>
</div>';

echo $output;
