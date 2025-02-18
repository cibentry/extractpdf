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
                    <a href="pendingfranchaise.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">Dashboard</a>
                </div>
            </div>

            <div class="col-sm-12 my-1">
                <form action="franchaisereportdownload.php" method="post" enctype="multipart/form-data">
                    <div class="row border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3">
                        <div class="col-sm-2 m-1 p-2 mx-5">
                            <select id="fy-year" name="fy-year" class="form-select" aria-label="Default select example">
                                <option selected>Select FY</option>
                                <?php
                                $query = "SELECT distinct f_year FROM `franchaise_booking`";
                                $result = mysqli_query($con, $query);
                                while ($fetch = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $fetch['f_year'] . "'>" . $fetch['f_year'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 p-2 mx-5">
                            <select id="entrymonth" name="entrymonth" class="form-select"
                                aria-label="Default select example">
                                <option selected>Select month</option>

                            </select>
                        </div>
                        
                    </div>


                    <div class="row">
                        <div class="col-sm-1 m-1 p-2 mx-auto">
                            <button type="submit" name="submit" class="btn btn-primary m-4">Download</button>
                        </div>
                    </div>


                </form>
                <div class="col-sm-10 m-1 p-2 mx-5">
                    <div id="heading" class="text-center text-primary fw-bolder fs-4">

                    </div>
                    <div id="result">

                    </div>
                    <div id="footer" class="text-center text-primary fw-bolder fs-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#fy-year, #entrymonth, #entrydate').on('change', function () {
            var fyYear = $('#fy-year').val();
            var entryMonth = $('#entrymonth').val();
            var entryDate = $('#entrydate').val();
            var headingText = 'Financial Year: ' + fyYear + ', Month: ' + entryMonth + ', Date: ' + entryDate;
            $('#heading').html(headingText);
        });
    });
</script>
<script>
    $('#entrymonth').on('change', function () {
        var selectedmonth = $(this).val();
        
        var selectedyear = $('#fy-year').val();

        alert(selectedDate);
        alert(selectedmonth);
        alert(selectedyear);

        // Make sure a valid date is selected
        if (selectedDate !== "Select Date") {
            // AJAX call to fetch the number of records and sum of net premium
            $.ajax({
                url: 'franchaise_fetch_data.php',
                type: 'POST',
                data: {
                    
                    entrymonth: selectedmonth,
                    entryyear: selectedyear
                },
                success: function (response) {
                    console.log('Response:', response); // Log the response to the console
                    if (response.length > 0) { // Check if the response is not empty
                        var tableHtml = '<table class="table table-hover text-center table-danger bg-gradient bg-opacity-10 shadow-sm m-auto">';
                        tableHtml += '<tr>';
                        tableHtml += '<th>SM Name</th>';
                        tableHtml += '<th>PVT</th>';
                        tableHtml += '<th>Two Wheeler</th>';
                        tableHtml += '<th>Commercial Vehicle</th>';
                        tableHtml += '<th>Health</th>';
                        tableHtml += '<th>Life</th>';
                        tableHtml += '<th>Others</th>';
                        tableHtml += '<th>F-T-D</th>';
                        tableHtml += '<th>M-T-D</th>';
                        tableHtml += '</tr>';



                        $.each(response, function (index, data) {
                            tableHtml += '<tr>';
                            tableHtml += '<td>' + data.sm_name + '</td>';
                            tableHtml += '<td>' + data.PVT + '</td>';
                            tableHtml += '<td>' + data.Two_Wheeler + '</td>';
                            tableHtml += '<td>' + data.Commercial_vehicle + '</td>';
                            tableHtml += '<td>' + data.Health + '</td>';
                            tableHtml += '<td>' + (data.Life !== undefined ? data.Life : 0) + '</td>';
                            tableHtml += '<td>' + (data.Others !== undefined ? data.Others : 0) + '</td>';

                            tableHtml += '<td style="font-weight: bold;">' + (data.ftd !== undefined ? data.ftd : '0.00') + '</td>';
                            tableHtml += '<td style="font-weight: bold;">' + (data.mtd !== undefined ? data.mtd : '0.00') + '</td>';
                            tableHtml += '</tr>';
                        });
                        tableHtml += '</table>';


                        // Display the table in the #result div
                        console.log(tableHtml);
                        $('#result').html(tableHtml);
                    } else {
                        // Handle the case when the response is empty
                        $('#result').html('No data available');
                    }
                }, // Add this closing bracket

                error: function (xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    });
</script>
<script>
    $('#fy-year').on('change', function () {
        var selectedFY = $(this).val();

        // Send a request to fetch_entry_dates.php to get the entry dates for the selected FY
        $.ajax({
            url: 'franchaise_fetch_entry_month.php',
            type: 'POST',
            data: { fy_year: selectedFY },
            success: function (response) {
                // Parse the JSON response
                var entrymonth = JSON.parse(response);

                // Clear the entrydate select box
                $('#entrymonth').empty();

                // Add the entry dates to the entrydate select box
                $.each(entrymonth, function (index, value) {
                    $('#entrymonth').append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });
    });
</script>
<script>
    $('#entrymonth').on('change', function () {
        var selectedMonth = $(this).val();
        var selectedYear = $('#fy-year').val();

        // Send a request to fetch_entry_dates.php to get the entry dates for the selected month
        $.ajax({
            url: 'franchaise_fetch_entry_date.php',
            type: 'POST',
            data: {
                entrymonth: selectedMonth,
                entryyear: selectedYear
            },
            success: function (response) {
                // Parse the JSON response
                var entrydate = JSON.parse(response);

                // Clear the entrydate select box
                $('#entrydate').empty();

                // Add the entry dates to the entrydate select box
                $.each(entrydate, function (index, value) {
                    $('#entrydate').append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });
    });
</script>
<script>
    $('#entrydate').on('change', function () {
        var selectedDate = $(this).val();
        var selectedMonth = $('#entrymonth').val();
        var selectedYear = $('#fy-year').val();

        // Make sure a valid date is selected
        if (selectedDate !== "Select Date") {
            // AJAX call to fetch the sum of commissionable_premium
            $.ajax({
                url: 'franchaise_fetch_ftd.php',
                type: 'POST',
                data: {
                    entrydate: selectedDate,
                    entrymonth: selectedMonth,
                    entryyear: selectedYear
                },
                success: function (response) {
                    console.log('Response:', response); // Log the response to the console
                    var data = JSON.parse(response);
                    var ftd = data.ftd;
                    var mtd = data.mtd;

                    // Check if ftd and mtd are not undefined
                    if (typeof ftd !== 'undefined' && typeof mtd !== 'undefined') {
                        // Display the FTD and MTD values in the #footer div
                        $('#footer').html('FTD: ' + ftd + ', MTD: ' + mtd);
                    } else {
                        // Handle the case when ftd and mtd are undefined
                        $('#footer').html('No data available');
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        }
    });
</script>

</html>