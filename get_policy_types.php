<?php
include('db.php');
session_start();

$product = isset($_POST['product']) ? $_POST['product'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';

if(empty($product) || empty($state)) {
    echo "<option value=''>Select Policy Type</option>";
    exit;
}

if($product == '1') { // GCV
    $query = "SELECT DISTINCT Policy_type FROM gcv_dec WHERE state_name = '$state' ORDER BY Policy_type ASC";
} else if($product == '2') { // MISC-D
    $query = "SELECT DISTINCT Policy_type FROM miscd_dec WHERE state_name = '$state' ORDER BY Policy_type ASC";
}

$result = mysqli_query($con, $query);
if($result) {
    echo "<option value=''>Select Policy Type</option>";
    while($row = mysqli_fetch_array($result)) {
        echo "<option value='" . $row['Policy_type'] . "'>" . $row['Policy_type'] . "</option>";
    }
} else {
    echo "<option value=''>Error loading policy types</option>";
}
?>
