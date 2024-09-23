<?php
	session_start();
	include 'components/header.php'; 
    $search = isset($_GET['search']) ? $_GET['search'] : '';
?>

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
                                echo '<li><a href="list_products_page.php">View products</a></li>';
                            } 

                            elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
                                // Add content for employees if needed
                            } 

                            else {
                                echo '<li><a href="admin_page.php">Admin menu</a></li>';
                            }

                            echo '<li><a href="list_request_page.php">View request</a></li>';
                            echo '<li><a href="logout.php">Logout</a></li>';
                        } 

                        else {
                            header('Location: ../index.php');
                        }
                    ?>
                    </ul>
                </nav>

                <div class="logo"><span>FT</span></div>
                    <section class="header-content">
                        <h1>Request's</h1>
                        <div class="center">
                        <form style="width: 160px; height: 130px;" method="GET" action="list_request_page.php">
                            <?php
                            echo '<input type="text" name="search" value="'.$search.'" class="form-input" placeholder="Search...">';
                            ?>
                            <div class="btn">
                                <button style="margin: 15px 10px;" class="link-btn" type="submit">Search</button>
                            </div>

                            <div class="btn">
                                <a style="margin: 0px 10px;" class="link-btn" href="list_request_page.php">Reset</a>
                            </div>
                        </form>
                        </div>
                        <?php
                            if ($_SESSION['user']['Role'] == 'Клиент') {
                            echo '<div class="btn">
                                <a class="link-btn" href="request_page.php">Create request</a>
                            </div>';
                            }
                        
                            require 'connect_db_pdo.php';
                            if ($_SESSION['user']['Role'] == 'Клиент') {
                                echo '<div class="container-form-data">';
                                // $query = $pdo->query('SELECT * FROM Request WHERE UserID = ' . $_SESSION['user']['UserID'] . ' ORDER BY RequestID');
                                $query = $pdo->query("SELECT * FROM Request WHERE UserID = " . $_SESSION['user']['UserID'] . " AND (r_DeviceTypeName LIKE '%$search%' OR r_ManufacturerName LIKE '%$search%' OR r_ModelName LIKE '%$search%' OR Description LIKE '%$search%' OR Status LIKE '%$search%') ORDER BY RequestID");
                                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                            <div class="form-container">
                                                <div class="form-container-item">
                                                    <p class="container-form-data-output-deviceName">Тип устройства: ' . $row->r_DeviceTypeName . '</p>
                                                </div>

                                                <div class="form-container-item">
                                                    <p class="container-form-data-output-manufacturerName">Компания: ' . $row->r_ManufacturerName . '</p>
                                                </div>

                                                <div class="form-container-item">
                                                    <p class="container-form-data-output-modelName">Модель: ' . $row->r_ModelName . '</p>
                                                </div>

                                                <div class="form-container-item">
                                                    <p class="container-form-data-output-modelName">Описание: ' . $row->Description . '</p>
                                                </div>

                                                <div class="form-container-item">
                                                    <p class="container-form-data-output-status">Статус заявки: ' . $row->Status . '</p>
                                                </div>

                                                <div class="btn">
                                                    <a class="link-btn" href="request_edit_page.php?reqID=' . $row->RequestID . '">Edit</a>
                                                </div>

                                                <div class="btn">
                                                    <a class="link-btn" href="request_delete_method.php?reqID=' . $row->RequestID . '">Delete</a>
                                                </div>
                                            </div>
                                        </div>';
                                }
                            echo '</div>';
                            }

                            else if ($_SESSION['user']['Role'] == 'Сотрудник') {
                                echo '<div class="container-form-data">';
                                // $query = $pdo->query('SELECT * FROM Request R JOIN Users U ON R.UserID = U.UserID');
                                $query = $pdo->query("SELECT * FROM Request R JOIN Users U ON R.UserID = U.UserID WHERE (r_DeviceTypeName LIKE '%$search%' OR r_ManufacturerName LIKE '%$search%' OR r_ModelName LIKE '%$search%' OR Description LIKE '%$search%' OR Status LIKE '%$search%' OR LastName LIKE '%$search%') ORDER BY RequestID");

                                while($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                            <div class="form-container-item">
                                                <p class="container-form-data-output-username">Фамилия: '.$row->LastName.'</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-usersname">Имя: '.$row->FirstName.'</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-deviceName">Тип устройства: ' . $row->r_DeviceTypeName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-manufacturerName">Компания: ' . $row->r_ManufacturerName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName">Модель: ' . $row->r_ModelName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName">Описание: ' . $row->Description . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-status">Статус заявки: ' . $row->Status . '</p>
                                            </div>

                                            <div class="btn">
                                                <a class="link-btn" href="request_edit_page.php?reqID=' . $row->RequestID . '">Edit</a>
                                            </div>
                                        </div>';
                                }
                                echo '</div>';
                            }

                            else {
                                echo '<div class="container-form-data">';
                                // $query = $pdo->query('SELECT * FROM Request R JOIN Users U ON R.UserID = U.UserID');
                                $query = $pdo->query("SELECT * FROM Request R JOIN Users U ON R.UserID = U.UserID WHERE (r_DeviceTypeName LIKE '%$search%' OR r_ManufacturerName LIKE '%$search%' OR r_ModelName LIKE '%$search%' OR Description LIKE '%$search%' OR Status LIKE '%$search%' OR LastName LIKE '%$search%') ORDER BY RequestID");

                                while($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                            <div class="form-container-item">
                                                <p class="container-form-data-output-username">Фамилия: '.$row->LastName.'</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-usersname">Имя: '.$row->FirstName.'</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-deviceName">Тип устройства: ' . $row->r_DeviceTypeName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-manufacturerName">Компания: ' . $row->r_ManufacturerName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName">Модель: ' . $row->r_ModelName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName">Описание: ' . $row->Description . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-status">Статус заявки: ' . $row->Status . '</p>
                                            </div>

                                            <div class="btn">
                                                <a class="link-btn" href="request_edit_page.php?reqID=' . $row->RequestID . '">Edit</a>
                                            </div>

                                            <div class="btn">
                                                <a class="link-btn" href="request_delete_method.php?reqID=' . $row->RequestID . '">Delete</a>
                                            </div>   
                                        </div>';
                                }
                                echo '</div>';
                            }
                        ?>
                    </section>
            </header>
        </div>
<!-- Повесить триггер на удаление заявки, если статус в работе, то удалить нельзя -->

<?php include 'components/footer.php'; ?>