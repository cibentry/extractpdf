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
                    <a href="rms.php" class="list-group-item list-group-item-action">Home</a>
                    <a href="#" class="list-group-item list-group-item-action">Business Summary</a>
                    <a href="rmspolicytransaction.php" class="list-group-item list-group-item-action">Policy
                        Transaction</a>
                        <a href="mtdrmspolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy
                        Transaction</a> 
                    <a href="#" class="list-group-item list-group-item-action">Entry Report</a>
                    <a href="rmsbusinessentry.php" class="list-group-item list-group-item-action">Business Entry</a>
                    <a href="rmssearch.php" class="list-group-item list-group-item-action">Search</a>
                </div>
                
            </div>

            <div class="col-sm-8 my-1">
            <div class="row">
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
                        

                        
                        $sqldisplay = "SELECT 
                    db.pos_name, 
                    SUM(CASE WHEN db.product_type = 'Four Wheeler' THEN db.net_premium ELSE 0 END) as PVT, 
                    SUM(CASE WHEN db.product_type = 'Two Wheeler' THEN db.net_premium ELSE 0 END) as Two_Wheeler, 
                    SUM(CASE WHEN db.product_type = 'Commercial Vehicle' THEN db.net_premium ELSE 0 END) as Commercial_vehicle, 
                    SUM(CASE WHEN db.product_type = 'Health' THEN db.net_premium ELSE 0 END) as Health,
                    SUM(db.net_premium) AS Total_Premuim
                    FROM 
                    daily_booking db
                    WHERE
                    db.sm_name = '" . $_SESSION['username'] . "' AND month_name = '" . $monthName . "' AND f_year = '" . $fiscalYear . "'
                    GROUP BY 
                    db.pos_name
                    ORDER BY 
                    Total_Premuim DESC;";
                        $sqlresult = $con->query($sqldisplay); //echo $sqldisplay;
                        $disrow = mysqli_num_rows($sqlresult);
                        if ($disrow > 0) {
                            echo "<table class='table table-hover text-center'>";
                            echo "<tr>";
                            echo "<th>POS Name</th>";
                            echo "<th>PVT</th>";
                            echo "<th>Two Wheeler</th>";
                            echo "<th>Commercial Vehicle</th>";
                            echo "<th>Health</th>";
                            echo "<th>Total Premium</th>";
                            echo "</tr>";
                            $totals = array('PVT' => 0, 'Two_Wheeler' => 0, 'Commercial_vehicle' => 0, 'Health' => 0, 'Total_Premuim' => 0);

                            while ($row = mysqli_fetch_assoc($sqlresult)) {
                                echo "<tr>
                                <td>" . htmlspecialchars($row['pos_name']) . "</td>
                                <td>" . htmlspecialchars($row['PVT']) . "</td>
                                <td>" . htmlspecialchars($row['Two_Wheeler']) . "</td>
                                <td>" . htmlspecialchars($row['Commercial_vehicle']) . "</td>
                                <td>" . htmlspecialchars($row['Health']) . "</td>
                                <td>" . htmlspecialchars($row['Total_Premuim']) . "</td>
                                </tr>";
                                $totals['PVT'] += $row['PVT'];
                                $totals['Two_Wheeler'] += $row['Two_Wheeler'];
                                $totals['Commercial_vehicle'] += $row['Commercial_vehicle'];
                                $totals['Health'] += $row['Health'];
                                $totals['Total_Premuim'] += $row['Total_Premuim'];

                            }
                            echo "<tr class='table-primary'>";
                            echo "<td><strong>Totals</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($totals['PVT']) . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($totals['Two_Wheeler']) . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($totals['Commercial_vehicle']) . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($totals['Health']) . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($totals['Total_Premuim']) . "</strong></td>";
                            echo "</tr>";
                            echo "</table>";

                        } else {
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