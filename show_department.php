<?php
include('db.php');
session_start();

$funct = $_POST['funct'];

$outputsegment = '<option value="" selected>Select</option>';
$insq = "SELECT distinct department FROM functionality_master WHERE functionality = '$funct'";

$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment .= "<option value='" . trim($insrow['department']) . "'>" . trim($insrow['department']) . "</option>";
    }
} else {
    $outputsegment .= "<option value='' disabled>No results found</option>";
}

echo $outputsegment;

?>