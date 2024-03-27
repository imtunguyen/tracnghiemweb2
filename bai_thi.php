<?php

include('includes/header.php');
include('includes/database.php');

?>

<?php 

    if(isset($_POST['nop_bai'])) {
        $query = "select ch.* from chi_tiet_de_thi ctdt join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi where dt.ma_de_thi = 1";
        $select_socauhoi = mysqli_query($connect,$query);  
        $d = 0;
        while($row = mysqli_fetch_assoc($select_socauhoi)) {
            $ma_cau_hoi = $row['ma_cau_hoi'];

            $check = $_POST[$ma_cau_hoi];
            if($check == '1') {
                ++$d;
            }
        }
        echo $d;
    }

?>

<div class="left">
    <?php 

    $query = "select ch.* from chi_tiet_de_thi ctdt join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi where dt.ma_de_thi = 1";
    $select_cauhoi = mysqli_query($connect,$query);  
    while($row = mysqli_fetch_assoc($select_cauhoi)) {
        $ma_cau_hoi = $row['ma_cau_hoi'];
        $noi_dung = $row['noi_dung'];
        echo '
        <div class="slide">
        <div class="content">
            <img src="" alt="">    
        </div>
        <div class="question">
            <p class="text-center fw-bold">'.$noi_dung.'</p>';
        $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
        $select_cautl = mysqli_query($connect,$query2); 
        while($row2 = mysqli_fetch_assoc($select_cautl)) { 
            $noi_dung_ctl = $row2['noi_dung'];
           echo'   
                    <div class="answer">
                        <p>'.$noi_dung_ctl.'</p>
                    </div>
            ';
        }
        echo '
        </div>
        </div>
        ';
    }

    echo '
        <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary" onclick="plusSlides(-1)" >Prev</button>
        <button type="button" class="btn btn-primary" onclick="plusSlides(1)" >Next</button>
        </div>
    ';

    ?>
</div>

<div class="right">

    <div class="container">
        <form action="" medthod = "post">
        <div class="row">
        <?php 
            $i = 0;
            $query = "select ch.* from chi_tiet_de_thi ctdt join de_thi dt on ctdt.ma_de_thi = dt.ma_de_thi join cau_hoi ch on ch.ma_cau_hoi = ctdt.ma_cau_hoi where dt.ma_de_thi = 1";
            $select_socauhoi = mysqli_query($connect,$query);  
            while($row = mysqli_fetch_assoc($select_socauhoi)) {
                ++$i;
                $ma_cau_hoi = $row['ma_cau_hoi'];

                echo '
                    <div class="col" onclick = "currentSlide('.$i.')">
                    Câu '.$i.'
                    <br>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    ';
                    
                
                $query2 = "select * from cau_tra_loi where ma_cau_hoi = $ma_cau_hoi";
                $select_cautl = mysqli_query($connect,$query2); 
                $index = 0;
                while($row2 = mysqli_fetch_assoc($select_cautl)) {
                    ++$index;
                    $la_dap_an = $row2['la_dap_an'];
                    $ma_cau_tra_loi = $row2['ma_cau_tra_loi'];
                    switch($index) {
                        case 1: 
                            echo
                            '
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> A </label>
                            ';
                        break;
                        case 2: 
                            echo
                            '
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> B </label>
                            ';
                        break;
                        case 3: 
                            echo
                            '
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> C </label>
                            ';
                        break;
                        case 4: 
                            echo
                            '
                                <input type="radio" class="btn-check" name="'.$ma_cau_hoi.'" id="'.$ma_cau_tra_loi.'" value = "'.$la_dap_an.'">
                                <label class="btn btn-outline-primary" for="'.$ma_cau_tra_loi.'"> D </label>
                            ';
                        break;
                    }
                }

                echo
                '
                    </div>
                    </div>
                ';
            }
            ?>
        </div>
        <div class="button-submit">
            <button class="btn btn-primary" type="submit" name="nop_bai">Nộp Bài</button>
        <div>
        </form>
    </div>

</div>


<?php
    include('includes/footer.php');
?>

<script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("slide");
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slides[slideIndex-1].style.display = "block";  
    }
</script>