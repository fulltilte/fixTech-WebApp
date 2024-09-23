<?php
session_start();
require_once 'connect_db.php';

if (isset($_GET['prodID']) && isset($_POST['quantity'])) {
    $productID = $_GET['prodID'];
    $quantity = $_POST['quantity'];

    $productQuery = mysqli_query($connect, "SELECT * FROM Products WHERE ProductID = '$productID'");

    if ($product = mysqli_fetch_assoc($productQuery)) {
        $userID = $_SESSION['user']['UserID'];
        $price = $product['Price'];

        $totalPrice = $price * $quantity;

        $insertOrderQuery = mysqli_query($connect, "INSERT INTO Orders (UserID, ProductID, Quantity, Price, DateCreated) 
                                                    VALUES ('$userID', '$productID', '$quantity', '$totalPrice', NOW())");

        if ($insertOrderQuery) {
            header('Location: list_products_page.php');
        } else {
            echo "Ошибка при оформлении заказа: " . mysqli_error($connect);
        }
    } else {
        echo "Товар не найден.";
    }
} else {
    echo "Не переданы все необходимые параметры.";
}
?>
