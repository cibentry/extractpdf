<?php
include('db.php');
session_start();

$mz = $_POST['mz'];

$outputsegment = '<option value="" selected>Select</option>';


$insq = "SELECT reporting_name FROM reporting_master WHERE mapped_zone = '$mz'";

$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment .= "<option value='" . $insrow['reporting_name'] . "'>" . $insrow['reporting_name'] . "</option>";;
        
    }
} else {
    $outputsegment .= "<option value='' disabled>No results found</option>";
    
}


echo $outputsegment;



?>