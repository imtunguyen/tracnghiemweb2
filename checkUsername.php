<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functionUsers.php');

if(isset($_POST['usernameOrEmail'])) {
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $userInfo = getUsername($connect, $usernameOrEmail);

    if($userInfo) {
        echo 'found'; // Username or email exists
    } else {
        echo 'not_found'; // Username or email does not exist
    }
}
?>
