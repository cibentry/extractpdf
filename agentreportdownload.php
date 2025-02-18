<?php
// Include the database connection
include('db.php');
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Start output buffering to avoid any unwanted output before the file is sent
ob_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['month'])) {
        $managername = $_SESSION['username'];
        $entrymonthlabel = $_POST['month'];
        $entryfyearlabel = $_POST['fyear'];
        // SQL query to fetch data based on the entry date

        $posname = "SELECT password FROM `newemp` where `name`='$_SESSION[username]'";
        $pospresult = mysqli_query($con, $posname) or die(mysqli_error());
        $posprow = mysqli_fetch_array($pospresult);
        if ($posprow > 0) {
            $poscode = $posprow['password'];
        }
echo $poscode;
        $query = "SELECT 
                    entry_date,
                    entry_no,
                    customer_name,
                    vehicle_registration_no,
                    rto_code,
                    product_type, 
                    sub_product,
                    segment,
                    plan_name, 
                    insurer,
                    policy_no,
                    policy_start_date,
                    policy_end_date,
                    engine_number,
                    chassi_number, 
                    make, 
                    model,
                    total_premium, 
                    net_premium,
                    commissionable_premium,
                    payment_mode,
                    pos_code, 
                    pos_name,
                    non_pos_name,
                    sm_name,
                    od_outward, 
                    tp_outward, 
                    net_outward,
                    outward_point,
                    booking_status,
                    month_name,
                    f_year,                   
                    sm_remarks 
                    FROM daily_booking WHERE pos_code='$poscode' AND month_name='$entrymonthlabel' AND f_year='$entryfyearlabel'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("Query Failed: " . mysqli_error($con));  // Display SQL error if the query fails
        } else {
            //echo "Rows found: " . mysqli_num_rows($result);  // Display the number of rows found
        }

        //echo($entrymonthlabel);
        //echo($entryfyearlabel);
        if (mysqli_num_rows($result) > 0) {

            // Set headers to indicate a file download
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="Report.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');

            // Open output stream for writing
            $output = fopen('php://output', 'w');

            // Set the CSV headers
            $headers = [
                'Entry Date',
                'Entry No',
                'Customer Name',
                'Vehicle No',
                'RTO Code',
                'Product Type',
                'Sub Product',
                'Segment',
                'Plan',
                'Insurance Co',
                'Policy No',
                'Policy Start Date',
                'Policy End Date',
                'Engine Number',
                'Chassi Number',
                'Make',
                'Model',
                'Total Premium',
                'Net Premium',
                'Commissionable Premium',
                'Payment Mode',
                'POS Code',
                'POS Name',
                'Non POS Name',
                'SM Name',
                'OD Outward',
                'TP Outward',
                'Net Outward',
                'Commission Before TDS',
                'Status',
                'Business Month',
                'Business Year',
                'Remarks'


            ];

            // Write the headers to the CSV file
            fputcsv($output, $headers);

            // Write the fetched data into the CSV file
            while ($row = mysqli_fetch_assoc($result)) {
                if (isset($row['policy_no'])) {
                    $row['policy_no'] = "'" . $row['policy_no']; // Prefix with single quote
                }
                fputcsv($output, $row); // Write each row of the fetched data
            }

            // Close the output stream
            fclose($output);
            exit(); // Exit the script after the download
        } else {
            echo "No data found for the selected entry date.";
        }
    }
} else {
    // This else block can catch if the form wasn't submitted
    echo "Form not submitted.";
}

// End output buffering (this will send output if any exists)
ob_end_flush();
?>