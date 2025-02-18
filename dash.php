

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
<style>
.crawling-text {
    position: fixed; /* Keep it fixed at the top */
    top: 0; /* Position at the top */
    left: 100%; /* Start off the right side of the screen */
    width: auto; /* Auto width to fit the text */
    background-color: yellow; /* Yellow background */
    color: red; /* Red font color */
    font-weight: bold; /* Bold font */
    white-space: nowrap;
    animation: crawl 20s linear infinite; /* Adjusted duration for slower speed */
}

@keyframes crawl {
    from {
        left: 100%; /* Start off the screen */
    }
    to {
        left: -100%; /* Move off the left side of the screen */
    }
}
</style>

    </head>

<body>
    <div class="container-fluid m-auto mx-1 ">
    <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
        <div class="row">
            <div class="col-8 col-sm-6 col-md-8 ">
                <!--<h1>Hello, </h1>-->
                <h1 class="head text-light">MANAGEMENT</h1>
                <?php
                require 'db.php';


                $query = mysqli_query($con, "SELECT * FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                $fetch = mysqli_fetch_array($query);

                echo "<h5 class='text-light mx-3 fw-bolder'>" . $fetch['name'] . "</h5>";
                echo "<p class='text-light mx-3'>Employee Code : <em>" . $fetch['code'] . "</em></p>"; // Changed to italic // Added line to show ID
                ?>
            </div>
            <div class="col-3 " >
            <?php
            $sql = "SELECT SUM(net_premium) AS total_pending FROM daily_booking WHERE booking_status = 'pending'";
            $result = $con->query($sql);
            
            $total_pending = 0; // Default value
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total_pending = $row['total_pending'];
            } else {
                $total_pending = 0; // No records found
            }

            ?>
            <h3 style="background-color: yellow; color: red; font-weight: bold;">Total Premium Pending for Booking :  <?php echo $total_pending; ?></h3>
            </div>  
            <div class="col-12 col-sm-6 col-md-1  ">
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
                <a href="businessreport.php" class="list-group-item list-group-item-action">Business Summary</a>
                <a href="policytransaction.php" class="list-group-item list-group-item-action">Policy Transaction</a>
                <a href="mtdpolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy Transaction</a>
                <a href="entryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                <a href="headsearch.php" class="list-group-item list-group-item-action">Search</a>
            </div>
            <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
            <div class="list-group m-3">
                <a href="mtdbookingreport.php" class="list-group-item list-group-item-action">MTD Booking Report</a>
                <a href="zmrevenue.php" class="list-group-item list-group-item-action">Revenue</a>
                <a href="gridtrialmanagement.php" class="list-group-item list-group-item-action">Grid</a>
                <a href="zm_sm_r.php" class="list-group-item list-group-item-action">Manager Level Report</a>
                <a href="check_python.php" class="list-group-item list-group-item-action">python</a>
                <a href="employee_creation_it.php" class="list-group-item list-group-item-action">python</a>
                <?php
                require 'db.php';
                $query = mysqli_query($con, "SELECT * FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                $fetch = mysqli_fetch_array($query);
                $acid = $fetch['access_id'];
                ?>
                <a href="gridtrialmanagement.php?access_id=<?php echo $acid; ?>" class="list-group-item list-group-item-action">Grid</a>

            </div>
        </div>
        <div class="crawling-text">
            <?php
            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
            $fetchcode = mysqli_fetch_array($queryzcode);

            $mid = $fetchcode['mapped_zone_id'];

            $sql = "SELECT SUM(net_premium) AS total_pending FROM daily_booking WHERE booking_status = 'pending' and mapped_zone_id = '$mid'";
            $result = $con->query($sql);
            
            $total_pending = 0; // Default value
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total_pending = $row['total_pending'];
            } else {
                $total_pending = 0; // No records found
            }

            ?>
            Total Premium Pending for Booking :  <?php echo $total_pending; ?>
        </div> 
        <div class="col-sm-2 my-1 ">
            <div class="row m-2">   
                            
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">YTD Sales</div>
                    <div class="card-body">
                        <h5 class="card-title" id="ytd_sales"></h5>
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
                            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                            $fetchcode = mysqli_fetch_array($queryzcode);

                            $mid = $fetchcode['mapped_zone_id'];

                            
                            // Format the fiscal year as "YYYY-YY"
                            $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                            $mtd = "SELECT SUM(net_premium) AS total_commission
                                                FROM daily_booking WHERE f_year = '$fiscalYear' AND 	mapped_zone_id = '$mid'";
                                        $mtdquery = mysqli_query($con,$mtd) ;
                                        if($mtdquery){
                                            $row = mysqli_fetch_assoc($mtdquery);
                                            $total_commission = $row['total_commission'] ?? 0;
                                            echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                        }         
                                        $rmtc = $total_commission;
                        ?>
                    </div>
                
                </div>
            </div>
            <div class="row m-2">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Franchaise YTD Sales</div>
                        <div class="card-body">
                        <h5 class="card-title" id="ftd_sales"></h5>
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
                            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                            $fetchcode = mysqli_fetch_array($queryzcode);
                            // Format the fiscal year as "YYYY-YY"
                            $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                            $mtd = "SELECT SUM(net_premium) AS total_commission
                                                FROM franchaise_booking WHERE f_year = '$fiscalYear' AND mapped_zone_id = '$mid'";
                                        $mtdquery = mysqli_query($con,$mtd) ;
                                        if($mtdquery){
                                            $row = mysqli_fetch_assoc($mtdquery);
                                            $total_commission = $row['total_commission'] ?? 0;
                                            echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                        }
                                        $ftc = $total_commission;
                        ?>
                        </div>
                </div>
            </div> 
            <div class="row m-2">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">YTD Total Sales</div>
                    <div class="card-body">
                        <h5 class="card-title" id="ytd_sales"></h5>
                        <?php
                            $tc = $rmtc + $ftc;
                            echo "<h5>&#8377; " . number_format($tc, 2) . "</h5>";
                        ?>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-sm-2 my-1">  
            <div class="row m-2">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">MTD Sales</div>
                    <div class="card-body">
                        <h5 class="card-title" id="mtd_sales"></h5>
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
                            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                            $fetchcode = mysqli_fetch_array($queryzcode);

                            $mid = $fetchcode['mapped_zone_id'];
                            // Format the fiscal year as "YYYY-YY"
                            $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                            $mtd = "SELECT SUM(commissionable_premium) AS total_commission
                                                FROM daily_booking WHERE f_year = '$fiscalYear' AND month_name = '$monthName' and mapped_zone_id = '$mid'";
                                        $mtdquery = mysqli_query($con,$mtd) ;
                                        if($mtdquery){
                                            $row = mysqli_fetch_assoc($mtdquery);
                                            $total_commission = $row['total_commission'] ?? 0;
                                            echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                        }
                        ?>
                    </div>
                
                </div>
            </div>
            <div class="row m-2">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Franchaise MTD Sales</div>
                        <div class="card-body">
                        <h5 class="card-title" id="ftd_sales"></h5>
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
                            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                            $fetchcode = mysqli_fetch_array($queryzcode);
                            // Format the fiscal year as "YYYY-YY"
                            $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                            $mtd = "SELECT SUM(net_premium) AS total_commission
                                                FROM franchaise_booking WHERE f_year = '$fiscalYear'  AND month_name = '$monthName' and mapped_zone_id = '$mid'";
                                        $mtdquery = mysqli_query($con,$mtd) ;
                                        if($mtdquery){
                                            $row = mysqli_fetch_assoc($mtdquery);
                                            $total_commission = $row['total_commission'] ?? 0;
                                            echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                        }
                        ?>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 my-1">  
            <div class="row m-2">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">FTD Sales</div>
                    <div class="card-body">
                        <h5 class="card-title" id="ftd_sales"></h5>
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
                            $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                            $fetchcode = mysqli_fetch_array($queryzcode);
                            // Format the fiscal year as "YYYY-YY"
                            $mid = $fetchcode['mapped_zone_id'];
                            $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                            $mtd = "SELECT SUM(net_premium) AS total_commission
                                                FROM daily_booking WHERE entry_date = '$currentDate' and mapped_zone_id = '$mid'";
                                        $mtdquery = mysqli_query($con,$mtd) ;
                                        if($mtdquery){
                                            $row = mysqli_fetch_assoc($mtdquery);
                                            $total_commission = $row['total_commission'] ?? 0;
                                            echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row m-2">
                <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Franchaise FTD Sales</div>
                            <div class="card-body">
                            <h5 class="card-title" id="ftd_sales"></h5>
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
                                $queryzcode = mysqli_query($con, "SELECT 	* FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                                $fetchcode = mysqli_fetch_array($queryzcode);
                                // Format the fiscal year as "YYYY-YY"
                                $fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"
                                $mtd = "SELECT SUM(net_premium) AS total_commission
                                                    FROM franchaise_booking WHERE entry_date='$currentDate' and mapped_zone_id = '$mid'";
                                            $mtdquery = mysqli_query($con,$mtd) ;
                                            if($mtdquery){
                                                $row = mysqli_fetch_assoc($mtdquery);
                                                $total_commission = $row['total_commission'] ?? 0;
                                                echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                            }
                            ?>
                            </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // Get the current date
    var date = new Date();

    // Get the current year, month, and day
    var currentYear = date.getFullYear();       // e.g., 2024
    var currentMonth = date.getMonth() + 1;     // e.g., 10 (getMonth() is zero-indexed, so +1 for October)
    var currentDay  = new date().getDate();           // e.g., 3

    // Send AJAX request with year, month, and day to PHP
    $.ajax({
        type: "POST",
        url: "fetchsales.php", // Update with the actual PHP file
        data: {
            year: currentYear,
            month: currentMonth,
            day: currentDay
        },
        success: function (response) {
            // Parse the JSON response
            var salesData = JSON.parse(response);

            // Update the HTML elements with the sales data
            $('#ytd_sales').text('$' + salesData.ytd_sales);
            $('#mtd_sales').text('$' + salesData.mtd_sales);
            $('#ftd_sales').text('$' + salesData.ftd_sales);
        },
        error: function () {
            console.log('Error fetching sales data');
        }
    });
</script>
