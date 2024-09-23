<?php
	session_start();
	include_once 'connect_db.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$reppas = $_POST['reppassword'];
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];

	$sql = mysqli_query($connect, "SELECT * FROM Users WHERE Username = '$username'");

	if (mysqli_num_rows($sql) === 0) {
		if ($password === $reppas) {
			mysqli_query($connect, "INSERT INTO Users (Username, Password, Rep_Password, FirstName, LastName, Role) 
			VALUES ('$username', '$password', '$reppas', '$firstName', '$lastName', 'Клиент')");
		
			$_SESSION['ms'] = 'Registration was successful!';
			$connect->close();
			header('Location: authorization_page.php');
		}

		else {
			$_SESSION['ms'] = 'Passwords do not match';
	        header('Location: register_page.php');
		}
	}
	else {
		$_SESSION['ms'] = 'Such a user already exists';
	    header('Location: register_page.php');
	}
	
?>