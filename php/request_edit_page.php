<?php
session_start();
include 'components/header.php';
$reqID = $_GET['reqID'];

?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function(){
    var flag = false;

    $('select[name="devicetype"]').on('change', function(){
        updateModels();
    });

    $('select[name="manufacturer"]').on('change', function(){
        updateModels();
    });

    function updateModels() {
        var devicetype = $('select[name="devicetype"]').val();
        var manufacturer = $('select[name="manufacturer"]').val();

        // Проверяем, что хотя бы одно из полей было изменено
        if (devicetype !== null || manufacturer !== null) {
            $.ajax({
                type: 'POST',
                url: 'get_models.php',
                data: {devicetype: devicetype, manufacturer: manufacturer},
                dataType: 'html',
                success: function(response){
                    $('select[name="model"]').html(response);
                    console.log(response);
                }
            });
        }
    }
});


    </script>

<div class="container-fluid">
    <div class="background">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>

    <header>
        <nav>
            <ul>
                <?php
                if ($_SESSION['user']['Role'] !== null) {
                    echo '<li><a href="#">User: ' . $_SESSION['user']['Username'] . '</a></li>';
                    echo '<li><a href="../index.php">Home</a></li>';

                    if ($_SESSION['user']['Role'] == 'Клиент') {
                        echo '<li><a href="request_page.php">Create request</a></li>';
                    } elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
                        // Add content for employees if needed
                    } else {
                        echo '<li><a href="admin_page.php">Admin menu</a></li>';
                    }

                    echo '<li><a href="list_request_page.php">View request</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="php/register_page.php">Sign Up</a></li>';
                    echo '<li><a href="php/authorization_page.php">Sign In</a></li>';
                }
                ?>
            </ul>
        </nav>

        <div class="logo"><span>FT</span></div>
        <section class="header-content">
            <h1>Edit Request's</h1>
            <?php
            echo '<form class="req_edit_page" action="request_edit_method.php?reqID=' . $reqID . '" method="post">';
            require_once 'connect_db_pdo.php';

            echo '<div class="req-container-form-data">';
            $main_query = $pdo->query('SELECT * FROM Request WHERE RequestID = ' . $reqID . '');
            while ($main_row = $main_query->fetch(PDO::FETCH_OBJ)) {
                if ($_SESSION['user']['Role'] == 'Клиент') {
                    echo '<div class="req-edit-container-form-data-output">';
                    $query = $pdo->query('SELECT * FROM DeviceType');
                    echo '<div class="req-form-container-item">';
                    echo '<label for="devicetype">Выберите тип устройства:</label>
                        <select name="devicetype">';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $selected = ($row->DeviceTypeName == $main_row->r_DeviceTypeName) ? 'selected' : '';
                        echo '<option ' . $selected . ' value="'.$row->DeviceTypeID.'">' . $row->DeviceTypeName . '</option>';
                    }
                    $query->closeCursor();
                    echo '</select>';
                    echo '</div>';

                    echo '<div class="req-form-container-item">';
                    $query = $pdo->query('SELECT * FROM Manufacturer');
                    echo '<label for="manufacturer">Выберите производителя:</label>
                        <select name="manufacturer">';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $selected = ($row->ManufacturerName == $main_row->r_ManufacturerName) ? 'selected' : '';
                        echo '<option ' . $selected . ' value="'.$row->ManufacturerID.'">' . $row->ManufacturerName . '</option>';
                    }
                    $query->closeCursor();
                    echo '</select>';
                    echo '</div>';

                    // Измените этот участок в вашем коде
                    echo '<div class="req-form-container-item">';
                    $query = $pdo->query('SELECT DISTINCT * FROM Models');
                    echo '<label for="model">Выберите модель:</label>
                        <select name="model">';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $selected = ($row->ModelName == $main_row->r_ModelName) ? 'selected' : '';
                        echo '<option ' . $selected . ' value="'.$row->ModelName.'">' . $row->ModelName . '</option>';
                    }
                    $query->closeCursor();
                    echo '</select>';
                    echo '</div>';



                    echo '<div class="req-form-container-item">';
                    echo '<label>Серийный номер:</label>';
                    echo '<input type="text" name="serialnumber" value="' . $main_row->SerialNumber . '">';
                    echo '</div>';

                    echo '<div class="req-form-container-item">';
                    echo '<label>Описание:</label>';
                    echo '<input type="text" name="description" value="' . $main_row->Description . '">';
                    echo '</div>';

                    echo '</div>';
                    echo '<div class="btn">';
                    echo '<button type="submit">Edit request</button>';
                    echo '</div>';
                } elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
                    echo '<div class="container-form-editdata">';
                    $query = $pdo->query('SELECT * FROM Request WHERE RequestID = ' . $reqID . ' ORDER BY RequestID');
                    $currentStatus = '';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $currentStatus = $row->Status;
                        echo '<div class="container-form-data-output">
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-deviceName">Тип устройства: ' . $row->r_DeviceTypeName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-manufacturerName">Компания: ' . $row->r_ManufacturerName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-modelName">Модель: ' . $row->r_ModelName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-description">Описание: ' . $row->Description . '</p>
                                </div>
                                <div class="req-edit">
                                    <div class="req-form-container-item">
                                        <label>Статус: </label>
                                        <select name="status" style="width: 120px;">';
                    }
                    $statusQuery = $pdo->query('SELECT * FROM StatusTable');
                    $statusArray = [];
                    while ($status_row = $statusQuery->fetch(PDO::FETCH_OBJ)) {
                        $statusArray[] = $status_row->StatusName;
                    }
                    foreach ($statusArray as $status) {
                        $selected = ($status == $currentStatus) ? 'selected' : '';
                        echo '<option value="'.$status.'" ' . $selected . '>' . $status . '</option>';
                    }
                    echo '</select></div>
                        <div class="req-form-container-item" style="margin-top: 30px;">
                         ';
                    $query = $pdo->query('SELECT * FROM Contract WHERE RequestID = ' . $reqID . '');
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        echo '<p class="container-form-data-output-description">Цена: ' . $row->TotalCost . ' рублей</p>';
                    } else {
                        echo '<label>Цена: </label><input type="text" name="totalcost" style="width: 120px;">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="btn">';
                    echo '<button type="submit">Edit request</button>';
                    echo '</div>';
                    echo '</div></div>';
                    echo '</div></div>';
                } else {
                    echo '<div class="container-form-editdata">';
                    $query = $pdo->query('SELECT * FROM Request WHERE RequestID = ' . $reqID . ' ORDER BY RequestID');
                    $currentStatus = '';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $currentStatus = $row->Status;
                        echo '<div class="container-form-data-output">
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-deviceName">Тип устройства: ' . $row->r_DeviceTypeName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-manufacturerName">Компания: ' . $row->r_ManufacturerName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-modelName">Модель: ' . $row->r_ModelName . '</p>
                                </div>
                                <div class="req-form-container-item">
                                    <p class="container-form-data-output-description">Описание: ' . $row->Description . '</p>
                                </div>
                                <div class="req-edit">
                                    <div class="req-form-container-item">
                                        <label>Статус: </label>
                                        <select name="status" style="width: 120px;">';
                    }
                    $statusQuery = $pdo->query('SELECT * FROM StatusTable');
                    $statusArray = [];
                    while ($status_row = $statusQuery->fetch(PDO::FETCH_OBJ)) {
                        $statusArray[] = $status_row->StatusName;
                    }
                    foreach ($statusArray as $status) {
                        $selected = ($status == $currentStatus) ? 'selected' : '';
                        echo '<option value="'.$status.'" ' . $selected . '>' . $status . '</option>';
                    }
                    echo '</select></div>
                        <div class="req-form-container-item" style="margin-top: 30px;">
                            <label>Цена: </label>';
                    $query = $pdo->query('SELECT * FROM Contract WHERE RequestID = ' . $reqID . '');
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        echo '<input type="text" value="' . $row->TotalCost . '" name="totalcost" style="width: 120px;">';
                    } else {
                        echo '<input type="text" name="totalcost" style="width: 120px;">';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="btn">';
                    echo '<button type="submit">Edit request</button>';
                    echo '</div>';
                    echo '</div></div>';
                    echo '</div></div>';
                }
            }
            echo '</form>';
            ?>
        </section>
    </header>
</div>
<?php include 'components/footer.php'; ?>
