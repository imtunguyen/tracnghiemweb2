<?php 
include('includes/database.php');
include('includes/functionLopHoc.php');
$limit='8';
$page=1;

if(isset($_POST['page']) && $_POST['page'] > 1){
    $start=(($_POST['page'] - 1) * $limit);
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

$output = '<div class="row">'; // Bắt đầu một hàng mới

if($total_data > 0){
    $start_index = ($page - 1) * $limit + 1;
    foreach($result as $row){
        $modalXoaID = "xoaModal" . $start_index;
        $output .= '
            <div class="col-md-3">
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white border-dark">
                        <h5 class="card-title text-center">'.$row["ten_lop"].'</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Mã mời: '.$row["ma_moi"].'</p>
                        <div class="btn-group" role="group">
                            <a class="btn btn-success" href="giaovien/vaolop.php?id=' . $row['ma_lop'] . '" >
                                <i class="bi bi-pencil-square"></i> Vào lớp
                            </a>
                            <a class="btn btn-warning" href="giaovien/lophoc_edit.php?id=' . $row['ma_lop'] . '">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#' . $modalXoaID . '">
                                <i class="bi bi-trash"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        xoaLopHoc($row['ma_lop'],$modalXoaID);
        // Chú ý: Đây là cách đánh STT cho từng grid, bắt đầu từ 1
        $start_index++;
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
<label>Tổng:  '.$total_data.'</label>
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
    $range = 2; // Số lượng trang hiển thị trước và sau trang hiện tại (tổng cộng 8 trang)
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
</div>
';

echo $output;
?>