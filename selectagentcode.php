<?php

include('db.php');
session_start();
$agent = $_POST['agent'];
$manager = $_SESSION['username'];
$sqlagent = "select posp_id, username, rm_name, organisation_role, e_code from posp_master where username = '".$agent."' AND rm_name = '".$manager."';";
$resultagent = mysqli_query($con,$sqlagent);

$posid = "";
$uname = "";
$rmn = "";
$orgrole = "";
$npos = "";
$ecode = "";

while($dataagent = mysqli_fetch_array($resultagent)){
      
    $rmn = $dataagent['rm_name'];
    $uname = $dataagent['username'];
    $posid = $dataagent['posp_id'];
    $orgrole = $dataagent['organisation_role'];
    $ecode = $dataagent['e_code'];
    
    if($orgrole === "Non POSP"){
        $npos = $dataagent['username'];
    }
    
    
    // Check if $uname equals "Cut-Pay" and set it to an empty string if true
    
    
}

$response = array('posid' => $posid, 'uname' => $uname, 'rmn' => $rmn , 'orgrole' => $orgrole, 'npos' => $npos, 'ecod' =>$ecode);
echo json_encode($response);
?>