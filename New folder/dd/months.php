<?php
include('db.php');
session_start();
$username = $_SESSION['username'];

$zonequery = "SELECT mapped_zone_id FROM `newemp` WHERE `name`='$username'";
$zoneresult = mysqli_query($con, $zonequery) or die(mysqli_error());
$zonerow = mysqli_fetch_array($zoneresult);
if ($zonerow > 0) {
    $zoneid = $zonerow['mapped_zone_id'];
}

$query = "SELECT DISTINCT (month_name) FROM daily_booking WHERE mapped_zone_id = '$zoneid'";
$result = mysqli_query($con, $query) or die(mysqli_error());

$months = array();
while ($row = mysqli_fetch_array($result)) {
    $months[] = $row['month_name'];
}

echo json_encode($months);
?>