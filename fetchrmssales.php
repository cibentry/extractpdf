<?php
include('db.php');
session_start();
$month = $_POST['month'];
$name = $_SESSION['username'];

$sqlmonth = "select sum(net_premium) as net_premium FROM daily_booking where month_name = '$month' AND sm_name = '$name'";
$querymonth = mysqli_query($con,$sqlmonth);
while($datamonth = mysqli_fetch_array($querymonth)){
    echo sprintf("₹ %0.2f", $datamonth['net_premium']);
}

?>