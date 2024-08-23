<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Capstone_ReportAnalytics.css" />
    <link rel="stylesheet" href="Capstone_ClinicAboutUs copy.css">

    <!----===== Icons ===== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!--=====Change name mo na lang====-->
    <title>Doc Lenon Veterinary Clinic | Report Analytics</title>
    <link rel="icon" type="image/x-icon" href=".vscode\Doc Lenon Logo.png">

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php require 'timezone.php'; ?>

    <style>
        table {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .box-report {
            text-align: center;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .box-report {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!--=====Navigation Bar====-->
    <?php require 'nav-bar.html.php'; ?>

    <script>
        $("#rep").css("color", "#5a81fa");
        $("#port").css("color", "#5a81fa");
    </script>

    <!--=====Pinaka taas/ title ganon====-->
    <section class="Contents">
        <div class="top">
            <i class="sidebar-toggle"><span class="material-symbols-outlined"> menu </span></i>
            <div class="title">
                <span class="text">Clinic Report Analytics</span>
            </div>
        </div>

        <div class="dash-content">
            <!--=====Report Analytics====-->
            <div class="report-analytics">
                <div class="title-report-analytics">
                </div>

                <?php
                require 'database-conn.php';

                // Set the timezone to Asia/Manila
                date_default_timezone_set('Asia/Manila');

                $currentDate = new DateTime();
                $currentDateFormatted = $currentDate->format('Y-m-d');

                // Display the current date in the Philippine timezone
                $philippineDate = $currentDate->format('Y-m-d H:i:s T');

                // customer
                $query0 = "SELECT COUNT(*) as count FROM schedule WHERE status = 'Done'";
                $result0 = mysqli_query($conn, $query0);

                if ($result0) {
                    $row0 = mysqli_fetch_assoc($result0); // Fix variable name from $result to $result0
                    $totalCustomer = $row0['count'];
                } else {
                    // Uncomment the following line for debugging
                    // echo "Error in customer query: " . mysqli_error($conn);
                    $totalCustomer = 0; // Set to 0 or handle the error accordingly
                }

                // pet
                $queryz = "SELECT petname, petname2, petname3, petname4, petname5 FROM schedule WHERE status = 'Done'";
                $resultz = mysqli_query($conn, $queryz);

                if ($resultz) {
                    $totalPet = 0;

                    while ($rowz = mysqli_fetch_assoc($resultz)) {
                        // Loop through each column and count the pets
                        foreach ($rowz as $pet) {
                            if (!empty($pet)) {
                                $totalPet++;
                            }
                        }
                    }
                } else {
                    // Uncomment the following line for debugging
                    // echo "Error in pet query: " . mysqli_error($conn);
                    $totalPet = 0; // Set to 0 or handle the error accordingly
                }
                ?>


                <?php
                require 'database-conn.php';

                // Set the timezone to Asia/Manila
                date_default_timezone_set('Asia/Manila');

                $currentDate = new DateTime();
                $currentDateFormatted = $currentDate->format('Y-m-d');

                // Display the current date in the Philippine timezone
                $philippineDate = $currentDate->format('Y-m-d H:i:s T');

                // customer
                $query = "SELECT COUNT(*) as count FROM schedule WHERE date = '$currentDateFormatted' AND status = 'Done'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $dailyCustomers = $row['count'];
                } else {
                    // Uncomment the following line for debugging
                    // echo "Error in customer query: " . mysqli_error($conn);
                    $dailyCustomers = 0; // Set to 0 or handle the error accordingly
                }

                // pet
                $query2 = "SELECT petname, petname2, petname3, petname4, petname5 FROM schedule WHERE date = '$currentDateFormatted' AND status = 'Done'";
                $result2 = mysqli_query($conn, $query2);

                if ($result2) {
                    $dailyPets = 0;

                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        // Loop through each column and count the pets
                        foreach ($row2 as $pet) {
                            if (!empty($pet)) {
                                $dailyPets++;
                            }
                        }
                    }
                } else {
                    // Uncomment the following line for debugging
                    // echo "Error in pet query: " . mysqli_error($conn);
                    $dailyPets = 0; // Set to 0 or handle the error accordingly
                }

                // grooming
                $query3 = "SELECT service, service2, service3 FROM schedule WHERE date = '$currentDateFormatted' AND status = 'Done'";
                $result3 = mysqli_query($conn, $query3);

                if ($result3) {
                    $dailyGrooming = 0;

                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        // Loop through each column and count the grooming services
                        foreach ($row3 as $service) {
                            if (!empty($service) && $service == "Grooming") {
                                $dailyGrooming++;
                            }
                        }
                    }
                } else {
                    // Uncomment the following line for debugging
                    // echo "Error in grooming query: " . mysqli_error($conn);
                    $dailyGrooming = 0; // Set to 0 or handle the error accordingly
                }
                ?>

                <br>
                <h2 style="text-align: center;">Overall Total</h2>
                <div class="boxes-report">
                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>
                        <span class="text">Customers</span>
                        <span class="number"><?php echo $totalCustomer; ?></span>
                    </div>
                    <div class="box-report box4-report">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">Pets</span>
                        <span class="number"><?php echo $totalPet; ?></span>
                    </div>
                </div>


                <br>
                <h2>Daily</h2>
                <div class="boxes-report">
                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>
                        <span class="text">Customers</span>
                        <span class="number"><?php echo $dailyCustomers; ?></span>
                    </div>
                    <div class="box-report box4-report">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">Pets</span>
                        <span class="number"><?php echo $dailyPets; ?></span>
                    </div>
                </div>

                <!-- Weekly -->
                <?php
                require 'database-conn.php';

                // Set the timezone to Asia/Manila
                date_default_timezone_set('Asia/Manila');

                $currentDate = new DateTime();
                $currentWeek = $currentDate->format('W'); // Get the current week number

                // customer
                // get the count of scheduled items for the current week
                $query = "SELECT COUNT(*) as count FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $weeklyCustomers = $row['count'];
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // pet
                // get the count of scheduled items for the current week
                $query2 = "SELECT petname, petname2, petname3, petname4, petname5 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result2 = mysqli_query($conn, $query2);

                if ($result2) {
                    $weeklyPets = 0;

                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        // Loop through each column and count the pets
                        foreach ($row2 as $pet) {
                            if (!empty($pet)) {
                                $weeklyPets++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // grooming
                // get the count of scheduled items for the current week
                $query3 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result3 = mysqli_query($conn, $query3);

                if ($result3) {
                    $weeklyGrooming = 0;

                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        // Loop through each column and count the grooming services
                        foreach ($row3 as $service) {
                            if (!empty($service) && $service == "Grooming") {
                                $weeklyGrooming++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // Consultation and Treatment
                // get the count of scheduled items for the current week
                $query4 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result4 = mysqli_query($conn, $query4);

                if ($result4) {
                    $weeklyConsult = 0;

                    while ($row4 = mysqli_fetch_assoc($result4)) {
                        // Loop through each column and count the grooming services
                        foreach ($row4 as $service) {
                            if (!empty($service) && $service == "Consultation and Treatment") {
                                $weeklyConsult++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // Lab Test
                // get the count of scheduled items for the current week
                $query5 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result5 = mysqli_query($conn, $query5);

                if ($result5) {
                    $weeklyLab = 0;

                    while ($row5 = mysqli_fetch_assoc($result5)) {
                        // Loop through each column and count the grooming services
                        foreach ($row5 as $service) {
                            if (!empty($service) && $service == "Lab Test") {
                                $weeklyLab++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // Surgery
                // get the count of scheduled items for the current week
                $query6 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result6 = mysqli_query($conn, $query6);

                if ($result6) {
                    $weeklySurgery = 0;

                    while ($row6 = mysqli_fetch_assoc($result6)) {
                        // Loop through each column and count the grooming services
                        foreach ($row6 as $service) {
                            if (!empty($service) && $service == "Surgery") {
                                $weeklySurgery++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // Surgery
                // get the count of scheduled items for the current week
                $query6 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result6 = mysqli_query($conn, $query6);

                if ($result6) {
                    $weeklySurgery = 0;

                    while ($row6 = mysqli_fetch_assoc($result6)) {
                        // Loop through each column and count the grooming services
                        foreach ($row6 as $service) {
                            if (!empty($service) && $service == "Surgery") {
                                $weeklySurgery++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }

                // Vaccine
                // get the count of scheduled items for the current week
                $query7 = "SELECT service, service2, service3 FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                $result7 = mysqli_query($conn, $query7);

                if ($result7) {
                    $weeklyVaccine = 0;

                    while ($row7 = mysqli_fetch_assoc($result7)) {
                        // Loop through each column and count the grooming services
                        foreach ($row7 as $service) {
                            if (!empty($service) && $service == "Vaccine") {
                                $weeklyVaccine++;
                            }
                        }
                    }
                } else {
                    // echo "Error in query: " . mysqli_error($conn);
                }
                ?>

                <br>
                <h2>Weekly</h2>

                <div class="boxes-report">
                    <div class="numbered-analytics">
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Customer</h3>
                            <h2><?php echo $weeklyCustomers; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Pets</h3>
                            <h2><?php echo $weeklyPets; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Grooming</h3>
                            <h2><?php echo $weeklyGrooming; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Consultation and Treatment</h3>
                            <h2><?php echo $weeklyConsult; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Lab Test</h3>
                            <h2><?php echo $weeklyLab; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Surgery</h3>
                            <h2><?php echo $weeklySurgery; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Vaccine</h3>
                            <h2><?php echo $weeklyVaccine; ?></h2>
                        </div>
                    </div>
                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>

                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $currentDate = new DateTime();
                        $currentWeek = $currentDate->format('W');

                        // Assuming you have a valid database connection in $conn
                        $query = "SELECT * FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                        $result = mysqli_query($conn, $query);

                        $weeklyData = [];

                        if ($result) {
                            $dailyCounts = array_fill(0, 7, 0); // Initialize the array with zeros

                            while ($row = mysqli_fetch_assoc($result)) {
                                $dayOfWeek = (new DateTime($row['date']))->format('N') - 1;

                                $dailyCounts[$dayOfWeek]++;
                            }
                            $weeklyData = array_values($dailyCounts);
                        } else {
                            // Handle the error
                        }

                        ?>

                        <canvas id="weeklyGraph1" width="800" height="400"></canvas>

                        <script>
                            // Use PHP data to initialize JavaScript variable
                            var weeklyData = <?php echo json_encode($weeklyData); ?>;

                            // Convert PHP data to Chart.js dataset format
                            var chartData = {
                                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                                datasets: [{
                                    label: 'Weekly Customer',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: weeklyData,
                                }]
                            };

                            // Get the canvas element
                            var ctx = document.getElementById('weeklyGraph1').getContext('2d');

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Count'
                                            },
                                            ticks: {
                                                beginAtZero: true // Start the y-axis from zero
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>


                        <br>

                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $currentDate = new DateTime();
                        $currentWeek = $currentDate->format('W');

                        $queryzzz = "SELECT petname, petname2, petname3, petname4, petname5, date FROM schedule WHERE WEEK(date) = '$currentWeek' AND status = 'Done'";
                        $resultzzz = mysqli_query($conn, $queryzzz);

                        $weeklyPetsData = [];

                        if ($resultzzz) {
                            $dailyCounts = array_fill(0, 7, 0); // Initialize the array with zeros

                            while ($row2 = mysqli_fetch_assoc($resultzzz)) {
                                $dayOfWeek = (new DateTime($row2['date']))->format('N') - 1;
                                // Loop through each column and count the pets
                                foreach ($row2 as $key => $pet) {
                                    if ($key !== 'date' && !empty($pet)) {
                                        $dailyCounts[$dayOfWeek]++;
                                    }
                                }
                            }

                            $weeklyPetsData = array_values($dailyCounts);
                        }
                        ?>



                        <canvas id="weeklyGraph2" width="800" height="400"></canvas>

                        <script>
                            var weeklyData = <?php echo json_encode($weeklyPetsData); ?>;

                            var chartData = {
                                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                                datasets: [{
                                    label: 'Weekly Pets',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: weeklyData,
                                }]
                            };

                            var ctx = document.getElementById('weeklyGraph2').getContext('2d');

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Count'
                                            },
                                            ticks: {
                                                beginAtZero: true // Start the y-axis from zero
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>

                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>
                        <p>Services</p>
                        <canvas id="myPieChart" width="400" height="400"></canvas>

                        <?php
                        $data = [
                            'Labels' => ['Grooming', 'Consultation and Treatment', 'Lab Test', 'Surgery', 'Vaccine'],
                            'Values' => [$weeklyGrooming, $weeklyConsult, $weeklyLab, $weeklySurgery, $weeklyVaccine],
                        ];

                        $jsonData = json_encode($data);
                        ?>

                        <script>
                            // Parse JSON data
                            var data = <?php echo $jsonData; ?>;

                            // Create a pie chart
                            var ctx = document.getElementById('myPieChart').getContext('2d');
                            var myPieChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: data.Labels,
                                    datasets: [{
                                        data: data.Values,
                                        backgroundColor: ['#FFB6C1', '#FFD700', '#FFECB3', '#98FB98', '#ADD8E6', '#B19CD9', '#D8BFD8'],
                                    }],
                                },
                            });
                        </script>
                    </div>
                </div>

                <div class="boxes-report">



                </div>

                <!-- Monthly -->
                <?php
                require 'database-conn.php';

                date_default_timezone_set('Asia/Manila');

                $filterStart = isset($_GET['filter_monthS']) ? $_GET['filter_monthS'] : date('Y-m');
                $filterEnd = isset($_GET['filter_monthE']) ? $_GET['filter_monthE'] : date('Y-m');

                $currentMonthS = new DateTime($filterStart);
                $currentMonthE = new DateTime($filterEnd);

                $monthStart = $currentMonthS->format('Y-m');
                $monthEnd = $currentMonthE->format('Y-m');

                $query = "SELECT COUNT(*) as count FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $monthlyCustomers = $row['count'];
                }

                $query2 = "SELECT petname, petname2, petname3, petname4, petname5 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result2 = mysqli_query($conn, $query2);

                if ($result2) {
                    $monthlyPets = 0;

                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        foreach ($row2 as $pet) {
                            if (!empty($pet)) {
                                $monthlyPets++;
                            }
                        }
                    }
                }

                $query3 = "SELECT service, service2, service3 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result3 = mysqli_query($conn, $query3);

                if ($result3) {
                    $monthlyGrooming = 0;

                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        foreach ($row3 as $service) {
                            if (!empty($service) && $service == "Grooming") {
                                $monthlyGrooming++;
                            }
                        }
                    }
                }

                $query4 = "SELECT service, service2, service3 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result4 = mysqli_query($conn, $query4);

                if ($result4) {
                    $monthlyConsult = 0;

                    while ($row4 = mysqli_fetch_assoc($result4)) {
                        foreach ($row4 as $service) {
                            if (!empty($service) && $service == "Consultation and Treatment") {
                                $monthlyConsult++;
                            }
                        }
                    }
                }

                $query5 = "SELECT service, service2, service3 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result5 = mysqli_query($conn, $query5);

                if ($result5) {
                    $monthlyLab = 0;

                    while ($row5 = mysqli_fetch_assoc($result5)) {
                        foreach ($row5 as $service) {
                            if (!empty($service) && $service == "Lab Test") {
                                $monthlyLab++;
                            }
                        }
                    }
                }

                $query6 = "SELECT service, service2, service3 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result6 = mysqli_query($conn, $query6);

                if ($result6) {
                    $monthlySurgery = 0;

                    while ($row6 = mysqli_fetch_assoc($result6)) {
                        foreach ($row6 as $service) {
                            if (!empty($service) && $service == "Surgery") {
                                $monthlySurgery++;
                            }
                        }
                    }
                }

                $query7 = "SELECT service, service2, service3 FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                $result7 = mysqli_query($conn, $query7);

                if ($result7) {
                    $monthlyVaccine = 0;

                    while ($row7 = mysqli_fetch_assoc($result7)) {
                        foreach ($row7 as $service) {
                            if (!empty($service) && $service == "Vaccine") {
                                $monthlyVaccine++;
                            }
                        }
                    }
                }
                ?>

                <br>
                <h2>Monthly</h2>
                <br>

                <form method="get" action="">
                    <label for="filterM">Filter by Month:</label>
                    <label for="filterM"> &nbsp; Start Month: &nbsp; </label>
                    <input type="month" id="filterStart" name="filter_monthS" value="<?php echo $monthStart; ?>" />
                    <label for="filterM"> &nbsp; End Month: &nbsp; </label>
                    <input type="month" id="filterEnd" name="filter_monthE" value="<?php echo $monthEnd; ?>" />
                    <input class="filter-bttn" type="submit" value="Apply Filter" />
                </form>
                <div class="boxes-report">
                    <div class="numbered-analytics">
                        <i class="uil uil-thumbs-up"></i>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Customer</h3>
                            <h2><?php echo $monthlyCustomers; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Pets</h3>
                            <h2><?php echo $monthlyPets; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Grooming</h3>
                            <h2><?php echo $monthlyGrooming; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Consultation and Treatment</h3>
                            <h2><?php echo $monthlyConsult; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Lab Test</h3>
                            <h2><?php echo $monthlyLab; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Surgery</h3>
                            <h2><?php echo $monthlySurgery; ?></h2>
                        </div>
                        <div class="box-report box4-report">
                            <i class="uil uil-thumbs-up"></i>
                            <h3>Vaccine</h3>
                            <h2><?php echo $monthlyVaccine; ?></h2>
                        </div>

                    </div>
                </div>
                <div class="boxes-report">

                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>

                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $filterStart = isset($_GET['filter_monthS']) ? $_GET['filter_monthS'] : date('Y-m');
                        $filterEnd = isset($_GET['filter_monthE']) ? $_GET['filter_monthE'] : date('Y-m');

                        $currentMonthS = new DateTime($filterStart);
                        $currentMonthE = new DateTime($filterEnd);

                        $monthStart = $currentMonthS->format('Y-m');
                        $monthEnd = $currentMonthE->format('Y-m');

                        $query = "SELECT MONTH(date) as month, COUNT(*) as count FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done' GROUP BY month";

                        $result = mysqli_query($conn, $query);

                        $monthlyData = [];

                        if ($result) {
                            $monthlyCounts = array_fill(1, 12, 0);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $month = $row['month'];
                                $monthlyCounts[$month] = $row['count'];
                            }

                            // Fill in missing months with zero count
                            for ($i = 1; $i <= 12; $i++) {
                                if (!isset($monthlyCounts[$i])) {
                                    $monthlyCounts[$i] = 0;
                                }
                            }

                            ksort($monthlyCounts); // Sort the array by key

                            $monthlyData = array_values($monthlyCounts);
                        } else {
                            // Handle the error
                        }
                        ?>


                        <canvas id="monthlyGraph123" width="800" height="400"></canvas>

                        <script>
                            var monthlyData = <?php echo json_encode($monthlyData); ?>;
                            var monthLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                            var chartData = {
                                labels: monthLabels,
                                datasets: [{
                                    label: 'Monthly Customer',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: monthlyData,
                                }]
                            };

                            var ctx = document.getElementById('monthlyGraph123').getContext('2d');

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Count'
                                            },
                                            ticks: {
                                                beginAtZero: true // Start the y-axis from zero
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>

                        <br>

                        <?php
                        date_default_timezone_set('Asia/Manila');

                        $filterStart = isset($_GET['filter_monthS']) ? $_GET['filter_monthS'] : date('Y-m');
                        $filterEnd = isset($_GET['filter_monthE']) ? $_GET['filter_monthE'] : date('Y-m');

                        $currentMonthS = new DateTime($filterStart);
                        $currentMonthE = new DateTime($filterEnd);

                        $monthStart = $currentMonthS->format('Y-m');
                        $monthEnd = $currentMonthE->format('Y-m');

                        $queryzzz55 = "SELECT petname, petname2, petname3, petname4, petname5, MONTH(date) as month FROM schedule WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN '$monthStart' AND '$monthEnd' AND status = 'Done'";
                        $resultzzz55 = mysqli_query($conn, $queryzzz55);

                        $monthlyPetsData55 = [];

                        if ($resultzzz55) {
                            $monthlyCounts = array_fill(1, 12, 0); // Initialize the array with zeros for 12 months

                            while ($row2 = mysqli_fetch_assoc($resultzzz55)) {
                                $month = $row2['month'];
                                // Loop through each column and count the pets
                                foreach ($row2 as $key => $pet) {
                                    if ($key !== 'month' && !empty($pet)) {
                                        $monthlyCounts[$month]++;
                                    }
                                }
                            }

                            $monthlyPetsData55 = array_values($monthlyCounts);
                        }
                        ?>

                        <canvas id="monthlyGraph255" width="800" height="400"></canvas>

                        <script>
                            var monthlyData = <?php echo json_encode($monthlyPetsData55); ?>;
                            var monthLabels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                            var chartData = {
                                labels: monthLabels,
                                datasets: [{
                                    label: 'Monthly Pets',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    data: monthlyData,
                                }]
                            };

                            var ctx = document.getElementById('monthlyGraph255').getContext('2d');

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        yAxes: [{
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Count'
                                            },
                                            ticks: {
                                                beginAtZero: true // Start the y-axis from zero
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>

                    </div>


                    <div class="box-report box3-report">
                        <i class="uil uil-share"></i>
                        <p>services</p>
                        <canvas id="myPieChart2" width="400" height="400"></canvas>

                        <?php
                        $data = [
                            'Labels' => ['Grooming', 'Consultation and Treatment', 'Lab Test', 'Surgery', 'Vaccine'],
                            'Values' => [$monthlyGrooming, $monthlyConsult, $monthlyLab, $monthlySurgery, $monthlyVaccine],
                        ];

                        $jsonData = json_encode($data);
                        ?>

                        <script>
                            // Parse JSON data
                            var data = <?php echo $jsonData; ?>;

                            // Create a pie chart
                            var ctx = document.getElementById('myPieChart2').getContext('2d');
                            var myPieChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: data.Labels,
                                    datasets: [{
                                        data: data.Values,
                                        backgroundColor: ['#FFB6C1', '#FFD700', '#FFECB3', '#98FB98', '#ADD8E6', '#B19CD9', '#D8BFD8'],
                                    }],
                                },
                            });
                        </script>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add change event listener to both month input fields
            $('#filterStart, #filterEnd').on('change', function() {
                // Get the selected value
                var selectedMonth = $(this).val();

                // Display the selected value in the monthHolder element
                $('#monthHolder').val(selectedMonth);
            });
        });
    </script>

    <script>
        const body = document.querySelector("body"),
            modeToggle = body.querySelector(".mode-toggle");
        sidebar = body.querySelector("nav");
        sidebarToggle = body.querySelector(".sidebar-toggle");

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                localStorage.setItem("status", "close");
            } else {
                localStorage.setItem("status", "open");
            }
        });

        function openClientRecords() {
            document.getElementById("viewClientRecord").style.display = "block";
            document.getElementById("viewCustomer").style.display = "none";
            document.getElementById("viewPet").style.display = "none";
        }

        function openCustomer() {
            document.getElementById("viewClientRecord").style.display = "none";
            document.getElementById("viewCustomer").style.display = "block";
            document.getElementById("viewPet").style.display = "none";
        }

        function openFormPets() {
            document.getElementById("viewClientRecord").style.display = "none";
            document.getElementById("viewCustomer").style.display = "none";
            document.getElementById("viewPet").style.display = "block";
        }
    </script>
</body>

</html>