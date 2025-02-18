<?php
include 'db.php';

if (isset($_POST['fy_year'])) {
    $fy_year = $_POST['fy_year'];

    $query = "SELECT distinct month_name FROM `daily_booking` WHERE f_year = '$fy_year'";
    $result = mysqli_query($con, $query);

    $entry_dates = array();
    while ($fetch = mysqli_fetch_array($result)) {
        $entry_month[] = $fetch['month_name'];
    }

    echo json_encode($entry_month);
}
?>