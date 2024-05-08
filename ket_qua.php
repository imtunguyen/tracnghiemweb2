<?php

include('includes/header.php');
include('includes/database.php');

?>

<?php 
    if(isset($_POST['submit'])) {
        $query = "SELECT ch.* from chi_tiet_de_thi ctdt join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi where dt.ma_de_thi = 1";
        $select_socauhoi = mysqli_query($connect,$query);
        $tong = mysqli_num_rows($select_socauhoi); 
        //so cau dung
        $d = 0;
        $s = 0;
        while($row = mysqli_fetch_assoc($select_socauhoi)) {
            $ma_cau_hoi = $row['ma_cau_hoi'];

            if(isset($_POST["$ma_cau_hoi"])) {
                $check = $_POST["$ma_cau_hoi"];
                if($check == '1') {
                    ++$d;
                }
                if($check == '0') {
                    ++$s;
                }
            }
        }
        $cc = $tong - ($d + $s);
        $diem_cua_1_cau_dung = 10 / $tong;
        $diem = $diem_cua_1_cau_dung * $d;
        if(isset($_POST['ma_bai_thi'])) {
            $ma_bai_thi = $_POST['ma_bai_thi'];
        }
        $user_id = $_SESSION['userId'];
        $sql_insert = "INSERT INTO ket_qua(ma_bai_thi, user_id, so_cau_dung, 
        so_cau_sai, so_cau_chua_chon, diem) VALUES 
        ($ma_bai_thi, $user_id, $d, $s, $cc, $diem)";
        $res_insert = mysqli_query($connect, $sql_insert);
    }

?>
<div class="container">
    <h1 class="text-center mb-5">
        Kết quả làm bài
    </h1>
    <div class="row gap-5 m-auto justify-content-center">
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-4">
                    <img src="./images/de_thi.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1 fs-4 ">Số câu đúng</p>
                        <p class="m-0 fs-3 fw-bold"><?php echo $d; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-4">
                    <img src="./images/dtb.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1 fs-4 ">Số câu sai</p>
                        <p class="m-0 fs-3 fw-bold"><?php echo $s; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-4">
                    <img src="./images/dcao.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1 fs-4 ">Số câu chưa chọn</p>
                        <p class="m-0 fs-3 fw-bold"><?php echo $cc  ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center rounded" style="height: 120px; width: 325px; background-color: #d3d3d3">
                <div class="d-flex align-items-center justify-content-center gap-4">
                    <img src="./images/dcao.png" alt="">
                    <div class="d-flex flex-column justify-content-center">
                        <p class="mb-1 fs-4">Kết quả</p>
                        <p class="m-0 fs-3 fw-bold"><?php echo $diem . " (Điểm)"  ?></p>
                    </div>
                </div>
            </div>
        </div>
        
</div>