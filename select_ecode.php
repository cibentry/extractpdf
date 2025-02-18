<?php
include('db.php');
session_start();

$mz = $_POST['mz'];

$outputsegment = "";


$insq = "SELECT e_code FROM employee_master WHERE name = '$mz'";

$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment =trim($insrow['e_code']);
        
    }
} else {
    $outputsegment ="no result found";
    
}


echo $outputsegment;



?>