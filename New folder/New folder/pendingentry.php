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

if (isset($_SESSION['last_entry_no'])) {
    // Output the last entry number
    echo "<script>alert('Updation Completed Successfully for Entry Number: " . $_SESSION['last_entry_no'] . "');</script>";
    unset($_SESSION['last_entry_no']); // Clear the session variable after use
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
    <button class="btn btn-primary mx-4 my-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
        aria-controls="offcanvasWithBothOptions">Menu</button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <div class=" border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                <h4 class="report bg-primary m-1 p-1 text-light">Operations</h4>
                <div class="list-group m-3">
                    <a href="operations.php" class="list-group-item list-group-item-action active">Home</a>
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
        </div>
    </div>
    <div class="container-fluid m-auto mx-1 ">

        <div class="row">
            

            <div class="col-sm-12 my-1 mx-2 ">
                <div class="row">
                    <?php
                    $showdata = "SELECT entry_date,our_entry_no, sm_name,customer_name, vehicle_registration_no, chassi_number, commissionable_premium FROM daily_booking
                                WHERE booking_status = 'pending'";
                    $result = $con->query($showdata);
                    $disrow = mysqli_num_rows($result);
                    //echo(mysqli_num_rows($showdata));
                    if ($disrow > 0) {
                        // Start the table and headers
                        echo "<table class='table table-hover text-center'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo '<th>Entry Date</th>';
                        echo '<th>Entry No</th>';
                        echo '<th>SM Name</th>';
                        echo '<th>Customer Name</th>';
                        echo '<th>Vehicle Registration No</th>';
                        echo '<th>Chassis Number</th>';
                        echo '<th>Commissionable Premium</th>';
                        echo '<th>Actions</th>';  // New Actions column for Edit and Delete buttons
                        echo '</tr>';
                        echo "</thead>";
                        echo "<tbody>";

                        // Fetch and display each row of data
                        while ($fetchdata = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($fetchdata['entry_date']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['our_entry_no']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['sm_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['customer_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['vehicle_registration_no']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['chassi_number']) . '</td>';
                            echo '<td>' . htmlspecialchars($fetchdata['commissionable_premium']) . '</td>';
                            // Edit and Delete buttons
                            echo '<td>';
                            echo '<a href="edit_entry.php?id=' . htmlspecialchars($fetchdata['our_entry_no']) . '" class="btn btn-sm btn-primary">Edit</a>'; // Edit button
                            echo '<a href="delete_entry.php?id=' . 'id="deleteentry"' . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this entry?\');">Delete</a>'; // Delete button with confirmation
                            echo '</td>';

                            echo '</tr>';
                        }

                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        // If no pending entries found
                        echo '<p>No pending entries found.</p>';
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