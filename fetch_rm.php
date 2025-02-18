<?php
include('db.php');
session_start();
$mappedzone = $_POST['mappedzone'];

  $query2 = mysqli_query($con, "SELECT name FROM `employee_master` WHERE mapped_zone = '$mappedzone'") or die(mysqli_error());
  while ($fetch2 = mysqli_fetch_array($query2)) {
    echo "<option value='" . $fetch2['name'] . "'>" . $fetch2['name'] . "</option>";
  }

?>