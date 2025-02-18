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

            <div class="col-sm-12 my-1">

            <form action="reportdownloadzm.php" method="post" enctype="multipart/form-data">
                    <div class="row border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3">
                        <div class="col-sm-2 m-1 p-2 mx-5">
                            <select id="month" name="month" class="form-select" aria-label="Default select example">
                                <option selected>Select Month</option>
                                <?php
                                $query = "SELECT distinct month_name FROM `daily_booking`";
                                $result = mysqli_query($con, $query);
                                while($fetch = mysqli_fetch_array($result)){
                                    echo "<option value='" . $fetch['month_name'] . "'>" . $fetch['month_name'] . "</option>";
                                }   
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 p-2 mx-5">
                            <select id="year" name="year" class="form-select" aria-label="Default select example">
                                <option selected>Select Year</option>
                                <?php
                                $query = "SELECT distinct f_year FROM `daily_booking`";
                                $result = mysqli_query($con, $query);
                                while($fetch = mysqli_fetch_array($result)){
                                    echo "<option value='" . $fetch['f_year'] . "'>" . $fetch['f_year'] . "</option>";
                                }   
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-6 m-1 p-2 mx-5">
                            <div id="result"></div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-1 m-1 p-2 mx-auto">
                    <button type="submit" name="submit" class="btn btn-primary m-4">Download</button>
                        </div>
                    </div>

                    
                </form>
            </div>

        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // Trigger event when either dropdown is changed
    $('#month, #year').on('change', function () {
        var selectedMonth = $('#month').val();
        var selectedYear = $('#year').val();

        // Make sure both month and year are selected
        if (selectedMonth !== "Select Month" && selectedYear !== "Select Year") {
            // AJAX call to fetch the number of records and sum of net premium
            $.ajax({
                url: 'fetch_data2.php',
                type: 'POST',
                data: {
                    month: selectedMonth,
                    year: selectedYear
                },
                success: function (response) {
                    // Parse the JSON response
                    var data = JSON.parse(response);
                    
                    // Format the sum of net premium with separators (commas)
                    var formattedSum = formatNumber(data.sum_net_premium);

                    // Display the result in the div
                    $('#result').html(
                        '<strong>Number of Policies: ' + data.num_records + '<br>' +
                        'Sum of Net Premium: ₹ ' + formattedSum + ' /-' + '</strong>'
                    );
                }
            });
        } else {
            // Clear the result if selections are invalid
            $('#result').html('');
        }
    });

    // Function to format numbers with commas for thousands and lakhs
    function formatNumber(num) {
        // Parse to float to ensure it's a number
        var number = parseFloat(num);
        // Check if number is valid
        if (isNaN(number)) return '0.00'; // Return '0.00' if invalid
        
        // Convert to Indian number format using regex
        return number.toString().replace(/\B(?=(\d{2})+(?!\d))/g, ",").replace(/(\d+)(\d{3})/, "$1,$2");
    }
</script>
</html>