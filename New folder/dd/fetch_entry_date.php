<?php
include 'db.php';

if (isset($_POST['entrymonth'])) {
    $entrymonth = $_POST['entrymonth'];
    $entryyear =  $_POST['entryyear'];

    $query = "SELECT distinct entry_date FROM `daily_booking` WHERE month_name = '$entrymonth' AND f_year = '$entryyear'";


    
    $result = mysqli_query($con, $query);

    $entry_dates = array();
    while ($fetch = mysqli_fetch_array($result)) {
        $entry_date[] = $fetch['entry_date'];
    }

    echo json_encode($entry_date);
}
?>