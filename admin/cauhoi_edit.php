<?php
include('../includes/config.php');
include('../includes/database.php');
include('../includes/admin_header.php');
include('../includes/functionCauHoi.php');
include('../includes/functionCauTraLoi.php');
include('../includes/functionMonHoc.php');


if(isset($_POST['cau_hoi'])){
    $trang_thai =1;
    $ma_nguoi_tao =1;
    $ma_mon_hoc = $_POST['ma_mon_hoc'];
    $do_kho = $_POST['do_kho'];
    $noi_dung = $_POST['cau_hoi'];
    $ma_cau_hoi = $_GET['id'];
    updateCauHoi($connect, $ma_cau_hoi, $noi_dung, $trang_thai, $ma_nguoi_tao, $ma_mon_hoc, $do_kho);

    if(isset($_POST['cau_tra_loi'])){
        echo 'dap an dung'. $dap_an_dung = intval($_POST['flexRadioDefault']) . '<br>';
        foreach($_POST['cau_tra_loi'] as $index => $cau_tra_loi){
            echo 'cac cau tra loi '.$cau_tra_loi;
            
            $id = $index+1;
            echo 'id: '. $id;
            echo 'flexRadioDefault: ' . $_POST['flexRadioDefault'] . '<br>'; 
            echo " dap an " . $dap_an = ($_POST['flexRadioDefault'] ==   $id) ? 1 : 0 . '<br>';
            updateCauTraLoi($connect, $ma_cau_hoi, $cau_tra_loi, $dap_an);
           
        }
        $_SESSION['toastr'] = 'Sửa câu hỏi thành công';
        header('Location: cauhoi.php');
    }
    
}
if(isset($_GET['id'])){
    $cauhoi = getCauHoibyID($connect, $_GET['id']);
    $cauhoi_record = $cauhoi->fetch_assoc();
    $ma_mon_hoc = $cauhoi_record['ma_mon_hoc'];
    $monhoc = getMonHoc($connect);
    $ten_mon_hoc = getmonhocByID($connect,  $ma_mon_hoc);
    $cautraloi = getCauTraLoi($connect, $_GET['id']);
    if($cauhoi->num_rows >0){



?>

<div class="w-100 card border-0 p-4">
    <div class="card-header bg-success bg-gradient ml-0 py-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white py-2">Sửa câu hỏi</h2>
            </div>
        </div>
    </div>
    <div class="card-body border p-4">
        <div class="pb-3">
            <p>Câu hỏi</p>
        </div>
        <form method="post" class="row">
            <div class="row pb-3">
                <div class="col-5">
                <select class="form-select" name="ma_mon_hoc">
                    <option>--Chọn môn học--</option>
                    <?php
                    while($monhoc_record = $monhoc->fetch_assoc()){
                        if($monhoc_record['ma_mon_hoc'] == $cauhoi_record['ma_mon_hoc']) {
                            echo '<option value="' . $monhoc_record['ma_mon_hoc'] . '" selected>' . $monhoc_record['ten_mon_hoc'] . '</option>';
                        } else {
                            echo '<option value="' . $monhoc_record['ma_mon_hoc'] . '">' . $monhoc_record['ten_mon_hoc'] . '</option>';
                        }
                    }
                    ?>
                </select>
                </div>
                <div class="col-4">
                <select class="form-select" name="do_kho">
                    <option>--Chọn độ khó--</option>
                    <?php
                    $do_kho_values = array('Dễ', 'Trung bình', 'Khó');
                    foreach ($do_kho_values as $value) {
                        if ($value == $cauhoi_record['do_kho']) {
                            echo '<option value="' . $value . '" selected>' . $value . '</option>';
                        } else {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
                </div>
               
            </div>
            <div class="p-3 pt-0">
            <div id="fileContent">
                
            </div>
                <div class="input-group align-items-center">
                    <div class="form-floating py-1 col-12">

                        <input type="text" class="form-control border shadow" id="floatingInput" placeholder="Nội dung" name="cau_hoi"  value="<?php echo $cauhoi_record['noi_dung'];?>">
                        <label for="floatingInput" class="ms-2" >Nội dung</label>
                    </div>
                    <div class="input-group-text btn">
                        <i class="bi bi-card-image"></i>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <p>Câu trả lời</p>
                <select class="form-select" name="" id="answerCount">
                    <option>--Chọn số câu trả lời--</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div id="answerContainer">
            <?php 
                $i = 0;
                while($cautraloi_record = $cautraloi->fetch_assoc()){
                    echo "<div class='p-3 pt-0'>";
                    echo "<div class='input-group'>";
                    echo "<div class='input-group-text btn'>";
                    echo "<input class='form-check-input' type='radio' value='" . ($i+1) . "' name='flexRadioDefault' id='flexRadioDefault" . ($i+1) . "'";
                    if ($cautraloi_record['la_dap_an'] == 1) echo ' checked'; // Kiểm tra và thêm 'checked' nếu là đáp án
                    echo ">";
                    echo "</div>";
                    echo "<input type='text' class='form-control' name='cau_tra_loi[]' id='cau_tra_loi{$cautraloi_record['ma_cau_tra_loi']}' value='{$cautraloi_record['noi_dung']}'>";
                    echo "<div class='input-group-text'><i class='bi bi-card-image'></i></div>";
                    echo "</div>";
                    echo "</div>";
                    $i++;
                }
                ?>
            </div>

            <div class="row pt-2">
                <div class="col-6 col-md-3">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Sửa
                    </button>
                </div>
                <div class="col-6 col-md-3">
                    <a class="btn btn-secondary w-100" href="../admin/cauhoi.php">
                        <i class="bi bi-x-circle"></i> Trở về
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
    }

}
include('../includes/admin_footer.php');
?>
