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
                    <form action="create_product_method.php" method="post" enctype="multipart/form-data">
                        <div class="form-container">
                            <div class="form-container-item">
                                <label>Product Name</label>
                                <input type="text" name="product_name" placeholder="Input Product name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Category</label>
                                <input type="text" name="category" placeholder="Input Category name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Price</label>
                                <input type="text" name="price" placeholder="Input Price" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Image</label>
                                <input type="file" name="product_image">
                            </div>
                        </div>

                        <div class="btn">
                            <button class="form-btn" type="submit">Create Product</button>
                        </div>
                    </form>
                    </div>
                <!-- </section> -->
            </header>
        </div>

<?php include 'components/footer.php'; ?>