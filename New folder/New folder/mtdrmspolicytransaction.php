<?php
// Include the database connection and start the session
include('db.php');
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
                    <h1 class="head text-light">MANAGEMENT</h1>
                    <?php
                    // Fetch the user information from the session and database
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
            <div class="cont my-1">
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="rms.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">Dashboard</a>
                </div>
            </div>

            <div class="col-sm-12 m-2">
                <div class="row">
                    <div class="row">
                        <h3>MTD Policy Transaction Report</h3>
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


                        $limit = 20; // Number of records to display per page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
                        $offset = ($page - 1) * $limit; // Calculate offset for query
                        
                        // Fetch records only for the logged-in user (filter by sm_name, assuming it's the same as session username)
                        $policyquery = "SELECT entry_no, entry_date, month_name, sm_name, customer_name, vehicle_registration_no, segment, policy_start_date, policy_end_date, total_premium, net_premium 
                                        FROM `daily_booking` 
                                        WHERE `sm_name` = '$_SESSION[username]'
                                        AND `month_name` = '$monthName' and f_year = '$fiscalYear' and booking_status = 'booked'
                                        LIMIT $offset, $limit";
                        
                        $result = mysqli_query($con, $policyquery);

                        $total_records_query = "SELECT COUNT(*) as total FROM `daily_booking` WHERE `sm_name` = '$_SESSION[username]' AND `month_name` = '$monthName' and f_year = '$fiscalYear' and booking_status = 'booked'";
                        $total_records_result = mysqli_query($con, $total_records_query);
                        $total_records_row = mysqli_fetch_assoc($total_records_result);
                        $total_records = $total_records_row['total']; // Total records for pagination
                        
                        $records_shown = mysqli_num_rows($result); // Records shown in the current result set 
                        echo "<p>Showing $records_shown records out of $total_records records</p>";

                        if ($records_shown > 0) {
                            echo "<table class='table table-hover text-center'>";
                            echo "<tr>";
                            echo "<th>Entry No</th>";
                            echo "<th>Entry Date</th>";
                            echo "<th>Month</th>";
                            echo "<th>SM Name</th>";
                            echo "<th>Customer Name</th>";
                            echo "<th>Vehicle Registration No</th>";
                            echo "<th>Segment</th>";
                            echo "<th>Policy Start Date</th>";
                            echo "<th>Policy End Date</th>";
                            echo "<th>Total Premium</th>";
                            echo "<th>Net Premium</th>";
                            echo "</tr>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['entry_no']) . "</td>
                                        <td>" . htmlspecialchars($row['entry_date']) . "</td>
                                        <td>" . htmlspecialchars($row['month_name']) . "</td>
                                        <td>" . htmlspecialchars($row['sm_name']) . "</td>
                                        <td>" . htmlspecialchars($row['customer_name']) . "</td>
                                        <td>" . htmlspecialchars($row['vehicle_registration_no']) . "</td>
                                        <td>" . htmlspecialchars($row['segment']) . "</td>
                                        <td>" . htmlspecialchars($row['policy_start_date']) . "</td>
                                        <td>" . htmlspecialchars($row['policy_end_date']) . "</td>
                                        <td>" . htmlspecialchars($row['total_premium']) . "</td>
                                        <td>" . htmlspecialchars($row['net_premium']) . "</td>
                                    </tr>";
                            }

                            echo "</table>";

                            // Pagination
                            $total_pages = ceil($total_records / $limit); // Total pages

                            echo "<nav aria-label='Page navigation'>";
                            echo "<ul class='pagination justify-content-center'>";
                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i == $page) {
                                    echo "<li class='page-item active'><a class='page-link' href='?page=$i'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                                }
                            }
                            echo "</ul>";
                            echo "</nav>";
                        } else {
                            echo "No Records Found";
                        }
                        ?>
                    </div>
                    <form method="POST" action="rmsreportdownload.php">
                        <div class="row mx-5">
                            <div class="col-sm-4">
                                <label for="month"class="form-control">Month</label>
                                <select id="month" name="month" class="form-select">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>   
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="fyear" class="form-control">Financial Year</label>
                                <select id="fyear" name="fyear" class="form-select">
                                    <option value="">Select Financial Year</option>
                                    <option value="2022-23">2022-2023</option>
                                    <option value="2023-24">2023-2024</option>
                                    <option value="2024-25">2024-2025</option>

                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" name="submit" value="Download" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
