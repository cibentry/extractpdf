<?php
// Assuming $con is your database connection
include('db.php');
$state = $_POST['state'];
    $querystate = "SELECT id FROM zone_list WHERE state_name = '$state'";
    $result = mysqli_query($con,$querystate);

    $output='';
    while($zid = mysqli_fetch_array($result)) 
    {
        $output = $zid['id'];
    }
    

echo($output);

    
?>
