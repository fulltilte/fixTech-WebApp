<?php
	session_start();
	include 'components/header.php'; 
?>

<?php
	
	if ($_SESSION['user']['Role'] == 'Клиент') {
	    header('Location: ../index.php');
	}

	else if ($_SESSION['user']['Role'] == 'Сотрудник') {
		header('Location: ../index.php');
	}

	else {
		
	}
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
            <h1>Contract's</h1>
            <?php
                require 'connect_db_pdo.php';
                if ($_SESSION['user']['Role'] == 'Клиент') {
                    // Добавьте контент для клиента, если это необходимо
                }

                else if ($_SESSION['user']['Role'] == 'Сотрудник') {
                    // Добавьте контент для сотрудника, если это необходимо
                }

                else {
                    echo '<div class="container">
                    <div class="container-graph">';   
                    $currentYear = date('Y'); // Получаем текущий год

					$query = $pdo->prepare('SELECT MONTH(DateSigned) AS Month, SUM(TotalCost) AS MonthlyTotalCost FROM contract WHERE YEAR(DateSigned) = :currentYear GROUP BY Month');
					$query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
					$query->execute();
                    $allMonthsData = [];
                    for ($month = 1; $month <= 12; $month++) {
                        $allMonthsData[] = [
                            'month' => $month,
                            'totalCost' => 0,
                        ];
                    }
                    $chartData = [];
                    while($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $chartData[$row->Month - 1] = [
                            'month' => $row->Month,
                            'totalCost' => $row->MonthlyTotalCost,
                        ];
                    }

                    $finalChartData = array_replace($allMonthsData, $chartData);

                    $monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

                    echo '<div class="chart-contract"><canvas id="myChart" width="600" height="300"></canvas>';
                    echo '<script>
				        var monthNames = ' . json_encode($monthNames) . ';
				        var ctx = document.getElementById("myChart").getContext("2d");
				        var myChart = new Chart(ctx, {
				            type: "bar",
				            data: {
				                labels: ' . json_encode(array_map(function($data) use ($monthNames) {
				                    return $monthNames[$data['month'] - 1];
				                }, $finalChartData)) . ',
				                datasets: [{
				                    label: "Ежемесячный общий доход с услуг",
				                    data: ' . json_encode(array_column($finalChartData, 'totalCost')) . ',
				                    backgroundColor: "rgba(75, 192, 192, 0.2)",
				                    borderColor: "rgba(75, 192, 192, 1)",
				                    borderWidth: 1
				                }]
				            },
				            options: {
				                scales: {
				                    y: {
				                        beginAtZero: true,
				                        ticks: {
				                            color: "white"
				                        }
				                    },
				                    x: {
				                        ticks: {
				                            color: "white"
				                        }
				                    }
				                },
				                plugins: {
				                    legend: {
				                        display: true,
				                        labels: {
				                            color: "white",
				                        }
				                    }
				                },
				                title: {
				                    display: true,
				                    text: "Ежемесячные общие затраты",
				                    font: {
				                        size: 18,
				                        color: "white",
				                        weight: "bold" 
				                    },
				                    color: "white"
				                }
				            }
				        });
				      </script>';


                    echo '</div></div></div>';
                }
            ?>
        </section>
    </header>
</div>

<?php include 'components/footer.php'; ?>
