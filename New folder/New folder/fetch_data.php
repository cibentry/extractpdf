<?php
// Connect to your database
include 'db.php'; // Include your DB connection file

if (isset($_POST['entrydate'])) {
    $entrydate = $_POST['entrydate'];

    // Query to fetch the number of records and sum of net premium
    $query = "SELECT COUNT(*) as num_records, SUM(net_premium) as sum_net_premium 
              FROM `daily_booking` 
              WHERE entry_date = '$entrydate'";
              
    $result = mysqli_query($con, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);

        // Send the result as a JSON response
        echo json_encode([
            'num_records' => $data['num_records'],
            'sum_net_premium' => $data['sum_net_premium']
        ]);
    } else {
        // Handle the error
        echo json_encode([
            'num_records' => 0,
            'sum_net_premium' => 0
        ]);
    }
}
?>
