<?php
session_start();
include 'components/header.php';
$prodID = $_GET['prodID'];
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
            echo '<form class="req_edit_page" action="edit_product_method.php?prodID=' . $prodID . '" method="post" enctype="multipart/form-data">';
            require_once 'connect_db_pdo.php';
            echo '<div class="req-container-form-data">';
            $query = $pdo->query('SELECT * FROM Products WHERE ProductID = ' . $prodID . '');
            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                echo '<div class="container-form-data-output">
                        <div class="req-form-container-item">
                            <label>Название:</label>
                            <input type="text" name="prodname" value="' . $row->ProductName . '">
                        </div>

                        <div class="req-form-container-item">
                            <label>Категория:</label>
                            <input type="text" name="category" value="' . $row->Category . '">
                        </div>

                        <div class="req-form-container-item">
                            <label>Цена:</label>
                            <input type="text" name="price" value="' . $row->Price . '">
                        </div>

                        <div class="req-form-container-item">
                            <label>Image:</label>
                            <input type="file" name="img">
                        </div>';
            }
            echo '<div class="btn">
                            <button class="link-btn" type="submit">Edit</button>
                        </div>';
            echo '</form>';
            ?>

        </section>
    </header>
</div>
<?php include 'components/footer.php'; ?>
