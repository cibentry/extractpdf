<?php
include('db.php');
session_start();

// Ensure no output before this line
header('Content-Type: text/plain');
ob_clean(); // Clear output buffer

$e_code = trim($_POST['e_code']); // Trim to remove unwanted spaces

$insq = "SELECT * FROM posp_master WHERE posp_id = '$e_code'";
$resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));

if (mysqli_num_rows($resins) > 0) {
    $insrow = mysqli_fetch_array($resins);
    echo "exists," . trim($insrow['posp_id']) . "," . trim($insrow['username']);
} else {
    echo "not_exists";
}

exit; // Ensure no further output
?>
