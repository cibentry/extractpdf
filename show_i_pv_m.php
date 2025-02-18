<?php
include('db.php');
session_start();

$state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
$policy = isset($_REQUEST['policy']) ? $_REQUEST['policy'] : '';
$fuel = isset($_REQUEST['fuel']) ? $_REQUEST['fuel'] : '';


var_dump($_REQUEST);

if (empty($fuel)) {
    echo "Error: CC is required";
    exit;
}

$outputsegment = '<option value="ALL" selected>ALL</option>';


   $insq = "SELECT distinct Insurance_Co FROM grid_pvt 
            WHERE State_name = '$state' AND (Fuel = '$fueltype' OR Fuel = 'NA')
            ";

echo $insq;
echo "Query: " . $insq . "<br>";


$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment .= "<option value='" . trim($insrow['Insurance_Co']) . "'>" . trim($insrow['Insurance_Co']) . "</option>";
    }
} else {
    $outputsegment .= "<option value='' disabled>No results found</option>";
}

echo $outputsegment;
?>
