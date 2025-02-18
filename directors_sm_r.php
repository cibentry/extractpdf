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



                    </div>
                </div>
                <div class="col-sm-8 border border-success">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="mapzone" class="form-label">Select Zone</label>
                            <select class="form-select" id="mapzone" aria-label="Default select example" onchange="displayreport()">
                                <option>Select Zone</option>
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT mapped_zone FROM daily_booking ORDER BY mapped_zone asc;") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['mapped_zone'] . "'>" . $fetch['mapped_zone'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row" id='displayresult'>
                       

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
            <script>
                function displayreport() {
                    var mzone = document.getElementById("mapzone").value;

                    //alert(mzone);
                    $.ajax({
                        type: "POST",
                        url: "showreport.php",
                        data: {

                            mzone: mzone
                        },
                        success: function(data) {
                            console.log("Response from server:", data); // Log the response
                            $("#displayresult").html(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                }
            </script>
</body>

</html>