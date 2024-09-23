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
                        if (isset($_SESSION['user']) && isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] !== null) {
                            echo '<li><a href="#">User: ' . $_SESSION['user']['Username'] . '</a></li>';

                            if ($_SESSION['user']['Role'] == 'Клиент') {
                                echo '<li><a href="php/request_page.php">Создать заявку</a></li>';
                            } 

                            elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
                                // Add content for employees if needed
                            } 

                            else {
                                echo '<li><a href="php/admin_page.php">Admin menu</a></li>';
                            }

                            echo '<li><a href="php/list_request_page.php">View request</a></li>';
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
                    <form action="../php/authorization_method.php" method="post">
                        <div class="form-container">
                            <div class="form-container-item">
                                <label>Username</label>
                                <input type="text" name="username" placeholder="Input your Username" class="form-input" required>
                            </div>

                            <div class="form-container-item">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Input your Password" class="form-input" required>
                            </div>
                        </div>

                        <div class="btn">
                            <button class="form-btn" type="submit">Sign In</button>
                        </div>
                        
                        <p class="text-center">You don't have an account? - <a class="form-link" href="register_page.php"> Sign Up</a></p>
                        <?php 
                            if (isset($_SESSION['ms'])) {
                                echo '<p class="msg"> ' . $_SESSION['ms'] . '</p>';
                                // Unset 'ms' after displaying it to avoid the notice in the future
                                unset($_SESSION['ms']);
                            }
                        ?>
                    </form>
                    </div>
                <!-- </section> -->
            </header>
        </div>

<?php include 'components/footer.php'; ?>