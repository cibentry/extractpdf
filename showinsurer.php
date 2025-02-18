<?php
include('db.php');
session_start();

$state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
$policy = isset($_REQUEST['policy']) ? $_REQUEST['policy'] : '';
$gvw = isset($_REQUEST['gvw']) ? $_REQUEST['gvw'] : '';
$vehicletype = isset($_REQUEST['vehicletype']) ? $_REQUEST['vehicletype'] : '';

var_dump($_REQUEST);

if (empty($gvw)) {
    echo "Error: GVW is required";
    exit;
}

$outputsegment = '<option value="ALL" selected>ALL</option>';

if ($vehicletype == 'GCV 3W') {
    $insq = "SELECT distinct Insurance_Co FROM grid_gcv WHERE LOWER(State_name) = LOWER('$state') AND LOWER(Policy_Type) = LOWER('$policy') AND Vehicle_type = 'GCV 3W'";
} else {
    $insq = "SELECT distinct Insurance_Co FROM grid_gcv WHERE LOWER(State_name) = LOWER('$state') AND LOWER(Policy_Type) = LOWER('$policy') 
    AND (Lower_GVW <= $gvw AND Upper_GVW >= $gvw)";
}

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
