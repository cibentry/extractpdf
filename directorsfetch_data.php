<?php
// Include the database connection file
include('db.php');
session_start();

// Check if the entrydate, entrymonth, and entryyear variables are set
if (isset($_POST['entrydate']) && isset($_POST['entrymonth']) && isset($_POST['entryyear'])) {
    $entrydate = $_POST['entrydate'];
    $entrymonth = $_POST['entrymonth'];
    $entryyear = $_POST['entryyear'];

    // Check if the session variable is set
    if (isset($_SESSION)) {
        // Check if the username variable is set in the session
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            

            // Query to fetch the data
            $sqldisplay = "SELECT 
            sm_name, 
            SUM(CASE WHEN product_type = 'Four Wheeler' THEN net_premium ELSE 0 END) as PVT, 
            SUM(CASE WHEN product_type = 'Two Wheeler' THEN net_premium ELSE 0 END) as Two_Wheeler, 
            SUM(CASE WHEN product_type = 'Commercial Vehicle' THEN net_premium ELSE 0 END) as Commercial_vehicle, 
            SUM(CASE WHEN product_type = 'Health' THEN net_premium ELSE 0 END) as Health,
            SUM(CASE WHEN product_type = 'Life' THEN net_premium ELSE 0 END) as Life,
            SUM(CASE WHEN product_type = 'Others' THEN net_premium ELSE 0 END) as Others,
            SUM(net_premium) AS Total_Premuim,
            SUM(CASE WHEN entry_date = '$entrydate' THEN net_premium ELSE 0 END) AS ftd,
            SUM(CASE WHEN month_name = '$entrymonth' THEN net_premium ELSE 0 END) AS mtd
            FROM 
            daily_booking 
            WHERE
            month_name = '$entrymonth' and f_year = '$entryyear'
            GROUP BY 
            sm_name 
            ORDER BY 
            Total_Premuim DESC;";


            $sqlresult = $con->query($sqldisplay); //echo $sqldisplay;
            $disrow = mysqli_num_rows($sqlresult);

            if ($disrow > 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($sqlresult)) {
                    $data[] = array(
                        'sm_name' => $row['sm_name'],
                        'PVT' => $row['PVT'],
                        'Two_Wheeler' => $row['Two_Wheeler'],
                        'Commercial_vehicle' => $row['Commercial_vehicle'],
                        'Health' => $row['Health'],
                        'Life' => $row['Life'],
                        'Others' => $row['Others'],
                        'Total_Premuim' => $row['Total_Premuim'],
                        'ftd' => $row['ftd'],
                        'mtd' => $row['mtd']
                    );
                }

                // Output the data as JSON
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                // Output an empty array as JSON
                header('Content-Type: application/json');
                echo json_encode(array());
            }
        } else {
            // Output an error message as JSON
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Username not set in session'));
        }
    } else {
        // Output an error message as JSON
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Session not set'));
    }
} else {
    // Output an error message as JSON
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Entry date, entry month, or entry year not set'));
}
?>