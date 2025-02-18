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
                                    $mtdquery = mysqli_query($con, $noquery);
                                    if ($mtdquery) {
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_number = $row['total_commission'] ?? 0;
                                        echo ("Total Number of Policies Inwarded: " . $total_number);

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
                                $mtdquery = mysqli_query($con, $noquery);
                                if ($mtdquery) {
                                    $row = mysqli_fetch_assoc($mtdquery);
                                    $total_number = $row['total_commission'] ?? 0;
                                    echo ("Total Premium Inwarded: " . $total_number);

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
                    <div class="col-sm-8 my-1">
                        <div class="row">
                            <form action="rmrep.php" method="POST">
                                <div class="row">
                                    <div class="col-sm-4 my-1">
                                        <label for="byear" class="col-sm-2 col-form-label">Year</label>
                                        <select id="byear" name="byear" class="form-select">
                                            <?php
                                            $yearq = "SELECT DISTINCT f_year FROM daily_booking";
                                            $result = mysqli_query($con, $yearq);
                                            while ($fetch = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $fetch['f_year'] . "'>" . $fetch['f_year'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 my-1">


                                        <label for="bmonth" class="col-sm-2 col-form-label">Month</label>
                                        <select id="bmonth" name="bmonth" class="form-select">
                                        <option selected>Select Month</option>
                                            <?php
                                            $monthq = "SELECT DISTINCT month_name FROM `daily_booking`";
                                            
                                            $result = mysqli_query($con, $monthq);
                                            while ($fetch = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $fetch['month_name'] . "'>" . $fetch['month_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="displaytable">

                                </div>
                            </form>
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
        $('#bmonth').on('change', function () {
            var selectedMonth = $(this).val();
            var selectedyear = $('#byear').val();
            if (selectedMonth !== "Select Month") {
            // AJAX call to fetch the number of records and sum of net premium
            $.ajax({
                url: 'rmrep.php',
                type: 'POST',
                data: { entrymonth: selectedMonth,
                        entryyear : selectedyear
                 },
                success: function(response) {
                    // Parse the JSON response
                    var data = JSON.parse(response);

                    // Display the result in the div
        }
    </script>

</body>

</html>