<?php
    session_start();
	include_once 'connect_db.php';

	$username = $_POST['username'];
    $password = $_POST['password'];

    $check_user = mysqli_query($connect, "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password' ");

    if(mysqli_num_rows($check_user) > 0) {
        $user = mysqli_fetch_assoc($check_user);
        $_SESSION['user'] = [
         "UserID" => $user['UserID'], 
         "Username" => $user['Username'],
         "Role" => $user['Role']
         ];
        header('Location: ../index.php');
         
    } else {
        $_SESSION['ms'] = 'Invalid Login or Password';
        header('Location: authorization_page.php');
    }
?>