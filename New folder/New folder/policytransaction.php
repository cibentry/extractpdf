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
            <div class="cont my-1">
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="dash.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">Dashboard</a>
                </div>
            </div>

            <div class="col-sm-12 m-2">
                <div class="row">
                    <div class="row">
                        <?php
                        $limit = 20; // number of records to display per page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; // current page number
                        $offset = ($page - 1) * $limit; // calculate offset for query
                        

                        $policyquery = "SELECT entry_no, entry_date, month_name,sm_name, customer_name, vehicle_registration_no, segment, policy_start_date, policy_end_date, total_premium, net_premium FROM `daily_booking` LIMIT $offset, $limit";
                        $result = mysqli_query($con, $policyquery);

                        $total_records = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `daily_booking`"));
                        $records_shown = mysqli_num_rows($result);
                        echo "<p>Showing $records_shown records out of $total_records records</p>";


                        $num = mysqli_num_rows($result);
                        if ($num > 0) {
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

                            // pagination links
                            $total_records = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `daily_booking`"));
                            $records_shown = mysqli_num_rows($result);

                            echo "<p>Showing $records_shown records out of $total_records records</p>";

                            $total_pages = ceil($total_records / $limit);

                            echo "<nav aria-label='Page navigation'>";
                            echo "<ul class='pagination justify-content-center'>";

                            // Previous button
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>Previous</a></li>";
                            }

                            // Calculate page range
                            $start = max(1, $page - 2);
                            $end = min($total_pages, $page + 2);

                            if ($end - $start < 5) {
                                $start = max(1, $end - 4);
                            }

                            for ($i = $start; $i <= $end; $i++) {
                                if ($i == $page) {
                                    echo "<li class='page-item active'><a class='page-link' href='?page=$i'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                                }
                            }

                            // Next button
                            if ($page < $total_pages) {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
                            }

                            // Display total number of pages
                            echo "<li class='page-item'><span class='page-link'>Showing page $page out of $total_pages pages</span></li>";

                            echo "</ul>";
                            echo "</nav>";
                        } else {
                            echo "No Records Found";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        function selectagent() {
            var manager = $("#manager").val();

            $.ajax({
                url: "selectagent.php",
                type: "POST",
                data: {
                    manager: manager
                },
                success: function (data) {
                    $("#agent").html(data);

                }
            });
        }

    </script>
</body>

</html>