<?php 
session_start();
include('includes/database.php');
include('includes/functionLopHoc.php');
include('includes/functions.php');
$limit='8';
$page=1;

function random_pastel_color()
{
    // Tạo một mã màu ngẫu nhiên nhạt
    $color = '#' . str_pad(dechex(mt_rand(0xaaaaff, 0xeeeeff)), 6, '0', STR_PAD_LEFT);
    return $color;
}

$userId = $_SESSION['userId'];

if(isset($_POST['page']) && $_POST['page'] > 1){
    $start=(($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}

$query = "SELECT l.`ma_lop`, l.`trang_thai`, l.`ma_moi`, l.`ten_lop`
FROM `lop` l
JOIN `chi_tiet_lop` ctl ON ctl.`ma_lop` = l.`ma_lop`
JOIN `users` u ON u.`id` = ctl.`user_id`
Where u.id= $userId";

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

$output = '<div class="row">';

if($total_data > 0) {
    foreach($result as $row)
    {
        $s = $row['trang_thai'] == 1 ? "Đang mở" : "Đã đóng";
        $background_color = random_pastel_color();
        $output .= '

        <form class="col-4 m-0 p-0" style="max-width: 380px;" action="chitietlophoc.php" method="GET">
          <button class="btn py-0" style="width:100%;" type="submit">
            <div class="row d-flex align-items-center justify-content-center rounded-top" style="background-color:'.$background_color.'; height:80px;">
              <h3 class="text-center">'.$row["ma_lop"]. '_'.$row["ten_lop"].'</h3>
            </div>
            <div class="row pt-3  rounded-bottom" style="box-shadow: 0 2.4rem 4.8rem rgba(0, 0, 0, 0.075); ">
              <p>Trạng thái: '.$s.'</p>
            <div>
            <input type="hidden" name="ma_lop" value="'. $row["ma_lop"] .'">
            <input type="hidden" name="ten_lop" value="'.$row["ten_lop"].'">
            <input type="hidden" name="ma_moi" value="'.$row["ma_moi"].'">
            ';

            if(check($connect, $_SESSION['userId'], 'sua_lophoc')) {
                $output .= 

                '
                <div class="btn-group">
                    <a href="lophoc.php?lophoc=edit&ma_lop='.$row["ma_lop"].'" class="btn btn-primary active">
                        <i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Edit
                    </a>
                </div>';
            }

            if(check($connect, $_SESSION['userId'], 'xoa_lophoc')) {
                $output .= 
                '
                <div class="btn-group">
                    <a href="lophoc.php?delete='.$row["ma_lop"].'" style="background-color: red; border: 2px solid red; color: white;
                    padding: 5px; border-radius: 10px; " class="delete_lophoc" id="'.$row["ten_lop"].'"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Delete
                    </a>
                </div>';

                
            }
          
        $output .=  
            '</button>
        </form>

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
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 1) {
    if($page > 1) {
$output .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="' . ($page - 1) . '">Previous</a></li>';
    } else {
        $output .= '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }
    
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
</div>
';

echo $output;
?>
<script>
$(document).ready(function() {
  $("a.delete_lophoc").on("click", function(event) {
    var id = $(this).attr('id');
    if (confirm("Bạn Muốn Xóa Lớp Học '" + id + "' Vĩnh Viễn?")) {
    } else {
      event.preventDefault(); 
    }
  });
});
</script>