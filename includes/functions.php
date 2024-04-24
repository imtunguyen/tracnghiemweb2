<?php
function thongBao(){
    if (isset($_SESSION['toastr'])) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script type="text/javascript">
        toastr.success("<?php echo $_SESSION['toastr']; ?>");
        </script>"
        <?php
        unset($_SESSION['toastr']);
    }
}
function secure() {
    if(!isset($_SESSION['id'])){
        $_SESSION['message'] = "Please login first to view this page.";
        header('Location: /');
        die();
    }
}
function randomColor(){
    $red = mt_rand(180,230);
    $green = mt_rand(180,230);
    $blue = mt_rand(180,230);
    $color = sprintf('#%02X%02X%02X', $red, $green, $blue);

    return $color;
}