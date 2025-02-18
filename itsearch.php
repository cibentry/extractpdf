<?php
include('db.php');
$etryno = $_POST['entryNo'];

$sql = "SELECT * FROM daily_booking WHERE entry_no = '$etryno'";
$result = mysqli_query($con , $sql);
if ($result) {
    // Fetch the data
    $data = mysqli_fetch_assoc($result);
    // Convert the data to a JSON object
    $json_data = json_encode($data);
    // Send the JSON object back to the client
    echo $json_data;
  } else {
    // Handle the error
    echo "Error: " . mysqli_error($conn);
  }
?>
