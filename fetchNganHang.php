<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/functionUsers.php');
include('includes/functionDeThi.php');
include('includes/functionChiTietDeThi.php');
$limit = 5;
$page = 1;

if(isset($_POST['page']) && $_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}
$ma_nguoi_tao =  $_SESSION['userId'];

$query = "SELECT * FROM de_thi WHERE trang_thai = 1 AND ma_nguoi_tao != '$ma_nguoi_tao'";

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= " AND ten_de_thi LIKE '%" . str_replace(' ', '%', $_POST['query']) . "%' ";
}

$query .= " ORDER BY ten_de_thi ASC ";

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
        <th>Tên đề thi</th>
        <th>Người tạo</th>
        <th>Chọn</th>
    </tr>
    </thead>
';

if($total_data > 0) {
    $start_index = ($page - 1) * $limit + 1;
    foreach($result as $row) {
        $modalID = "chiTietModal" . $start_index;
        $users = getUsernamebyID($connect, $row['ma_nguoi_tao']);
        $user = $users->fetch_assoc();
        $output .= '
        <tbody>
            <td>' . $start_index++ . '</td>
            <td>' . $row['ten_de_thi'] . '</td>
            <td>' . $user['ho_va_ten'] . '</td>
            <td>
                <div class=" btn-group" role="group">';

                    $output .= '
                    <a class=" btn btn-warning mx-2 " data-bs-toggle="modal" data-bs-target="#' . $modalID . '">
                        <i class="bi bi-gear-fill"></i> Xem Chi Tiết
                    </a>
                    <form action="baithi_add.php" method="post">
                        <input type="hidden" name="ma_de_thi" value="'.$row['ma_de_thi'].'">
                        <input type="hidden" name="ma_lop" value="'.$_SESSION['ma_lop'].'">
                       <button class=" btn btn-primary mx-2 " type="submit">
                        <i class="bi bi-check-circle"></i> Chọn đề thi</button> 
                    </form>';
                    $output .= '
                </div>
            </td>
        </tbody>';

        modalChitietDT($connect, $row['ma_de_thi'], $modalID); 
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
?>
<script src="js/bootstrap.min.js"></script>