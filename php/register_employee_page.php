<?php
    session_start();
    // if($_SESSION['user']) 
    //     header('Location: ../index.php');

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
                    <form action="register_employee_method.php" method="post">
                        <div class="form-container">
                            <div class="form-container-item">
                                <label>Employee Second name</label>
                                <input type="text" name="lastname" placeholder="Input employee Second name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Employee First name</label>
                                <input type="text" name="firstname" placeholder="Input employee First name" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Employee Username</label>
                                <input type="text" name="username" placeholder="Input employee Username" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Employee Password</label>
                                <input type="password" name="password" placeholder="Input employee Password" class="form-input">
                            </div>

                            <div class="form-container-item">
                                <label>Repeat Employee Password</label>
                                <input type="password" name="rep_password" placeholder="Input employee Password" class="form-input">
                            </div>
                        </div>

                        <div class="btn">
                            <button class="form-btn" type="submit">Sign Up</button>
                        </div>
                    </form>
                    </div>
                <!-- </section> -->
            </header>
        </div>

<?php include 'components/footer.php'; ?>