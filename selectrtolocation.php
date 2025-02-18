<?php
include('db.php');
$rtocode = $_POST['rtocode'];

$sqlrtolocation = "select * from rtolocation where RegNo = '".$rtocode."'";
$resultrtolocation = mysqli_query($con,$sqlrtolocation);

$outputrtolocation = '';
$resultrow = mysqli_num_rows($resultrtolocation);

if($resultrow > 0){
    $datartolocation = mysqli_fetch_array($resultrtolocation);
    $outputrtolocation = $datartolocation['Place'];
}

echo $outputrtolocation;
    
?>