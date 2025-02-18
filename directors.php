<?php
include('db.php');
session_start();
if (!isset($_SESSION['access_id'])) {
    header('location:login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Total Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid m-auto mx-1 ">
        <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
            <div class="row">
                <div class="col-10 col-sm-6 col-md-10">
                    <!--<h1>Hello, </h1>-->
                    <h1 class="head text-light">MANAGEMENT</h1>
                    <?php
                    require 'db.php';


                    $query = mysqli_query($con, "SELECT * FROM `newemp` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                    $fetch = mysqli_fetch_array($query);

                    echo "<h5 class='text-light mx-3 fw-bolder'>" . $fetch['name'] . "</h5>";
                    ?>
                </div>
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="logout.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button" aria-pressed="true">logout</a>
                </div>

            </div>
        </div>
        <div class="cont my-1 ">
            <div class="row">
                <div class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                    <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                    <div class="list-group m-3">
                        <a href="#" class="list-group-item list-group-item-action">Home</a>
                        <a href="directorsbusinessreport.php" class="list-group-item list-group-item-action">Business Summary</a>
                        <a href="directorspolicytransaction.php" class="list-group-item list-group-item-action">Policy Transaction</a>
                        <a href="directorsmtdpolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy Transaction</a>
                        <a href="directorsentryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                        <a href="directorsheadsearch.php" class="list-group-item list-group-item-action">Search</a>
                    </div>
                    <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                    <div class="list-group m-3">
                        <a href="directorsmtdbookingreport.php" class="list-group-item list-group-item-action">MTD Booking Report</a>
                        <a href="directors_sm_r.php" class="list-group-item list-group-item-action">Manager Level Report</a>


                    </div>
                </div>
                <div class="col-sm-8 border border-success">
                    <div class="row">
                        zone wise table
                        <?php
                        $currentDate = date("Y-m-d");

                        $monthName = date("F", strtotime($currentDate));

                        // Calculate the fiscal year
                        $currentYear = date("Y");
                        $fiscalYearStart = $currentYear; // Current year
                        $fiscalYearEnd = $currentYear + 1; // Next year

                        // Determine if the current month is before or after April
                        if (date("n") < 4) { // If the month is January (1), February (2), or March (3)
                            $fiscalYearStart = $currentYear - 1; // Previous year
                            $fiscalYearEnd = $currentYear; // Current year
                        }
                        // Format the fiscal year as "YYYY-YY"
                        $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"

                        $query = "SELECT
                                mapped_zone,
                                SUM(CASE WHEN f_year = '$fiscalYear' THEN net_premium ELSE 0 END) AS YTD,
                                SUM(CASE WHEN MONTH(CURRENT_DATE) = MONTH(STR_TO_DATE(policy_sold_date, '%Y-%m-%d')) 
                                          AND YEAR(CURRENT_DATE) = YEAR(STR_TO_DATE(policy_sold_date, '%Y-%m-%d')) THEN net_premium ELSE 0 END) AS MTD,
                                SUM(CASE WHEN entry_date = CURRENT_DATE THEN net_premium ELSE 0 END) AS FTD,
                                SUM(CASE WHEN booking_status = 'pending' THEN net_premium ELSE 0 END) AS Pending
                              FROM 
                                daily_booking
                              GROUP BY
                                mapped_zone
                              ORDER BY
                                FTD DESC;";

                        $result = mysqli_query($con, $query);

                        // Generate the HTML table
                        echo "<table class='table table-striped table-bordered table-hover'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr>
                                    <th>State Name</th>
                                    <th>YTD</th>
                                    <th>MTD</th>
                                    <th>FTD</th>
                                    <th>Pending</th>
                            </tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['state_name'] . "</td>
                                    <td>" . $row['YTD'] . "</td>
                                    <td>" . $row['MTD'] . "</td>
                                    <td>" . $row['FTD'] . "</td>
                                    <td style='color: red'>" . $row['Pending'] . "</td>
                                </tr>";
                        }

                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script>
                // Get the current date
                var date = new Date();

                // Get the current year, month, and day
                var currentYear = date.getFullYear(); // e.g., 2024
                //var currentMonth = date.getMonth() + 1; // e.g., 10 (getMonth() is zero-indexed, so +1 for October)
                var currentYear = date.getFullYear();
                var nextYear = currentYear + 1;
                var yearRange = currentYear + "-" + (nextYear % 100);

                var currentDay = new date().getDate(); // e.g., 3

                // Send AJAX request with year, month, and day to PHP
                $.ajax({
                    type: "POST",
                    url: "directorspivotsales.php", // Update with the actual PHP file
                    data: {
                        year: yearRange,
                        month: currentMonth,
                        day: currentDay
                    },
                    success: function(response) {
                        // Parse the JSON response
                        $('#table-container').html(response);
                    },
                    error: function() {
                        console.log('Error fetching sales data');
                    }
                });
            </script>