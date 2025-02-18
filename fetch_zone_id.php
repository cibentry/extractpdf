<?php
include('db.php');
session_start();
$zone = $_POST['zone'];
$query = mysqli_query($con, "SELECT zonal_id FROM `zone_list` WHERE state_name = '$zone'") or die(mysqli_error());
while ($fetch = mysqli_fetch_array($query)) {
  $zone_id = $fetch['zonal_id'];
  
  echo $zone_id;
}
?>