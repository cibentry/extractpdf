<?php
include('db.php');
session_start();

$state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
$policy = isset($_REQUEST['policy']) ? $_REQUEST['policy'] : '';
$gvw = isset($_REQUEST['gvw']) ? $_REQUEST['gvw'] : '';


echo($state);
echo($policy);
echo($gvw);

if (empty($gvw)) {
    echo "Error: GVW is required";
    exit;
}

$outputsegment = '<option value="ALL" selected>ALL</option>';
$insq = "SELECT distinct Insurance_Co from grid_gcv Where State_name = '$state' AND Policy_Type = '$policy' 
AND (Lower_GVW <= $gvw AND Upper_GVW >= $gvw)";
$resins = mysqli_query($con,$insq);
while($insrow = mysqli_fetch_array($resins)){
    $outputsegment.="<option value='".$insrow['Insurance_Co'] ." '>".$insrow['Insurance_Co']."</option>";   
}
echo $outputsegment;
?>