<?php
	session_start();

	require_once 'connect_db.php';

	$devicetype = $_POST['devicetype_name'];
	$manufacturer = $_POST['manufacturer_name'];
	$model = $_POST['model_name'];

	// Check if DeviceType exists
	$sql_check_dt = "SELECT DeviceTypeID FROM DeviceType WHERE DeviceTypeName = ?";
	$stmt_check_dt = $connect->prepare($sql_check_dt);
	$stmt_check_dt->bind_param("s", $devicetype);
	$stmt_check_dt->execute();
	$stmt_check_dt->store_result();

	if ($stmt_check_dt->num_rows > 0) {
	    // DeviceType exists, retrieve the ID
	    $stmt_check_dt->bind_result($deviceTypeID);
	    $stmt_check_dt->fetch();
	} else {
	    // DeviceType doesn't exist, insert and retrieve the ID
	    $stmt_check_dt->close();
	    
	    $sql_insert_dt = "INSERT INTO DeviceType (DeviceTypeName) VALUES (?)";
	    $stmt_insert_dt = $connect->prepare($sql_insert_dt);
	    $stmt_insert_dt->bind_param("s", $devicetype);
	    $stmt_insert_dt->execute();
	    $stmt_insert_dt->close();

	    $stmt_get_dt = $connect->prepare($sql_check_dt);
	    $stmt_get_dt->bind_param("s", $devicetype);
	    $stmt_get_dt->execute();
	    $stmt_get_dt->bind_result($deviceTypeID);
	    $stmt_get_dt->fetch();
	    $stmt_get_dt->close();
	}

	// Check if Manufacturer exists
	$sql_check_m = "SELECT ManufacturerID FROM Manufacturer WHERE ManufacturerName = ?";
	$stmt_check_m = $connect->prepare($sql_check_m);
	$stmt_check_m->bind_param("s", $manufacturer);
	$stmt_check_m->execute();
	$stmt_check_m->store_result();

	if ($stmt_check_m->num_rows > 0) {
	    // Manufacturer exists, retrieve the ID
	    $stmt_check_m->bind_result($manufacturerID);
	    $stmt_check_m->fetch();
	} else {
	    // Manufacturer doesn't exist, insert and retrieve the ID
	    $stmt_check_m->close();

	    $sql_insert_m = "INSERT INTO Manufacturer (ManufacturerName) VALUES (?)";
	    $stmt_insert_m = $connect->prepare($sql_insert_m);
	    $stmt_insert_m->bind_param("s", $manufacturer);
	    $stmt_insert_m->execute();
	    $stmt_insert_m->close();

	    $stmt_get_m = $connect->prepare($sql_check_m);
	    $stmt_get_m->bind_param("s", $manufacturer);
	    $stmt_get_m->execute();
	    $stmt_get_m->bind_result($manufacturerID);
	    $stmt_get_m->fetch();
	    $stmt_get_m->close();
	}

	// Insert into models table
	$sql_insert_model = "INSERT INTO models (DeviceTypeID, ManufacturerID, ModelName) VALUES (?, ?, ?)";
	$stmt_insert_model = $connect->prepare($sql_insert_model);
	$stmt_insert_model->bind_param("sss", $deviceTypeID, $manufacturerID, $model);
	$stmt_insert_model->execute();
	$stmt_insert_model->close();

	$connect->close();

	header('Location: ../index.php');
?>
