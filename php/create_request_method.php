<?php
	session_start();
	date_default_timezone_set('Europe/Moscow');

	require_once 'connect_db.php';

	$devicetype = $_POST['devicetype'];
	$manufacturer = $_POST['manufacturer'];
	$model = $_POST['model'];
	$serialnumber = $_POST['serialnumber'];
	$description = $_POST['description'];

	$user_id = $_SESSION['user']['UserID'];

	$currentDateTime = date('Y-m-d H:i:s');

	$sql_devicetype = "SELECT DeviceTypeName FROM devicetype WHERE DeviceTypeID = '$devicetype'";
	$sql_manufacturer = "SELECT ManufacturerName FROM manufacturer WHERE ManufacturerID = '$manufacturer'";

	$res1 = $connect->query($sql_devicetype);
	$res2 = $connect->query($sql_manufacturer);

	$sql_model = "SELECT ModelName FROM Models WHERE ModelID = '$model'";
    $res3 = $connect->query($sql_model);
    $modelName = $res3->fetch_assoc()['ModelName'];

	if ($res1_row = $res1->fetch_assoc() and $res2_row = $res2->fetch_assoc()) {
	    $deviceTypeName = $res1_row['DeviceTypeName'];
	    $manufacturerName = $res2_row['ManufacturerName'];

	    $sql = "INSERT INTO Request (UserID, r_DeviceTypeName, r_ManufacturerName, r_ModelName, SerialNumber, Description, Status, DateCreated, DateUpdated) 
	        VALUES ('$user_id', '$deviceTypeName', '$manufacturerName', '$modelName', '$serialnumber', '$description', 'Ожидание', '$currentDateTime', '$currentDateTime')";

	    if ($connect->query($sql) === TRUE) {
	        echo "Данные успешно добавлены в базу данных";
	    } else {
	        echo "Ошибка при добавлении данных: " . mysqli_error($connect);
	    }
	} else {
	    echo "Ошибка при получении данных из базы данных";
	}

	$connect->close();

	header('Location: list_request_page.php');
?>
