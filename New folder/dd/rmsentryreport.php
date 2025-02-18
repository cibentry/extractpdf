<?php include('db.php');
session_start();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Entry</title>
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
                    <a href="logout.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">logout</a>
                </div>

            </div>
        </div>
    </div>
    <div class="cont my-1 ">

        <div class="row">
            <div class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                <div class="list-group m-3">
                    <a href="rms.php" class="list-group-item list-group-item-action active">Home</a>
                    <a href="rmsbusinesssummary.php" class="list-group-item list-group-item-action">Business Summary</a>
                    <a href="rmspolicytransaction.php" class="list-group-item list-group-item-action">Policy
                        Transaction</a>
                    <a href="mtdrmspolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy
                        Transaction</a> 
                    <a href="#" class="list-group-item list-group-item-action">Entry Report</a>
                    <a href="rmsbusinessentry.php" class="list-group-item list-group-item-action">Business Entry

                    </a>
                    <a href="rmssearch.php" class="list-group-item list-group-item-action">Search</a>
                </div>

            </div>
            <div class="col-sm-8 my-1">
                <div class="row">
                    <div class="col-sm-4 my-1">
                    <div class="card text-white bg-success mb-3">
                            <div class="card-header">Premium Booked</div>
                                <div class="card-body">
                                <?php
                                    $currentDate = date("Y-m-d");
                                    $manager=$_SESSION['username'];
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
                                    $sqlreport = "SELECT SUM(net_premium) AS total_commission
                                                        FROM daily_booking WHERE sm_name = '$manager' AND f_year = '$fiscalYear' 
                                                        AND month_name = '$monthName' AND booking_status = 'Booked'";
                                    $mtdquery = mysqli_query($con,$sqlreport) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_commission = $row['total_commission'] ?? 0;
                                        echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                    }         
                                    
                                ?> 
                            </div>
                        </div>   
                    </div>
                    <!--- pending premium --->
                    <div class="col-sm-4 my-1">
                    <div class="card text-white bg-danger mb-3">
                            <div class="card-header">Premium Pending</div>
                                <div class="card-body">
                                <?php
                                    $currentDate = date("Y-m-d");
                                    $manager=$_SESSION['username'];
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
                                    $sqlreport = "SELECT SUM(net_premium) AS total_commission
                                                        FROM daily_booking WHERE sm_name = '$manager' AND f_year = '$fiscalYear' 
                                                        AND month_name = '$monthName' AND booking_status = 'Pending'";
                                    $mtdquery = mysqli_query($con,$sqlreport) ;
                                    $row = mysqli_num_rows($mtdquery);
                                    //echo($row);
                                    if($row > 0){
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
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    