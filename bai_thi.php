<?php
include('includes/header.php');
?>


<?php 
    include('includes/database.php');
?>

<div class="left">
    <div class="content">
        
    </div>
</div>

<div class="right">

    <div class="container">
        <form action="">
        <div class="row">
            <div class="col" onclick="showSilde()">
                Câu
                <br>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1">
                    <label class="btn btn-outline-primary" for="btnradio1">A</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                    <label class="btn btn-outline-primary" for="btnradio2">B</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                    <label class="btn btn-outline-primary" for="btnradio3">C</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4">
                    <label class="btn btn-outline-primary" for="btnradio4">D</label>

                </div>
            </div>
        </div>
        </form>
    </div>

</div>

<?php
include('includes/footer.php');
?>