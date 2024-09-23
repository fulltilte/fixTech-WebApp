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
                            echo '<li><a href="request_page.php">Create request</a></li>';
                        } elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
                            // Add content for employees if needed
                        } else {
                            echo '<li><a href="admin_page.php">Admin menu</a></li>';
                        }

                        echo '<li><a href="list_request_page.php">View request</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="register_page.php">Sign Up</a></li>';
                        echo '<li><a href="authorization_page.php">Sign In</a></li>';
                    }
                    ?>
                </ul>
            </nav>

            <div class="logo"><span>FT</span></div>

            <section class="header-content">
            	<h1>Admin menu</h1>
            	<div class="nav-form">
	            	<div class="nav-menu">
		                <div class="nav-link"><a href="register_employee_page.php">Add employee</a></div>
		                <div class="nav-link"><a href="create_device_page.php">Add device</a></div>
		                <div class="nav-link"><a href="create_product_page.php">Add product</a></div>
		                <div class="nav-link"><a href="list_products_page.php">View products</a></div>
		                <div class="nav-link"><a href="list_request_page.php">View request</a></div>
		                <div class="nav-link"><a href="list_sales_page.php">View sales</a></div>
		                <div class="nav-link"><a href="list_contract_page.php">View contract</a></div>
	                </div>
	            </div>
            </section>
        </header>
    </div>

<?php include 'components/footer.php'; ?>