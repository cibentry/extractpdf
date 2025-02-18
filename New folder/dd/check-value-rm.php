<?php
include('db.php');

// Get the values from the AJAX request
$vehicleNo = $_POST['vehicleNo'];
$engineNo = $_POST['engineNo'];
$chassisNo = $_POST['chassisNo'];
$policyNo = $_POST['policyNo'];

// Check if any of the values already exist in the database
$query = "SELECT * FROM daily_booking WHERE vehicle_registration_no = '$vehicleNo' OR engine_number = '$engineNo' OR chassi_number = '$chassisNo' OR policy_no = '$policyNo'";
$result = mysqli_query($con, $query);

// Check if any rows were found
if (mysqli_num_rows($result) > 0) {
    // Get the entry no and RSD from the database
    $row = mysqli_fetch_assoc($result);
    $entryNo = $row['entry_no'];
    $rsd = $row['policy_start_date'];
  
    // Send a JSON response back to the client
    echo json_encode(array('exists' => true, 'entryNo' => $entryNo, 'rsd' => $rsd));
  } else {
    // Send a JSON response back to the client
    echo json_encode(array('exists' => false));
  }
  
  // Close the database connection
  mysqli_close($con);
  ?>