<?php include('db.php');
session_start();

$pendingquery = "SELECT COUNT(*) as pendingcount from daily_booking where booking_status = 'pending'";
$pendingresult = mysqli_query($con, $pendingquery);

// Fetch result from database
$rows = $pendingresult->fetch_assoc();
$pendingcount = $rows['pendingcount'];

if ($pendingresult) {
    $rows = $pendingresult->fetch_assoc();
    if ($rows) {
        $pendingcount = $rows['pendingcount'];
    }

} else {
    $pending_count = 0; // Default to 0 if the query fails
}

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
                    <a href="#.php" class="list-group-item list-group-item-action active">Home</a>
                    <!-- Pending Entry with Notification Badge -->
                    <a href="pendingentry.php" class="list-group-item list-group-item-action">
                        Pending Entry
                        <?php if ($pendingcount > 0): ?>
                            <span class="badge bg-danger ms-2"><?php echo $pendingcount; ?></span>
                        <?php endif; ?>
                    </a>

                    <a href="operationentryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                    <a href="businessentry.php" class="list-group-item list-group-item-action">Business Entry
                        <a href="entryupload.php" class="list-group-item list-group-item-action">Business Entry
                            Upload</a>
                    </a>

                </div>

            </div>

            <div class="col-sm-8 my-1 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3">
                <div class="row">
                    <div class="col-sm-6">
                        <p>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseWidthExample" aria-expanded="false"
                                aria-controls="collapseWidthExample">
                                NOP Inwarded
                            </button>
                        </p>
                        <div style="min-height: 120px;">
                            <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                <div class="card card-body fw-bolder" style="width: 300px;">
                                    
                                    <?php
                                        $currentDate = date("Y-m-d");
                                        $noquery = "SELECT COUNT(*) as total_entries FROM daily_booking WHERE entry_date = '$currentDate'";
                                        $mtdquery = mysqli_query($con,$noquery) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_number = $row['total_commission'] ?? 0;
                                        echo ("Total Number of Policies Inwarded: " .  $total_number);

                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                <div class="card card-body fw-bolder" style="width: 300px;">
                                    
                                    <?php
                                        $currentDate = date("Y-m-d");
                                        $noquery = "SELECT COUNT(*) as total_entries FROM daily_booking WHERE entry_date = '$currentDate'";
                                        $mtdquery = mysqli_query($con,$noquery) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_number = $row['total_commission'] ?? 0;
                                        echo ("Total Premium Inwarded: " .  $total_number);

                                    }
                                    ?>
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6">
                    <p>
                            
                        </p>
                        <div style="min-height: 120px;">
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p1 class="fw-bolder ">MTD RM Wise Booking Report</p1>
                    <?php
                    $zonequery = "SELECT mapped_zone_id FROM `newemp` WHERE `name`='$_SESSION[username]'";
                    $zoneresult = mysqli_query($con, $zonequery) or die(mysqli_error());
                    $zonerow = mysqli_fetch_array($zoneresult); 
                    if($zonerow > 0){
                        $zoneid = $zonerow['mapped_zone_id'];
                    }

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

                    $sqldisplay = "SELECT 
                            sm_name, 
                            SUM(CASE WHEN product_type = 'Four Wheeler' THEN net_premium ELSE 0 END) as PVT, 
                            SUM(CASE WHEN product_type = 'Two Wheeler' THEN net_premium ELSE 0 END) as Two_Wheeler, 
                            SUM(CASE WHEN product_type = 'Commercial Vehicle' THEN net_premium ELSE 0 END) as Commercial_vehicle, 
                            SUM(CASE WHEN product_type = 'Health' THEN net_premium ELSE 0 END) as Health,
                            SUM(net_premium) AS Total_Premuim
                            FROM 
                            daily_booking 
                            WHERE
                            month_name = '$monthName' AND mapped_zone_id = '$zoneid'
                            GROUP BY 
                            sm_name
                            ORDER BY 
                            Total_Premuim DESC;";
                            $sqlresult = $con->query($sqldisplay); //echo $sqldisplay;
                            $disrow = mysqli_num_rows($sqlresult);
                            if($disrow > 0){
                                echo "<table class='table table-hover text-center table-danger bg-gradient bg-opacity-10 shadow-sm m-auto'>";
                                echo "<tr>";
                                echo "<th>SM Name</th>";
                                echo "<th>PVT</th>";
                                echo "<th>Two Wheeler</th>";
                                echo "<th>Commercial Vehicle</th>";
                                echo "<th>Health</th>";
                                echo "<th>Total Premium</th>";
                                
                                echo "</tr>";
                                $totalPVT = 0;
                                $totalTwoWheeler = 0;
                                $totalCommercial = 0;
                                $totalHealth = 0;
                                $grandTotalPremium = 0;
                                while($row = mysqli_fetch_assoc($sqlresult)){
                                    echo "<tr>
                                        <td>".htmlspecialchars($row['sm_name'])."</td>
                                        <td>".htmlspecialchars($row['PVT'])."</td>
                                        <td>".htmlspecialchars($row['Two_Wheeler'])."</td>
                                        <td>".htmlspecialchars($row['Commercial_vehicle'])."</td>
                                        <td>".htmlspecialchars($row['Health'])."</td>
                                        <td style='font-weight: bold;'>".htmlspecialchars($row['Total_Premuim'])."</td>
                                        
                                        </tr>";
                                    $totalPVT += $row['PVT'];
                                    $totalTwoWheeler += $row['Two_Wheeler'];
                                    $totalCommercial += $row['Commercial_vehicle'];
                                    $totalHealth += $row['Health'];
                                    $grandTotalPremium += $row['Total_Premuim'];

                                }
                                echo "<tr style='font-weight: bold;'>";
                                echo "<td>Grand Total</td>";
                                echo "<td>$totalPVT</td>";
                                echo "<td>$totalTwoWheeler</td>";
                                echo "<td>$totalCommercial</td>";
                                echo "<td>$totalHealth</td>";
                                echo "<td>$grandTotalPremium</td>";
                                echo "</tr>";
                                echo "</table>";

                            }else{
                        echo "No Record Found";
                    }
                    ?> 
               
                </div>
               
            
            </div>

        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>