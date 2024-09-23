<?php
// get_models.php
session_start();
require_once 'connect_db_pdo.php';

$devicetype = $_POST['devicetype'];
$manufacturer = $_POST['manufacturer'];

$query = $pdo->prepare('SELECT * FROM Models WHERE DeviceTypeID = ? AND ManufacturerID = ?');
$query->execute([$devicetype, $manufacturer]);

// Измените этот участок в вашем коде
while ($row = $query->fetch(PDO::FETCH_OBJ)) {
    echo '<option value="' . $row->ModelID . '">' . $row->ModelName . '</option>';
}

?>
