<?php
header('Content-Type: application/json');

include("db.php");

// Make sure to remove any HTML output from the script
// and make sure the db.php file is not sending any HTML output

$entrydate = $_POST['entrydate'];
$entrymonth = $_POST['entrymonth'];
$entryyear = $_POST['entryyear'];

$sqldisplay = "SELECT 
    SUM(CASE WHEN entry_date = '$entrydate' THEN commissionable_premium ELSE 0 END) AS ftd,
    SUM(CASE WHEN month_name = '$entrymonth' AND entry_year = '$entryyear' THEN commissionable_premium ELSE 0 END) AS mtd
    FROM daily-booking
    WHERE entry_year = '$entryyear'";

$result = mysqli_query($conn, $sqldisplay);
$row = mysqli_fetch_assoc($result);

$ftd = $row['ftd'];
$mtd = $row['mtd'];

$response = array(
    'ftd' => $ftd,
    'mtd' => $mtd
);

echo json_encode($response);

// Make sure to exit the script after sending the JSON response
exit;
?>