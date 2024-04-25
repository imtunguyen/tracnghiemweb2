<?php
include('../includes/database.php');
require_once('../includes/quyen_functions.php');
$limit = '5';
$page = 1;
if($_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "SELECT * FROM users WHERE trang_thai = 1 ";

if($_POST['query'] != '')
{
  $query .= '
  and username LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" 
  ';
}

$query .= ' ORDER BY id ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$statement->store_result();
$total_data = $statement->num_rows;

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->get_result();
$total_filter_data = $result->num_rows; 

$output = '
<table class="table table-bordered table-striped align-middle text-center">
<thead>
    <tr>
        <th>userID</th>
        <th>Ảnh</th>
        <th>Username</th>
        <th>Quyền</th>
        <th></th>
    </tr>';
if($total_data > 0)
{
  foreach($result as $row)
  {
    $ten_quyen = getTenQuyen($connect, $row["id"]);
    $output .= '
    <tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["avatar"].'</td>
      <td>'.$row["username"].'</td>
      <td><a style="color: green;" href="nguoidung.php?view_roles&user_id='.$row["id"].'">'.$ten_quyen.'</a></td>
      <td><a class="delete_user" style="color: red;" href="nguoidung.php?delete='.$row["id"].'" id="'.$row['username'].'">Delete</a></td>
    </tr>
    ';
  }
}

$output .= '
</thead>
</table>
<br />
<div style="display: flex; justify-content: center;">
  <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

if($total_links > 4)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}

if($total_links > 0) 
{
  for($count = 0; $count < count($page_array); $count++)
  {
    if($page == $page_array[$count])
    {
      $page_link .= '
      <li class="page-item active" style = "pointer-events: none;">
        <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only"></span></a>
      </li>
      ';

      $previous_id = $page_array[$count] - 1;
      if($previous_id > 0)
      {
        $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
      }
      else
      {
        $previous_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Previous</a>
        </li>
        ';
      }
      $next_id = $page_array[$count] + 1;
      if($next_id >= $total_links)
      {
        $next_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Next</a>
        </li>
          ';
      }
      else
      {
        $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
      }
    }
    else
    {
      if($page_array[$count] == '...')
      {
        $page_link .= '
        <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
        </li>
        ';
      }
      else
      {
        $page_link .= '
        <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
        ';
      }
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

<script>
$(document).ready(function() {
  $("a.delete_user").on("click", function(event) {
    var id = $(this).attr('id');
    if (confirm("Bạn Muốn Xóa Người Dùng " + id + "?")) {
    } else {
      event.preventDefault(); 
    }
  });
});
</script>