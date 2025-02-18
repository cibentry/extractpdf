<?php
include('db.php');
$rtocode=$_POST['rtocode'];
//var_dump($manager);
$sqlmanager = "select * from rto_master where RTO_CODE = '".$rtocode."'";
$resultmanager = mysqli_query($con,$sqlmanager);

$agentoutput = '';

while($datamanager = mysqli_fetch_array($resultmanager))
{
    $agentoutput = $datamanager['RTO_LOCATION'];

    //echo $agentoutput;
    
}

echo $agentoutput;
//echo $agentcode;

//echo "<script>console.log('Selected Manager: " . $manager . "');</script>";


?>