<?php
include('db.php');
session_start();

$desg = $_POST['desg'];

$outputsegment = '<option value="" selected>Select</option>';
$insq = "SELECT distinct functionality FROM functionality_master WHERE designation = '$desg'";

$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    while ($insrow = mysqli_fetch_array($resins)) {
        $outputsegment .= "<option value='" . trim($insrow['functionality']) . "'>" . trim($insrow['functionality']) . "</option>";
    }
} else {
    $outputsegment .= "<option value='' disabled>No results found</option>";
}

echo $outputsegment;

?>