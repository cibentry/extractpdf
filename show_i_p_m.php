<?php
include('db.php');
session_start();

$state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
$policy = isset($_REQUEST['policy']) ? $_REQUEST['policy'] : '';
$str = isset($_REQUEST['str']) ? $_REQUEST['str'] : '';
$vehicle = isset($_REQUEST['vehicle']) ? $_REQUEST['vehicle'] : '';

echo($state);
echo($policy);
echo($str);
echo($vehicle);

if (empty($str)) {
    echo "Error: STR is required";
    exit;
}

$outputsegment = '<option value="ALL" selected>ALL</option>';
$insq = "SELECT distinct Insurance_Co from grid_pcv Where State_name = '$state' AND Policy_Type = '$policy' and Our_Segment = '$vehicle'
";
$resins = mysqli_query($con,$insq);
while($insrow = mysqli_fetch_array($resins)){
    $outputsegment.="<option value='".$insrow['Insurance_Co'] ." '>".$insrow['Insurance_Co']."</option>";   
}
echo $outputsegment;
?>