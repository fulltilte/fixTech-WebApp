<?php 
	session_start();
	include 'components/header.php';
	date_default_timezone_set('Europe/Moscow');
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
                                echo '<li><a href="request_page.php">Создать заявку</a></li>';
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
                <!-- <section class="header-content"> -->
                    <div class="form">
                    <form action="create_device_method.php" method="post">
                        <div class="form-container">
                            <div class="form-container-item">
                                <label>Device Type</label>
                                <input type="text" name="devicetype_name" placeholder="Input device type name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Manufacturer</label>
                                <input type="text" name="manufacturer_name" placeholder="Input manufacturer name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Model</label>
                                <input type="text" name="model_name" placeholder="Input model name" class="form-input">
                            </div>
                        </div>

                        <div class="btn">
                            <button class="form-btn" type="submit">Create device</button>
                        </div>
                    </form>
                    </div>
                <!-- </section> -->
            </header>
        </div>

<?php include 'components/footer.php'; ?>