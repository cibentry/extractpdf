<?php
include('db.php');
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];

// Initialize sales amounts
$ftd_sales = 0;
$mtd_sales = 0;
$ytd_sales = 0;

// FTD: Fetch sales for the current day
$ftd_query = "SELECT SUM(net_premium) AS ftd_sales FROM daily_booking WHERE entry_date = '$day'";
$ftd_result = $conn->query($ftd_query);
if ($ftd_result) {
    $ftd_sales = $ftd_result->fetch_assoc()['ftd_sales'];
}

// MTD: Fetch sales from the start of the current month
$mtd_query = "SELECT SUM(net_premium) AS mtd_sales FROM sales WHERE YEAR(sales_date) = '$year' AND MONTH(sales_date) = '$month'";
$mtd_result = $conn->query($mtd_query);
if ($mtd_result) {
    $mtd_sales = $mtd_result->fetch_assoc()['mtd_sales'];
}

// YTD: Fetch sales from the start of the current year
$ytd_query = "SELECT SUM(net_premium) AS ytd_sales FROM sales WHERE YEAR(sales_date) = '$year'";
$ytd_result = $conn->query($ytd_query);
if ($ytd_result) {
    $ytd_sales = $ytd_result->fetch_assoc()['ytd_sales'];
}

// Return the sales data as a JSON object
echo json_encode([
    'ftd_sales' => $ftd_sales ?: 0,  // If no sales, default to 0
    'mtd_sales' => $mtd_sales ?: 0,
    'ytd_sales' => $ytd_sales ?: 0
]);
?>