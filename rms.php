<?php include('db.php');
session_start();
$query = "SELECT 
             COUNT(*) AS discrepancy_count 
          FROM 
             daily_booking 
          WHERE 
             (booking_status = 'discrepancy' Or booking_status='cancelled') and sm_name = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Get the count
$discrepancycount = $row['discrepancy_count'] ?? 0;
var_dump($row);
var_dump($_SESSION['username']);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .badge-new {
            background-color: #007bff;
            color: #ffffff;
            padding: 2px 6px;
            font-size: 12px;
            border-radius: 10px;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
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
                    echo "<p class='text-light mx-3'> <em>" . $fetch['emp_id'] . "</em></p>"; // Changed to italic // Added line to show ID
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
                    <a href="rms.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="profile_p.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-profile"></i> Profile
                    </a>
                    <a href="rmsbusinesssummary.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line"></i> Business Summary
                    </a>
                    <a href="rmspolicytransaction.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-invoice"></i> Policy Transaction
                    </a>
                    <a href="mtdrmspolicytransaction.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-invoice"></i> MTD Policy Transaction
                    </a>
                    <a href="rmsentryreport.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Entry Report
                    </a>
                    <a href="rmsbusinessentry.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit"></i> Business Entry
                    </a>
                    <a href="rmssearch.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-search"></i> Search
                    </a>
                    <a href="https://app.certigoinsurance.com/login" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Policy Issuance
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="discrepancies.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-exclamation-triangle"></i> Discrepancies
                        <?php var_dump($discrepancycount); ?>
                        <?php echo $discrepancycount; if ( $discrepancycount > 0 ): ?>
                        <span class="badge badge-danger"><?php echo $discrepancycount; ?></span>
                        <?php endif; ?>
                    </a>
                    
                </div>

            </div>


            <div class="col-sm-8 my-1">
                <div class="row">
                    <div class="col-sm-3 my-1">

                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">YTD Sales (Year-to-Date)</div>
                            <div class="card-body">
                                <h5 class="card-title" id="ytd_sales"></h5>
                                <?php
                                $manager = $_SESSION['username'];
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
                                $mtd = "SELECT SUM(net_premium) AS total_commission
                                               FROM daily_booking WHERE sm_name = '$manager' AND f_year = '$fiscalYear' and booking_status = 'Booked'";
                                $mtdquery = mysqli_query($con, $mtd);
                                if ($mtdquery) {
                                    $row = mysqli_fetch_assoc($mtdquery);
                                    $total_commission = $row['total_commission'] ?? 0;
                                    echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                }




                                ?>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-3 my-1">


                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">MTD Sales (Month-to-Date)</div>
                            <div class="card-body">
                                <h5 class="card-title" id="mtd_sales"></h5>
                                <?php
                                $manager = $_SESSION['username'];
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
                                $mtd = "SELECT SUM(net_premium) AS total_commission
                                               FROM daily_booking WHERE sm_name = '$manager' AND month_name = '$monthName'and booking_status = 'Booked'";
                                $mtdquery = mysqli_query($con, $mtd);
                                if ($mtdquery) {
                                    $row = mysqli_fetch_assoc($mtdquery);
                                    $total_commission = $row['total_commission'] ?? 0;
                                    echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-3 my-1">


                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">FTD Sales (Today)</div>
                            <div class="card-body">
                                <h5 class="card-title" id="ftd_sales"></h5>
                                <?php
                                $manager = $_SESSION['username'];
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
                                $mtd = "SELECT SUM(net_premium) AS total_commission
                                               FROM daily_booking WHERE sm_name = '$manager' AND entry_date = '$currentDate' and booking_status = 'Booked'";
                                $mtdquery = mysqli_query($con, $mtd);
                                if ($mtdquery) {
                                    $row = mysqli_fetch_assoc($mtdquery);
                                    $total_commission = $row['total_commission'] ?? 0;
                                    // Display the commissionable premium with INR symbol
                                    echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $uploads_dir = 'uploads/'; // path to your uploads folder
                            $images = scandir($uploads_dir);
                            $active = 'active';
                            foreach ($images as $image) {
                                if ($image != '.' && $image != '..') {
                                    echo '<div class="carousel-item ' . $active . '">';
                                    echo '<img src="' . $uploads_dir . $image . '" class="d-block w-100" alt="' . $image . '">';
                                    echo '</div>';
                                    $active = '';
                                }
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        var date = new Date();
        var month = date.toLocaleString('default', { month: 'long' });
        var day = date.getDate();
        var year = date.getFullYear().toString().substr(-2);

        var formattedDate = day + '-' + month + '-' + year;
        var newmonth = month;
        console.log(formattedDate);
        console.log(month);

        $.ajax({
            type: "POST",
            url: "fetchrmssales.php",
            data: { month: newmonth },
            success: function (data) {
                $("#sales").html(data);
            }
        });
    </script>

</body>

</html>