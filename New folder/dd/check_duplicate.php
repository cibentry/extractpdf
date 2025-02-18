<?php
include('db.php');
$vehicleno = $_POST['vehicleno'];
$sql = "SELECT vehicle_registration_no FROM daily_booking WHERE vehicle_registration_no = '$vehicleno'";
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query) > 0) {
  echo "exists";
} else {
  echo "does not exist";
}
?>