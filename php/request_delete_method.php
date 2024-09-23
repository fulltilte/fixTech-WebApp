<?php
	session_start();

	require_once 'connect_db.php';

	$reqID = $_GET['reqID'];

	$sql = "DELETE FROM Request WHERE RequestID = '$reqID'";

	"DELETE FROM Contract WHERE RequestID = '$reqID'";

	if ($connect->query($sql) === TRUE) {
	    echo "Данные успешно удалены из базы данных";
	} else {
	    echo "Ошибка при удалении данных: " . mysqli_error($connect);
	}

	$connect->close();

	header('Location: ../index.php');
?>