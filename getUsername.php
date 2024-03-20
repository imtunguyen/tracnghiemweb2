<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');
if(isset($_POST["submit"])){
    if(isset($_POST['usernameOrEmail'])){
        $usernameOrEmail = $_POST['usernameOrEmail'];
        $userInfo = getUsername($connect, $usernameOrEmail);
        if($userInfo !== null && $userInfo->num_rows > 0) {
            $row = $userInfo->fetch_assoc(); 
            echo $row['email'] . '<br>';
            echo $row['username'] . '<br>';
            echo $row['mat_khau'] . '<br>';
        } 
    }
}
?>

<div>
    <form action="changePassword.php" method="get">
        <label for="">Nhập Username hoặc Email</label><br>
        <input type="text" name="usernameOrEmail" id="usernameOrEmail">
        <button type="submit" name="submit">Gửi</button>
        <input type="hidden" name="usernameOrEmail" value="<?php echo $usernameOrEmail; ?>">
    </form>
</div>