<?php

include('includes/header.php');
include('includes/database.php');
if(isset($_POST['ma_bai_thi']) && isset($_POST['ma_de_thi'])) {
    $ma_de_thi = $_POST['ma_de_thi'];
    $ma_bai_thi = $_POST['ma_bai_thi'];
}
?>


<div class="container">
    <form action="ket_qua.php" method = "POST">
    <?php 
    $query = "select ch.* from chi_tiet_de_thi ctdt 
    join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi 
    join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi 
    where dt.ma_de_thi = $ma_de_thi";
    $select_cauhoi = mysqli_query($connect,$query);
    $i = 0;  
    while($row = mysqli_fetch_assoc($select_cauhoi)) {
        $i++;
        $ma_cau_hoi = $row['ma_cau_hoi'];
        $noi_dung = $row['noi_dung'];
        echo '
        <div class="question mb-3">';
        $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
        $select_cautl = mysqli_query($connect,$query2); 
        while($row2 = mysqli_fetch_assoc($select_cautl)) { 
            $la_dap_an = $row2['la_dap_an'];
            $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
            echo '<div class="row mb-2">'. 'Câu ' . $i . ': ' . $noi_dung .'</div>'; 
            echo '<div role="group" aria-label="Basic radio toggle button group">';
            $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
            $select_cautl = mysqli_query($connect,$query2); 
            $index = 0;
            while($row2 = mysqli_fetch_assoc($select_cautl)) {
                ++$index;
                $la_dap_an = $row2['la_dap_an'];
                $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
                $noi_dung_ctl = $row2['noi_dung'];
                
                switch($index) {
                    case 1: 
                        echo
                        '   
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> A </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 2: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> B </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 3: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> C </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                    case 4: 
                        echo
                        '
                            <div class="d-flex flex-row gap-2 mb-1 align-items-center">
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> D </label>
                                <div>' . $noi_dung_ctl. '</div>
                            </div>
                        ';
                    break;
                }
            }
        }
        echo '
        </div>
        ';
    }

    echo '</div>';
    ?>
    <div class="button-submit">
        <input class="btn btn-primary" type="submit" name="submit" value = "Submit">
    <div>
</form>
</div>


<?php
    include('includes/footer.php');
?>