<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/functions.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');

$limit = 5; // Number of records per page
$page = 1;
$start = 0;

if(isset($_POST['page']) && $_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
}

$searchText = $_POST['query'] ?? '';
$monHoc = $_POST['mon_hoc'] ?? '';
$doKho = $_POST['do_kho'] ?? '';

$query = "SELECT * FROM cau_hoi WHERE trang_thai=1 AND ma_nguoi_tao=" . $_SESSION['userId'];

if($searchText != '') {
    $query .= " AND noi_dung LIKE '%$searchText%'";
}

if($monHoc != '') {
    $query .= " AND ma_mon_hoc = '$monHoc'";
}

if($doKho != '') {
    $query .= " AND do_kho = '$doKho'";
}

$filter_query = $query . " LIMIT $start, $limit";

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

if($total_filter_data > 0) {
    $start_index = ($page - 1) * $limit + 1;
    while ($row = $result->fetch_assoc()) {
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
        modalChitietCH($connect, $row['ma_cau_hoi'], $modalID, $_SESSION['userId']); 
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

$total_links = ceil($total_data / $limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 1) {
    // Hiển thị nút Previous
    if($page > 1) {
        $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page - 1) . '">Previous</a></li>';
    } else {
        $previous_link = '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }

    // Hiển thị danh sách các trang
    $page_array = [];
    $start_page = max(1, $page - 2);
    $end_page = min($total_links, $page + 2);

    if ($start_page > 1) {
        $page_array[] = 1;
        if ($start_page > 2) {
            $page_array[] = '...';
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $page_array[] = $i;
    }

    if ($end_page < $total_links) {
        if ($end_page < $total_links - 1) {
            $page_array[] = '...';
        }
        $page_array[] = $total_links;
    }

    foreach ($page_array as $page_num) {
        if ($page_num == '...') {
            $page_link .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        } else if ($page_num == $page) {
            $page_link .= '<li class="page-item active"><a class="page-link" href="#">' . $page_num . ' <span class="sr-only"></span></a></li>';
        } else {
            $page_link .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . $page_num . '">' . $page_num . '</a></li>';
        }
    }

    // Hiển thị nút Next
    if($page < $total_links) {
        $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page + 1) . '">Next</a></li>';
    } else {
        $next_link = '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>
</div>';

echo $output;
?>
