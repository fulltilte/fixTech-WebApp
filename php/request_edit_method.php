<?php
	session_start();
	date_default_timezone_set('Europe/Moscow');

	require_once 'connect_db.php';

	$devicetype = isset($_POST['devicetype']) ? $_POST['devicetype'] : '';
	$manufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : '';
	$model = isset($_POST['model']) ? $_POST['model'] : '';
	$serialnumber = isset($_POST['serialnumber']) ? $_POST['serialnumber'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';

	$user_id = $_SESSION['user']['UserID'];
	$reqID = $_GET['reqID'];

	$currentDateTime = date('Y-m-d H:i:s');

	$sql_devicetype = "SELECT DeviceTypeName FROM devicetype WHERE DeviceTypeID = '$devicetype'";
	$sql_manufacturer = "SELECT ManufacturerName FROM manufacturer WHERE ManufacturerID = '$manufacturer'";
	$res1 = $connect->query($sql_devicetype);
	$res2 = $connect->query($sql_manufacturer);


	// Извлекаем значения из результатов запросов
	$deviceTypeName = $res1->fetch_assoc()['DeviceTypeName'];
	$manufacturerName = $res2->fetch_assoc()['ManufacturerName'];


	if ($_SESSION['user']['Role'] == 'Клиент') {
	    $sql = "UPDATE Request 
	        SET r_DeviceTypeName = '$deviceTypeName', 
	            r_ManufacturerName = '$manufacturerName', 
	            r_ModelName = '$model', 
	            SerialNumber = '$serialnumber', 
	            Description = '$description', 
	            DateUpdated = '$currentDateTime' 
	        WHERE RequestID = $reqID";
	    
	    if ($connect->query($sql) === TRUE) {
	        echo "Данные успешно обновлены в базе данных";
	    } else {
	        echo "Ошибка при обновлении данных: " . mysqli_error($connect);
	    }
	}

	else if ($_SESSION['user']['Role'] == 'Сотрудник') {
		$selectedStatus = $_POST['status'];
		$totalCost = $_POST['totalcost'];
		
		$checkContract = "SELECT * FROM Contract WHERE RequestID = '$reqID'";
		$result = $connect->query($checkContract);

		if ($result->num_rows > 0) {
			$sql_contract = "UPDATE Contract SET DateSigned = '$currentDateTime', TotalCost = '$totalCost' WHERE RequestID = '$reqID'";
		} 

		else {
			$sql_contract = "INSERT INTO Contract (RequestID, DateSigned, TotalCost) VALUES ('$reqID', '$currentDateTime', '$totalCost')";
		}

		$connect->query($sql_contract);
		
		$sql = "UPDATE Request SET Status = '$selectedStatus' WHERE RequestID = '$reqID'";
	} 

	else {
		$selectedStatus = $_POST['status'];
		$totalCost = isset($_POST['totalcost']) ? $_POST['totalcost'] : '';
		
		$checkContract = "SELECT * FROM Contract WHERE RequestID = '$reqID'";
		$result = $connect->query($checkContract);

		if ($result->num_rows > 0) {
			$sql_contract = "UPDATE Contract SET DateSigned = '$currentDateTime', TotalCost = '$totalCost' WHERE RequestID = '$reqID'";
		} 

		else {
			$sql_contract = "INSERT INTO Contract (RequestID, DateSigned, TotalCost) VALUES ('$reqID', '$currentDateTime', '$totalCost')";
		}

		$connect->query($sql_contract);
		
		$sql = "UPDATE Request SET Status = '$selectedStatus' WHERE RequestID = '$reqID'";
	}

	if ($connect->query($sql) === TRUE) {
	    echo "Данные успешно добавлены в базу данных";
	} else {
	    echo "Ошибка при добавлении данных: " . mysqli_error($connect);
	}

	$connect->close();

	header('Location: list_request_page.php');
?>
