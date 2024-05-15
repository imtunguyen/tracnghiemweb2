<?php
function getCauHoibyID($connect, $id, $ma_nguoi_tao) {
    $stm = $connect->prepare('SELECT * FROM cau_hoi WHERE ma_cau_hoi =? AND ma_nguoi_tao = ?');
    $stm->bind_param('ss', $id, $ma_nguoi_tao);
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function getCauHoi($connect) {
    $stm = $connect->prepare('SELECT * FROM cau_hoi WHERE trang_thai =1');
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function addCauHoi($connect, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho){
    $stm = $connect->prepare('INSERT INTO cau_hoi (noi_dung, trang_thai, ma_nguoi_tao, ma_mon_hoc, do_kho) VALUES (?,?,?,?,?)');
        $stm->bind_param('sssss', $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho);
        $stm->execute();
        $stm->close();
}
function updateCauHoi($connect, $ma_cau_hoi, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho){
    $stm = $connect->prepare('UPDATE cau_hoi SET noi_dung = ?, trang_thai = ?, ma_nguoi_tao = ?, ma_mon_hoc = ?, do_kho = ? WHERE ma_cau_hoi = ?');
    $stm->bind_param('ssssss', $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho, $ma_cau_hoi);
    $stm->execute();
    $stm->close();
}

function getLastCauHoi($connect){
    $stm = $connect->prepare('SELECT * FROM cau_hoi WHERE trang_thai = 1 ORDER BY ma_cau_hoi DESC LIMIT 1');
    $stm->execute();
    $result = $stm->get_result();
    $stm->close();
    return $result;
}
function deleteCauHoi($connect, $ma_cau_hoi){
    $stm = $connect->prepare('UPDATE cau_hoi SET trang_thai = 0 WHERE ma_cau_hoi = ?');
        $stm->bind_param('i', $ma_cau_hoi);
        $stm->execute();
        $stm->close();
    
}
function searchCauHoi($connect, $search){
    $stm = $connect->prepare("SELECT * FROM cau_hoi WHERE trang_thai = 1 AND noi_dung LIKE '%$search%'");
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function searchCauHoitrongDeThi($connect, $searchText, $monHoc, $doKho,$madethi) {
    $sql = "SELECT * FROM cau_hoi WHERE trang_thai=1 AND (noi_dung LIKE '%$searchText%') AND ma_cau_hoi NOT IN(SELECT ma_cau_hoi FROM chi_tiet_de_thi WHERE ma_de_thi = $madethi ) ";

    if ($monHoc !== '') {
        $sql .= " AND ma_mon_hoc = '$monHoc'";
    }
    if ($doKho !== '') {
        $sql .= " AND do_kho = '$doKho'";
    }
    $result = $connect->query($sql);
    $cauHoiList = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cauHoiList[] = $row;
        }
    }
    return $cauHoiList;
}


function modalXoaCH($ma_cau_hoi, $modalXoaID){
    ?>
    <div class="modal fade" id="<?php echo $modalXoaID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận xóa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn muốn xóa câu hỏi này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a class=" btn btn-danger mx-2" href="../giaovien/cauhoi.php?delete=<?php echo $ma_cau_hoi; ?>">Xóa Câu Hỏi</a>
            </div>
        </div>
    </div>
</div>
<?php
}
function modalChitietCH($connect, $ma_cau_hoi, $modalID, $ma_nguoi_tao){
    ?>
    <div class="modal fade" id="<?php echo $modalID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chi tiết câu hỏi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <?php 
                $result = getCauHoibyID($connect, $ma_cau_hoi, $ma_nguoi_tao);
                $result1 = getCauTraLoi($connect, $ma_cau_hoi);

                $record = $result->fetch_assoc();
                echo "Câu hỏi: ". $record['noi_dung']. "<br>";
                while($record1 = $result1->fetch_assoc()){
                    if($record1['la_dap_an'] ==1){
                        ?>
                        <div class="btn bg-success" style="width: 100%; color:aliceblue">
                        <?php
                        echo $record1['noi_dung'];
                        ?>
                        </div><br>
                        <?php

                    }
                    else{
                        ?>
                        <div class="btn bg-body-secondary" style="width: 100%;">
                        <?php
                        echo $record1['noi_dung'];
                        ?>
                        </div><br>
                        <?php

                    }
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div><?php
}

