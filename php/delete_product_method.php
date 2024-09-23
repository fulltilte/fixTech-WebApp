<?php
    session_start();

    require_once 'connect_db.php';

    $prodID = $_GET['prodID'];

    $sql_orders = "DELETE FROM Orders WHERE ProductID = '$prodID'";
    $sql_products = "DELETE FROM Products WHERE ProductID = '$prodID'";

    if ($connect->query($sql_orders) === TRUE) {
        echo "Данные успешно удалены из Orders";
    } else {
        echo "Ошибка при удалении данных из Orders: " . $connect->error;
    }

    if ($connect->query($sql_products) === TRUE) {
        echo "Данные успешно удалены из Products";
    } else {
        echo "Ошибка при удалении данных из Products: " . $connect->error;
    }

    $connect->close();

    header('Location: list_products_page.php');
?>
