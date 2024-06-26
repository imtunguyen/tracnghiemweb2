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

$query = "SELECT bt.ma_de_thi, bt.ma_bai_thi, bt.tg_bat_dau, bt.tg_ket_thuc, dt.thoi_gian_lam_bai, dt.ten_de_thi, dt.ma_mon_hoc, mh.ten_mon_hoc
FROM bai_thi bt
JOIN de_thi dt ON bt.ma_de_thi = dt.ma_de_thi JOIN mon_hoc mh ON mh.ma_mon_hoc = dt.ma_mon_hoc
WHERE bt.ma_lop = $ma_lop AND bt.trang_thai = 1 ";

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= ' AND dt.ten_de_thi LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ';
}

$query .= ' ORDER BY dt.ten_de_thi ASC ';

$filter_query = $query . ' LIMIT '.$start.', '.$limit;

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
        <th>Đề thi</th>
        <th>Môn học</th>
        <th>Thời gian bắt đầu</th>
        <th>Thời gian kết thúc</th>
        <th>Thời gian làm bài</th>
        <th>Hành động</th>
    </tr>
    </thead>';

if($total_data > 0) {   
    $start_index = ($page - 1) * $limit + 1;
    $stt = 0;

    foreach($result as $row) {
        $stt += 1;
        $tg_bat_dau_timestamp = strtotime($row['tg_bat_dau']);
        $tg_ket_thuc_timestamp = strtotime($row['tg_ket_thuc']);

    // Format Unix timestamps to display date and time in "ngày/tháng/năm giờ:phút:giây" format
        $tg_bat_dau_formatted = date("d/m/Y H:i:s", $tg_bat_dau_timestamp);
        $tg_ket_thuc_formatted = date("d/m/Y H:i:s", $tg_ket_thuc_timestamp);
        $output .= '<tbody>
        <tr>
            <td>' . $stt . '</td>
            <td>' . $row['ten_de_thi'] . '</td>
            <td>' . $row['ten_mon_hoc'] . '</td>
            <td>' . $tg_bat_dau_formatted . '</td>
            <td>' .$tg_ket_thuc_formatted . '</td>
            <td>' . $row['thoi_gian_lam_bai'] . '</td>
            <td>
                <div class="w-75 btn-group" role="group">';

        if(check($connect, $_SESSION['userId'], 'sua_dethi')) {
            $output .= '
                    <form action="baithi_sua.php" method="post">
                      <input type="hidden" name="ma_lop" value="' . $ma_lop . '">
                      <input type="hidden" name="ma_bai_thi" value="' . $row['ma_bai_thi'] . '">
                      <button class="btn btn-success mx-2" type="submit">Sửa</button>
                    </form>';
        }
        
        if(check($connect, $_SESSION['userId'], 'xoa_dethi')) {
            $output .= '
                    <form action="baithi_xoa.php" method="post">
                      <input type="hidden" name="ma_bai_thi" value="' . $row['ma_bai_thi'] . '">
                      <input type="hidden" name="ma_lop" value="' . $ma_lop . '">
                      <button class="btn btn-danger mx-2" type="submit">Xóa</button>
                    </form>';
        }
        
        if(check($connect, $_SESSION['userId'], 'lam_baithi')) {
            $output .= '
                    <form action="lambai.php" method="post">
                      <input type="hidden" name="ma_lop" value="' . $ma_lop . '">
                      <input type="hidden" name="ma_bai_thi" value="' . $row['ma_bai_thi'] . '">
                      <input type="hidden" name="ma_de_thi" value="' . $row['ma_de_thi'] . '">
                      <input type="hidden" name="thoi_gian_lam_bai" value="' . $row['thoi_gian_lam_bai'] . '">
                      <input type="hidden" name="ten_de_thi" value="' . $row['ten_de_thi'] . '">
                      <button class="btn btn-primary" type="submit">Làm bài</button>
                    </form>';
        }

        $output .= '
                </div>
            </td>
        </tr>
        <tbody>';
        
        $stt++;
    }
} else {
    $output .= '
    <tr>
        <td colspan="7" align="center">No Data Found</td>
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
