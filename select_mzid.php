<?php
include('db.php');
session_start();

$mz = $_POST['mz'];

$outputsegment = "";


$insq = "SELECT zonal_id FROM zone_master WHERE state_name = '$mz'";

$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment =trim($insrow['zonal_id']);
        
    }
} else {
    $outputsegment ="no result found";
    
}


echo $outputsegment;



?>