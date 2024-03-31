<?php
include('../includes/database.php');
include('../includes/functionMonHoc.php');
$limit = '5';
$page = 1;

if(isset($_POST['page']) && $_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
} else {
    $start = 0;
}

$query = "SELECT * FROM mon_hoc WHERE trang_thai = 1";

if(isset($_POST['query']) && $_POST['query'] != '') {
    $query .= ' AND ten_mon_hoc LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" ';
}

$query .= ' ORDER BY ma_mon_hoc ASC ';

$filter_query = $query . ' LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$statement->store_result();
$total_data = $statement->num_rows;

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->get_result(); // Get the result set
$total_filter_data = $result->num_rows; // Get the total number of rows fetched



$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 1) {
    if($page > 1) {
        $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.($page - 1).'">Previous</a></li>';
    } else {
        $previous_link = '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }
    
    if($page < $total_links) {
        $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.($page + 1).'">Next</a></li>';
    } else {
        $next_link = '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }
    
    for($count = 1; $count <= $total_links; $count++) {
        if($count == $page) {
            $page_link .= '<li class="page-item active"><a class="page-link" href="#">'.$count.' <span class="sr-only"></span></a></li>';
        } else {
            $page_link .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$count.'">'.$count.'</a></li>';
        }
    }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>
</div>
';

echo $output;
?>
