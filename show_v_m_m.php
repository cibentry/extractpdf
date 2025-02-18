<?php

include('db.php');
session_start();

$state = isset($_POST['state']) ? $_POST['state'] : '';
echo $state;



$outputvehicle = '<option value="ALL" selected>ALL</option>';
$vehq = "SELECT DISTINCT Vehicle_type FROM grid_miscd WHERE State_name = '$state' ORDER BY Vehicle_type ASC";

echo "Query: $vehq<br>";

$reveh = mysqli_query($con,$vehq);
if (!$reveh) {
    echo "Error: " . mysqli_error($con);
    exit;
}
$count = mysqli_num_rows($reveh);
echo "Number of rows found: " . $count;
while($vesrow = mysqli_fetch_array($reveh)){
    $outputvehicle.="<option value='".$vesrow['Vehicle_type'] ."'>".$vesrow['Vehicle_type']."</option>";   
}
echo $outputvehicle;
?>


