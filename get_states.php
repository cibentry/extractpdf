<?php
include('db.php');
session_start();

$product = isset($_POST['product']) ? $_POST['product'] : '';

if($product == '1') { // GCV
    $query = "SELECT DISTINCT state_name FROM gcv_dec ORDER BY state_name ASC";
} else if($product == '2') { // MISC-D
    $query = "SELECT DISTINCT state_name FROM miscd_dec ORDER BY state_name ASC";
} else {
    echo "<option value=''>Select State</option>";
    exit;
}

$result = mysqli_query($con, $query);
if($result) {
    echo "<option value=''>Select State</option>";
    while($row = mysqli_fetch_array($result)) {
        echo "<option value='" . $row['state_name'] . "'>" . $row['state_name'] . "</option>";
    }
} else {
    echo "<option value=''>Error loading states</option>";
}
?>
