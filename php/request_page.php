<?php 
	session_start();
	include 'components/header.php';
	date_default_timezone_set('Europe/Moscow');

?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
    $(document).ready(function(){
        updateModels();
        
        $('select[name="devicetype"]').on('change', function(){
            updateModels();
        });

        $('select[name="manufacturer"]').on('change', function(){
            updateModels();
        });

        function updateModels() {
            var devicetype = $('select[name="devicetype"]').val();
            var manufacturer = $('select[name="manufacturer"]').val();

            $.ajax({
                type: 'POST',
                url: 'get_models.php',
                data: {devicetype: devicetype, manufacturer: manufacturer},
                dataType: 'html',  // Добавлено указание ожидаемого типа данных
                success: function(response){
                    $('select[name="model"]').html(response);
                }
            });
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
                        <h1>Create Request</h1>
                        <form class="req_edit_page" action="create_request_method.php" method="post">
                            <div class="req-form-container">
                            <?php
                                require_once 'connect_db_pdo.php';
                                $query = $pdo->query('SELECT * FROM DeviceType');
                                echo '<div class="req-form-container-item">';
                                echo '<label for="devicetype">Choose Device Type:</label>
                                <select name="devicetype">
                                <option value="0" selected disabled>Select Device Type</option>';
                                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<option value="'.$row->DeviceTypeID.'">' . $row->DeviceTypeName . '</option>';
                                }
                                echo '</select>';
                                echo '</div>';

                                echo '<div class="req-form-container-item">';
                                $query = $pdo->query('SELECT  * FROM Manufacturer');
                                echo '<label for="manufacturer">Choose Manufacturer:</label>
                                <select name="manufacturer">
                                <option value="0" selected disabled>Select Manufacturer</option>';
                                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<option value="'.$row->ManufacturerID.'">' . $row->ManufacturerName . '</option>';
                                }
                                echo '</select>';
                                echo '</div>';

                                echo '<div class="req-form-container-item">';
                                $query = $pdo->query('SELECT DISTINCT * FROM Models');
                                echo '<label for="model">Choose Model:</label>
                                <select name="model">';
                                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                    echo '<option>' . $row->ModelName . '</option>';
                                }
                                echo '</select>';
                                echo '</div>';
                            ?>
                            <div class="req-form-container-item">
                                <label>Serial Number:</label>
                                <input type="text" name="serialnumber">
                            </div>

                            <div class="req-form-container-item">
                                <label>Description:</label>
                                <input type="text" name="description">
                            </div>
                            <div class="btn">
                                <button type="submit">Create request</button>
                            </div>
                        </div>
                    </form>
                </section>
            </header>
        </div>

<?php include 'components/footer.php'; ?>