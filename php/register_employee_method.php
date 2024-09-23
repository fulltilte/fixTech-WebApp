<?php
	session_start();
	include_once 'connect_db.php';

	$username = mysqli_real_escape_string($connect, $_POST['username']);
	$password = mysqli_real_escape_string($connect, $_POST['password']);
	$rep_password = mysqli_real_escape_string($connect, $_POST['rep_password']);
	$firstName = mysqli_real_escape_string($connect, $_POST['firstname']);
	$lastName = mysqli_real_escape_string($connect, $_POST['lastname']);

	// Add a placeholder for Rep_Password in the SQL query
	$stmt = $connect->prepare("INSERT INTO Users (Username, Password, Rep_Password, FirstName, LastName, Role) VALUES (?, ?, ?, ?, ?, 'Сотрудник')");
	
	// Check if prepare was successful
	if ($stmt) {
		$stmt->bind_param("sssss", $username, $password, $rep_password, $firstName, $lastName);

		if ($stmt->execute()) {
			echo "Пользователь успешно добавлен в базу данных";
		} else {
			echo "Ошибка при добавлении пользователя: " . $stmt->error;
		}

		$stmt->close();
	} else {
		// Handle the case where prepare failed
		echo "Ошибка при подготовке запроса: " . $connect->error;
	}

	$connect->close();

	header('Location: ../index.php');
?>
