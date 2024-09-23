<?php
    session_start();
    include_once 'connect_db_pdo.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_name = $_POST['product_name'];
        $category = $_POST['category'];
        $price = $_POST['price'];

        $product_image = $_FILES['product_image']['name'];
        $upload_dir = '../img/';
        $upload_file = $upload_dir . basename($product_image);

        move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_file);

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO Products (`ProductName`, `Category`, `Price`, `ImagePath`) VALUES (?, ?, ?, ?)");
            $stmt->execute([$product_name, $category, $price, $product_image]);

            echo "Продукт успешно создан!";
        } 

        catch (PDOException $e) {
            echo "Ошибка при создании продукта: " . $e->getMessage();
        }
    }

    header('Location: ../index.php');
?>
