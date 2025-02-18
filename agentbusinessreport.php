<?php include('db.php');
session_start();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid m-auto mx-1 ">
        <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
                    <div class="row">
                        <div class="col-10 col-sm-6 col-md-10">
                            <!--<h1>Hello, </h1>-->
                            <h1 class="head text-light">POSP</h1>
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
                <a href="agent.php" class="list-group-item list-group-item-action">Home</a>
                <a href="#" class="list-group-item list-group-item-action">Business Summary</a>
                <a href="agentpolicytransaction.php" class="list-group-item list-group-item-action">Policy Transaction</a>
                <a href="agentmtdpolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy Transaction</a>
                <a href="agententryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                <a href="agentsearch.php" class="list-group-item list-group-item-action">Commission Report</a>
            </div>
            

            
        </div>
        
        <div class="col-sm-8 my-1">
            <div class="row">
            <div class="row">
               <?php
                    $zonequery = "SELECT mapped_zone_id FROM `newemp` WHERE `name`='$_SESSION[username]'";
                    $zoneresult = mysqli_query($con, $zonequery) or die(mysqli_error());
                    $zonerow = mysqli_fetch_array($zoneresult); 
                    if($zonerow > 0){
                        $zoneid = $zonerow['mapped_zone_id'];
                    }
                    $posname = "SELECT password FROM `newemp` where `name`='$_SESSION[username]'";
                    $pospresult = mysqli_query($con, $posname) or die(mysqli_error());
                    $posprow = mysqli_fetch_array($pospresult); 
                    if($posprow > 0){
                        $poscode = $posprow['password'];
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
                            SUM(CASE WHEN product_type = 'Four Wheeler' THEN net_premium ELSE 0 END) as PVT, 
                            SUM(CASE WHEN product_type = 'Two Wheeler' THEN net_premium ELSE 0 END) as Two_Wheeler, 
                            SUM(CASE WHEN product_type = 'Commercial Vehicle' THEN net_premium ELSE 0 END) as Commercial_vehicle, 
                            SUM(CASE WHEN product_type = 'Health' THEN net_premium ELSE 0 END) as Health,
                            SUM(net_premium) AS Total_Premuim
                            FROM 
                            daily_booking 
                            WHERE
                            month_name = '$monthName' AND mapped_zone_id = '$zoneid' AND pos_code = '$poscode'
                            ORDER BY 
                            Total_Premuim DESC;";
                            $sqlresult = $con->query($sqldisplay); //echo $sqldisplay;
                            $disrow = mysqli_num_rows($sqlresult);
                            if($disrow > 0){
                                echo "<table class='table table-hover text-center table-danger bg-gradient bg-opacity-10 shadow-sm m-auto'>";
                                echo "<tr>";
                                
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
</div>
<script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>