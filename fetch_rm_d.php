<?php
include('db.php');
session_start();
$rm_name = $_POST['rm_name'];
$query = mysqli_query($con, "SELECT phone,  e_code FROM `employee_master` WHERE name = '$rm_name'") or die(mysqli_error());
while ($fetch = mysqli_fetch_array($query)) {
  $ecode = $fetch['e_code'];
  $contact_no = $fetch['phone'];
  echo json_encode(array(
    'ecode' => $ecode,
    'contact_no' => $contact_no
  ));
}
?>