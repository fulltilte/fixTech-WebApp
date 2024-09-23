<?php
	session_start();
	include 'components/header.php'; 
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
                        <h1>Sale's</h1>
                        <?php
                        require 'connect_db_pdo.php';
                            if ($_SESSION['user']['Role'] == 'Клиент') {
                            	
                            }

                            else if ($_SESSION['user']['Role'] == 'Сотрудник') {
                                
                            }

                            else {
                                echo '<div class="container-form-data">';
                                $query = $pdo->query('SELECT * FROM Users U
                            JOIN Sales S ON U.UserID = S.UserID
                            JOIN Products P ON S.ProductID = P.ProductID');
                                while($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                    <p class="container-form-data-output-modelName">'.$row->LastName.'</p>
                    <p class="container-form-data-output-manufacturerName">'.$row->FirstName.'</p>
                    <p class="container-form-data-output-status">'.$row->ProductName.'</p>
                    <p class="container-form-data-output-modelName">'.$row->Category.'</p>
                    <p class="container-form-data-output-status">'.$row->Quantity.'</p>
                    <p class="container-form-data-output-modelName">'.$row->SaleDate.'</p>
                    <p class="container-form-data-output-status">'.$row->TotalRevenue.'</p> 
                                        </div>';
                                }
                                echo '</div>';
                            }
                        ?>
                    </section>
            </header>
        </div>



<?php include 'components/footer.php'; ?>