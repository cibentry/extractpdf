<?php
include('db.php');
session_start();

$state = $_POST['state'];
//$vehicle = $_POST['vehicle'];
$policy = $_POST['policy'];
$gvw = $_POST['gvw'];

$outputinsurer = '<option value="ALL">ALL</option>';

// Correct SQL query
$insurerc = "SELECT distinct Insurance_Co FROM dec_grid WHERE state_name ='". $state ."' AND Policy_Type='". $policy ."' AND Lower_GVW >='". $gvw ."' AND Upper_GVW <='". $gvw ."' ORDER BY Insurance_Co ASC";

$result = mysqli_query($con, $insurerc);

// Check if query succeeded
if ($result) {
    $insuranceCompanies = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $insuranceCompanies[] = $row['Insurance_Co'];
    }

    foreach ($insuranceCompanies as $insuranceCompany) {
        $outputinsurer .= '<option value="'.$insuranceCompany.'">'.$insuranceCompany.'</option>';
    }
} else {
    // Debugging SQL errors
    $outputinsurer .= "<option value=''>Error in query: " . mysqli_error($con) . "</option>";
}

echo $outputinsurer;
?>