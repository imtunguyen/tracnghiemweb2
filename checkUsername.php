<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

if(isset($_POST['usernameOrEmail'])) {
    
    $usernameOrEmail = $_POST['usernameOrEmail'];

    $userInfo = getUsername($connect, $usernameOrEmail);
    if($userInfo == null) {
        echo "Không tìm thấy Username hoặc Email";
        exit();
    } else {
        echo $userInfo['email']; 
    }

}else{
    echo "không";
    exit();
}

