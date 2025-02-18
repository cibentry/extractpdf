<?php
include('db.php');
session_start();

$state = $_POST['state'];
$policy = $_POST['policy'];
$miscd = $_POST['miscd'];

echo($state);
echo($policy);
echo($miscd);

if (empty($miscd)) {
    echo "Error: Miscd is required";
    exit;
}

$outputsegment = '<option value="ALL" selected>ALL</option>';
$insq = "SELECT distinct Insurance_Co from grid_miscd Where State_name = '$state' AND Policy_Type = '$policy' AND Vehicle_type = '$miscd'";

echo "Query: " . $insq;  // Print the actual query
var_dump($state, $policy, $miscd);  // Print the variables

$resins = mysqli_query($con,$insq);
if (!$resins) {
    echo "Error: " . mysqli_error($con);
    exit;
}
$count = mysqli_num_rows($resins);
echo "Number of rows found: " . $count;
while($insrow = mysqli_fetch_array($resins)){
    $outputsegment.="<option value='".$insrow['Insurance_Co'] ."'>".$insrow['Insurance_Co']."</option>";   
}
echo $outputsegment;
?>