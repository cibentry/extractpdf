<?php

include('db.php');
session_start();
$rm_name = $_POST['rmname'];

$sqlrmnumber = "SELECT contact_no FROM rm_list WHERE RM_Name = '$rm_name'";
$resultnumnber = mysqli_query($con, $sqlrmnumber);

$rmno = '';
while($datanumber = mysqli_fetch_array($resultnumnber)){
    $rmno = $datanumber['contact_no'];
    // echo $rmno;
}
echo($rmno);



?>