<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionMonHoc.php');
include('includes/functionDeThi.php');
include('includes/functions.php');

$limit = '5';
$page = 1;
$ma_lop = $_SESSION['ma_lop'];

if(isset($_POST['page']) && $_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}

$query = "SELECT 
users.id, 
users.ho_va_ten, 
users.ngay_sinh, 
users.gioi_tinh, 
users.email
FROM 
`users`
JOIN 
`chi_tiet_lop` ctl ON users.id = ctl.user_id
JOIN 
`chi_tiet_quyen` ctq ON users.id = ctq.user_id 
JOIN 
`quyen` q ON ctq.ma_quyen = q.ma_quyen
WHERE 
ctl.ma_lop = $ma_lop 
AND users.trang_thai = 1
AND q.ten_quyen = 'giao_vien'";

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= ' AND users.ho_va_ten LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ';
}

$query .= ' ORDER BY users.ho_va_ten ASC ';

$filter_query = $query . ' LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$statement->store_result();
$total_data = $statement->num_rows;

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->get_result(); // Get the result set
$total_filter_data = $result->num_rows; // Get the total number of rows fetched


$output = '
<table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Email</th>
            </tr>
        </thead>
';

if($total_data > 0) {   
    $start_index = ($page - 1) * $limit + 1;
    $stt = 0;
    foreach($result as $row) {
        $stt += 1;
        $output .= '<tbody>';
            $output .= "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['ho_va_ten'] . "</td>
                            <td>" . ($row['gioi_tinh'] == 1 ? 'Nam' : 'Nữ') . "</td>
                            <td>" . $row['ngay_sinh'] . "</td>
                            <td>" . $row['email'] . "</td>
                        </tr>";
        }
        $output .= '</tbody>';
    
} else {
    $output .= '
    <tr>
        <td colspan="5" align="center">No Data Found</td>
    </tr>';
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