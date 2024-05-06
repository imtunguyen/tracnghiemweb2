<?php
include '../includes/config.php';
include '../includes/database.php';
include '../includes/functionCauHoi.php';
include '../includes/functionMonHoc.php';

if(isset($_GET['search_text']) && isset($_GET['mon_hoc']) && isset($_GET['do_kho'])) {
    $searchText = $_GET['search_text'];
    $monHoc = $_GET['mon_hoc'];
    $doKho = $_GET['do_kho'];

    $results = searchCauHoitrongDeThi($connect, $searchText, $monHoc, $doKho);

    if (!empty($results)) {
        echo '<table class="table-striped" id="t_draggable1">';
        echo '<tbody class="t_sortable">';
        $stt = 1;
        echo '<tr>';
        echo     '<th>STT</th>';
        echo     '<th>Nội dung câu hỏi</th>';
        echo '</tr>';
        foreach ($results as $cauHoi) {
            echo '<tr>';
            echo '<td>' . $stt++ . '</td>';
            echo '<td>' . $cauHoi['noi_dung'] . '</td>';
            echo '<input type="hidden" name="ma_cau_hoi[]" value="' .$cauHoi['ma_cau_hoi'] .'">';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Không tìm thấy câu hỏi phù hợp.</p>';
    }
}
