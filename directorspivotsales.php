<?php
include('db.php');
session_start();

// Get the year range from the AJAX request
$yearRange = $_POST['year'];

// Get the current month and day from the AJAX request
$currentMonth = $_POST['month'];
$currentDay = $_POST['day'];
// Query to fetch sales data
$query = "
    SELECT 
        f_year,
        month_name,
        entry_date,
        SUM(CASE WHEN booking_status = 'pending' THEN net_premium ELSE 0 END) AS pending_net_premium,
        SUM(CASE WHEN booking_status = 'booked' THEN net_premium ELSE 0 END) AS booked_net_premium
    FROM 
        daily_booking
    WHERE 
        f_year BETWEEN " . explode('-', $yearRange)[0] . " AND " . explode('-', $yearRange)[1] . "
    GROUP BY 
        f_year, month_name, entry_date
";

$result = $con->query($query);

// Initialize arrays to store sales data
$ytdSales = array();
$mtdSales = array();
$ftdSales = array();
$pendingNetPremium = array();

// Loop through the result set
while ($row = $result->fetch_assoc()) {
    $fYear = $row['f_year'];
    $monthName = $row['month_name'];
    $entryDate = $row['entry_date'];
    $pendingNetPremium[$fYear . '-' . $monthName] = $row['pending_net_premium'];
    $ytdSales[$fYear . '-' . $monthName] = $row['booked_net_premium'];
    $mtdSales[$fYear . '-' . $monthName] = $row['booked_net_premium'];
    $ftdSales[$fYear . '-' . $monthName] = $row['booked_net_premium'];
}

// Calculate the sum of net premium for pending bookings
$sumPendingNetPremium = array_sum($pendingNetPremium);

// Create a JSON response
$response = array(
    'ytd_sales' => $ytdSales,
    'mtd_sales' => $mtdSales,
    'ftd_sales' => $ftdSales,
    'pending_net_premium' => $sumPendingNetPremium
);

/ Generate the table HTML
$tableHtml = '<table border="1">';
$tableHtml .= '<tr><th>Year-Month</th><th>YTD Sales</th><th>MTD Sales</th><th>FTD Sales</th><th>Pending Net Premium</th></tr>';

foreach ($ytdSales as $yearMonth => $ytdSale) {
    $mtdSale = $mtdSales[$yearMonth];
    $ftdSale = $ftdSales[$yearMonth];
    $pendingNetPremium = $pendingNetPremium[$yearMonth];
    $tableHtml .= '<tr>';
    $tableHtml .= '<td>' . $yearMonth . '</td>';
    $tableHtml .= '<td>' . $ytdSale . '</td>';
    $tableHtml .= '<td>' . $mtdSale . '</td>';
    $tableHtml .= '<td>' . $ftdSale . '</td>';
    $tableHtml .= '<td>' . $pendingNetPremium . '</td>';
    $tableHtml .= '</tr>';
}

$tableHtml .= '</table>';

// Echo out the table HTML
echo $tableHtml;

// Close the database connection
$con->close();


?>