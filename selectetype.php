<?php
include('db.php');
$rmname=$_POST['rmname'];
//var_dump($manager);
$sqlmanager = "select * from employee_master where name = '".$rmname."' order by name asc";
$resultmanager = mysqli_query($con,$sqlmanager);

$agentoutput = '';

while($datamanager = mysqli_fetch_array($resultmanager))
{
    $agentoutput = $datamanager['employee_type'];

    //echo $agentoutput;
    
}

echo $agentoutput;
//echo $agentcode;

//echo "<script>console.log('Selected Manager: " . $manager . "');</script>";


?>