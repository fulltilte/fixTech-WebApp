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
                            echo '<li><a href="register_page.php">Sign Up</a></li>';
                            echo '<li><a href="authorization_page.php">Sign In</a></li>';
                        }
                    ?>
                    </ul>
                </nav>

                <div class="logo"><span>FT</span></div>
                    <section class="header-content">
                        <?php
                            require 'connect_db_pdo.php';
                            if ($_SESSION['user']['Role'] == 'Клиент') {
                                echo '<div class="container-form-data">';
                                $query = $pdo->query('SELECT * FROM Products');
                                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                    <div class="form-container">
                                        <div class="form-container-block">
                                            <div class="form-container-item">
                                                <p class="container-form-data-output-deviceName">Название: ' . $row->ProductName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-manufacturerName">Тип товара: ' . $row->Category . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName"> Цена: ' . $row->Price .' рублей</p>
                                            </div>
                                        </div>
                                        <div class="form-container-block">
                                            <div class="form-container-item">
                                                <img src="../img/' . $row->ImagePath . '">
                                            </div>
                                        </div>

                                        <div class="form-container-item">
                                            <form class="form-prod" method="post" action="order_method.php?prodID=' . $row->ProductID . '">
                                                <input type="number" name="quantity" value="1" min="1">
                                                <div class="btn">
                                                    <button class="link-btn" type="submit">Order</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div></div>';
                                }
                                echo '</div>';

                            }

                            else if ($_SESSION['user']['Role'] == 'Сотрудник') {
                                echo '<div class="container-form-data">';         
                                $query = $pdo->query('SELECT * FROM Products');
                                while($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                            <p class="container-form-data-output-deviceName">'.$row->ProductName.'</p>
                                            <p class="container-form-data-output-manufacturerName">'.$row->Category.'</p>
                                            <p class="container-form-data-output-modelName">'.$row->Price.'</p>
                                            <img src="../img/'.$row->ImagePath.'">
                                        </div>';
                                }
                                echo '</div>';
                            }

                            else {
                                echo '<div class="container-form-data">';         
                                $query = $pdo->query('SELECT * FROM Products');
                                while($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="container-form-data-output">
                                    <div class="form-container">
                                        <div class="form-container-block">
                                            <div class="form-container-item">
                                                <p class="container-form-data-output-deviceName">Название: ' . $row->ProductName . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-manufacturerName">Тип товара: ' . $row->Category . '</p>
                                            </div>

                                            <div class="form-container-item">
                                                <p class="container-form-data-output-modelName"> Цена: ' . $row->Price .' рублей</p>
                                            </div>
                                        </div>
                                        <div class="form-container-block">
                                            <div class="form-container-item">
                                                <img src="../img/' . $row->ImagePath . '">
                                            </div>
                                        </div>

                                        <div class="form-container-item">
                                            <div class="btn">
                                                <a class="link-btn" href="edit_product_page.php?prodID='.$row->ProductID.'">Edit</a>
                                            </div>

                                            <div class="btn">
                                                <a class="link-btn" href="delete_product_method.php?prodID='.$row->ProductID.'">Delete</a>
                                            </div>
                                        </div>
                                    </div></div>';
                                }
                                echo '</div>';
                            }
                        ?>
                    </section>
            </header>
        </div>

<?php include 'components/footer.php'; ?>