<?php
function getLopHoc($connect){
    $stm=$connect->prepare('SELECT * from lop where trang_thai = 1');
    $stm->execute();
    $result=$stm->get_result();
    return $result;
}
function CreateMaMoi() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random = '';
    for ($i = 0; $i < 10; $i++) {
        $random .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random;
}

function CheckMaMoi($connect){
    $random=CreateMaMoi();
    $stm=$connect ->prepare('SELECT COUNT(*) AS count FROM lop WHERE ma_moi = ?');
    $stm->bind_param('s',$random);
    $stm->execute();
    $result = $stm->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $stm->close();
    if($count > 0){
        return CheckMaMoi($connect);
    }else{
        return $random;
    }
}


function addLopHoc($connect,$ten_lop, $trang_thai){
    $ma_moi=CheckMaMoi($connect);
    $stm=$connect->prepare('INSERT INTO lop (ten_lop, trang_thai,ma_moi ) Values (? ,?,?)');
    $stm->bind_param('sis',$ten_lop, $trang_thai, $ma_moi);
    $stm->execute();
    $stm->close();
}
function updateLopHoc($connect,$ten_lop,$ma_lop){
    $stm=$connect->prepare('UPDATE lop set ten_lop=? where ma_lop=?');
    $stm->bind_param('si', $ten_lop, $ma_lop);
    $stm->execute();
    $stm->close();
}
function deleteLopHoc($connect, $ma_lop){
    $stm=$connect->prepare('UPDATE lop set trang_thai=0 where ma_lop=?');
    $stm->bind_param('i',$ma_lop);
    $stm->execute();
    $stm->close();
}
function getlophocByID($connect, $ma_lop){
    $stm = $connect->prepare('SELECT ten_lop FROM lop WHERE ma_lop = ?');
    $stm->bind_param('i', $ma_lop);
    $stm->execute();
    $result = $stm->get_result(); 
    return $result;
}

function searchLopHoc($connect, $search){
    $stm = $connect->prepare("SELECT * FROM lop WHERE trang_thai = 1 AND ten_lop LIKE '%$search%'");
    $stm->execute();
    $result = $stm->get_result();
    return $result;
}
function xoaLopHoc($ma_lop,$modalXoaID){
    ?>
    <div class="modal fade" id="<?php echo $modalXoaID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận xóa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn muốn xóa lớp học này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a class=" btn btn-danger mx-2" href="../admin/lophoc.php?delete=<?php echo $ma_lop; ?>">Xóa Lớp Học</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}