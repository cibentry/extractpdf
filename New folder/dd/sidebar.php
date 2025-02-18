<div class="cont my-1 ">
    <div class="row">
        <div class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
            <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
            <div class="list-group m-3">
                <a href="#" class="list-group-item list-group-item-action">Home</a>
                <a href="businessreport.php" class="list-group-item list-group-item-action">Business Summary</a>
                <a href="policytransaction.php" class="list-group-item list-group-item-action">Policy Transaction</a>
                <a href="mtdpolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy Transaction</a>
                <a href="entryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                <a href="headsearch.php" class="list-group-item list-group-item-action">Search</a>
            </div>
            <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
            <div class="list-group m-3">
                <a href="mtdbookingreport.php" class="list-group-item list-group-item-action">MTD Booking Report</a>
                <a href="zmrevenue.php" class="list-group-item list-group-item-action">Revenue</a>
                <a href="#" class="list-group-item list-group-item-action">MTD POSP Report</a>
                

            </div>
        </div>
        <div class="col-sm-3 my-1">
                            
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">YTD Sales (Year-to-Date)</div>
                <div class="card-body">
                    <h5 class="card-title" id="ytd_sales"></h5>
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
                        $mtd = "SELECT SUM(commissionable_premium) AS total_commission
                                               FROM daily_booking WHERE f_year = '$fiscalYear'";
                                    $mtdquery = mysqli_query($con,$mtd) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_commission = $row['total_commission'] ?? 0;
                                        echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                    }         
                    ?>
                </div>
            
            </div>
        </div>
        <div class="col-sm-2 my-1">
            
                
            <div class="card text-white bg-success mb-3">
                <div class="card-header">MTD Sales (Month-to-Date)</div>
                <div class="card-body">
                    <h5 class="card-title" id="mtd_sales"></h5>
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
                        $mtd = "SELECT SUM(commissionable_premium) AS total_commission
                                               FROM daily_booking WHERE f_year = '$fiscalYear' AND month_name = '$monthName'";
                                    $mtdquery = mysqli_query($con,$mtd) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_commission = $row['total_commission'] ?? 0;
                                        echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                    }
                    ?>
                </div>
            
            </div>
        </div>
        <div class="col-sm-2 my-1">
            
                
            <div class="card text-white bg-info mb-3">
                <div class="card-header">FTD Sales (Today)</div>
                <div class="card-body">
                    <h5 class="card-title" id="ftd_sales"></h5>
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
                        $mtd = "SELECT SUM(commissionable_premium) AS total_commission
                                               FROM daily_booking WHERE entry_date = '$currentDate'";
                                    $mtdquery = mysqli_query($con,$mtd) ;
                                    if($mtdquery){
                                        $row = mysqli_fetch_assoc($mtdquery);
                                        $total_commission = $row['total_commission'] ?? 0;
                                        echo "<h5>&#8377; " . number_format($total_commission, 2) . "</h5>";
                                    }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // Get the current date
    var date = new Date();

    // Get the current year, month, and day
    var currentYear = date.getFullYear();       // e.g., 2024
    var currentMonth = date.getMonth() + 1;     // e.g., 10 (getMonth() is zero-indexed, so +1 for October)
    var currentDay  = new date().getDate();           // e.g., 3

    // Send AJAX request with year, month, and day to PHP
    $.ajax({
        type: "POST",
        url: "fetchsales.php", // Update with the actual PHP file
        data: {
            year: currentYear,
            month: currentMonth,
            day: currentDay
        },
        success: function (response) {
            // Parse the JSON response
            var salesData = JSON.parse(response);

            // Update the HTML elements with the sales data
            $('#ytd_sales').text('$' + salesData.ytd_sales);
            $('#mtd_sales').text('$' + salesData.mtd_sales);
            $('#ftd_sales').text('$' + salesData.ftd_sales);
        },
        error: function () {
            console.log('Error fetching sales data');
        }
    });
</script>
