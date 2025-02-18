<?php
include('db.php');
$manager=$_POST['manager'];
//var_dump($manager);
$sqlmanager = "select * from agent_table where RM_Name = '".$manager."' order by Username asc";
$resultmanager = mysqli_query($con,$sqlmanager);

$agentoutput = '<option>Select Agent Name</option>';

while($datamanager = mysqli_fetch_array($resultmanager))
{
    $agentoutput.="<option value='".$datamanager['Username']."'>".$datamanager['Username']."</option>";

    //echo $agentoutput;
    
}

echo $agentoutput;
//echo $agentcode;

//echo "<script>console.log('Selected Manager: " . $manager . "');</script>";


?>