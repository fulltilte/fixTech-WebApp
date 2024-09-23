<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>FixTECH</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    </head>

    <body>
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
						    echo '<li><a href="index.php">Home</a></li>';

						    if ($_SESSION['user']['Role'] == 'Клиент') {
						        echo '<li><a href="php/request_page.php">Create request</a></li>';
						        echo '<li><a href="php/list_products_page.php">View products</a></li>';
						    } 

						    elseif ($_SESSION['user']['Role'] == 'Сотрудник') {
						        // Add content for employees if needed
						    } 

						    else {
						        echo '<li><a href="php/admin_page.php">Admin menu</a></li>';
						    }

						    echo '<li><a href="php/list_request_page.php">View request</a></li>';
						    echo '<li><a href="php/logout.php">Logout</a></li>';
						} 

						else {
						    echo '<li><a href="php/register_page.php">Sign Up</a></li>';
						    echo '<li><a href="php/authorization_page.php">Sign In</a></li>';
						}
			        ?>
			    	</ul>
				</nav>

		    	<div class="logo"><span>FT</span></div>
		      		<section class="header-content">
		      			<?php
		      			if (isset($_SESSION['user'])) {
		      				require_once 'php/connect_db_pdo.php';
			      			$userid = $_SESSION['user']['UserID'];
			      			$query = $pdo->query("SELECT * FROM Users WHERE UserID = $userid");
	                        while($row = $query->fetch(PDO::FETCH_OBJ)) {
			         			echo '<h1>Welcome to fixtech, '.$row->FirstName.'</h1>';
			         		}
		      			}
			      		else {
			      			echo '<h1>Welcome to fixtech</h1>';
			      		}
		         		
		         		?>
		        		<p> Welcome to the appliance repair service center.</p>
		      		</section>
		  	</header>
		</div>

<?php include 'php/components/footer.php'; ?>