<?php
	session_start();

	require_once 'connect_db.php';

	$prodID = $_GET['prodID'];

	$prodname = $_POST['prodname'];
	$category = $_POST['category'];
	$price = $_POST['price'];

	$product_image = isset($_FILES['img']['name']) ? $_FILES['img']['name'] : '';
    

	if ($product_image != ''){
		$upload_dir = '../img/';
    	$upload_file = $upload_dir . basename($product_image);
		move_uploaded_file($_FILES['img']['tmp_name'], $upload_file);

		$sql = "UPDATE Products 
	        SET ProductName = '$prodname', 
	            Category = '$category', 
	            Price = '$price', 
	            ImagePath = '$product_image'
	        WHERE ProductID = $prodID";
	}
	else {
		$sql = "UPDATE Products 
	        SET ProductName = '$prodname', 
	            Category = '$category', 
	            Price = '$price'
	        WHERE ProductID = $prodID";
	}

	if ($connect->query($sql) === TRUE) {
	    echo "Данные успешно обновлены";
	} else {
	    echo "Ошибка при добавлении данных: " . mysqli_error($connect);
	}

	$connect->close();

	header('Location: list_products_page.php');
?>