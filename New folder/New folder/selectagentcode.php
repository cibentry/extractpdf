<?php

include('db.php');
session_start();
$agent = $_POST['agent'];
$manager = $_SESSION['username'];
$sqlagent = "select POSP_ID, Username, RM_Name, Organisation_Role from agent_table where Username = '".$agent."' AND RM_name = '".$manager."';";
$resultagent = mysqli_query($con,$sqlagent);

$posid = "";
$uname = "";
$rmn = "";
$orgrole = "";
$npos = "";

while($dataagent = mysqli_fetch_array($resultagent)){
      
    $rmn = $dataagent['RM_Name'];
    $uname = $dataagent['Username'];
    $posid = $dataagent['POSP_ID'];
    $orgrole = $dataagent['Organisation_Role'];
    
    if($orgrole === "NON POSP"){
        $npos = $dataagent['Username'];
    }
    
    // Check if $uname equals "Cut-Pay" and set it to an empty string if true
    
    
}

$response = array('posid' => $posid, 'uname' => $uname, 'rmn' => $rmn , 'orgrole' => $orgrole, 'npos' => $npos);
echo json_encode($response);
?>