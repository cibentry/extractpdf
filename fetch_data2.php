<?php
include 'db.php'; // Include your DB connection file

if (isset($_POST['month']) && isset($_POST['year'])) {
    $selectedMonth = $_POST['month'];
    $selectedYear = $_POST['year'];

    // Query to fetch the number of records and sum of net premium
    $query = "SELECT COUNT(*) as num_records, SUM(net_premium) as sum_net_premium 
              FROM `daily_booking` 
              WHERE month_name = '$selectedMonth' AND f_year = '$selectedYear'";
    
    $result = mysqli_query($con, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);

        // Send the result as a JSON response
        echo json_encode([
            'num_records' => $data['num_records'],
            'sum_net_premium' => $data['sum_net_premium'] ? $data['sum_net_premium'] : 0
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
