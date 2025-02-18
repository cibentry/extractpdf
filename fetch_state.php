<?php
include('db.php');
session_start();
$district = $_POST['district'];
$query = mysqli_query($con, "SELECT State_Name FROM `district_codes` WHERE District_Name = '$district'") or die(mysqli_error());
while ($fetch = mysqli_fetch_array($query)) {
  echo "<option value='" . $fetch['State_Name'] . "'>" . $fetch['State_Name'] . "</option>";
}

?>