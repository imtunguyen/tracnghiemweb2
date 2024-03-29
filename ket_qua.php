<?php

include('includes/header.php');
include('includes/database.php');

?>

<?php 
    if(isset($_POST['submit'])) {
        $query = "select ch.* from chi_tiet_de_thi ctdt join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi where dt.ma_de_thi = 1";
        $select_socauhoi = mysqli_query($connect,$query);  
        //so cau dung
        $d = 0;
        while($row = mysqli_fetch_assoc($select_socauhoi)) {
            $ma_cau_hoi = $row['ma_cau_hoi'];

            if(isset($_POST["$ma_cau_hoi"])) {
                $check = $_POST["$ma_cau_hoi"];
                if($check == '1') {
                    ++$d;
                }
            }
        }

        echo "so cau dung: " . $d;
    }
?>