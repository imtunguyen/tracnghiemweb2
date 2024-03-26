<?php 
include('../includes/admin_header.php');
?>
<a href="#" onclick="on_click()">Click me</a>

<script >
    function on_click(){
        $.ajax({
            url: 'word.php',
            method: 'post',
            success:function(data){
                alert(data);
            }
        });
    }
</script>

<?php 
include('../includes/admin_footer.php');
?>