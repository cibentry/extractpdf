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
    if (isset($_POST['entrydate'])) {
        $entryDateLabel = $_POST['entrydate'];
        $user = $_SESSION['username'];
        $queryzcode = mysqli_query($con, "SELECT 	* FROM `newemp` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
        $fetchcode = mysqli_fetch_array($queryzcode);
        // Format the fiscal year as "YYYY-YY"
        $mid = $fetchcode['mapped_zone_id'];
        // SQL query to fetch data based on the entry date
        $query = "SELECT 
                    entry_no,
                    entry_date, 
                    state_name, 
                    product_type, 
                    sub_product,
                    segment, 
                    rto_code, 
                    rto_location,
                    policy_no, 
                    customer_name, 
                    customer_contact_number, 
                    policy_sold_date, 
                    plan_name, 
                    business_type, 
                    ncb, 
                    policy_start_date,
                    policy_end_date, 
                    sold_by, 
                    vehicle_registration_no, 
                    date_of_registration, 
                    age_of_the_vehicle, 
                    engine_number,
                    chassi_number, 
                    make, 
                    model, 
                    fuel_type, 
                    gvw_cc, 
                    seating_capacity, 
                    insurer, 
                    total_premium, 
                    net_premium, 
                    od_premium,
                    tp_premium, 
                    cpa_premium, 
                    terrorism_premium, 
                    payment_mode, 
                    cheque_number, 
                    payout_required, 
                    pos_code, 
                    pos_name,
                    non_pos_name, 
                    location_name, 
                    sm_name, 
                    od_inward, 
                    tp_inward, 
                    net_inward, 
                    od_outward, 
                    tp_outward, 
                    net_outward,
                    remarks,
                    ll_premium,
                    month_name,
                    inward_point,
                    outward_point,
                    margin,
                    our_entry_no,
                    f_year,
                    booking_status,
                    mapped_zone,
                    mapped_zone_id 
                    FROM daily_booking WHERE entry_date = '$entryDateLabel'";
        $result = mysqli_query($con, $query);

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
                'Entry No',
                'Entry Date',
                'State Name',
                'Product Type',
                'Sub Product',
                'Segment',
                'RTO Code',
                'RTO Location',
                'Policy No',
                'Customer Name',
                'Customer Contact Number',
                'Policy Sold Date',
                'Plan Name',
                'Business Type',
                'NCB',
                'Policy Start Date',
                'Policy End Date',
                'Sold By',
                'Vehicle Registration No',
                'Date of Registration',
                'Age of the Vehicle',
                'Engine Number',
                'Chassi Number',
                'Make',
                'Model',
                'Fuel Type',
                'GVW CC',
                'Seating Capacity',
                'Insurer',
                'Total Premium',
                'Net Premium',
                'OD Premium',
                'TP Premium',
                'CPA Premium',
                'Terrorism Premium',
                'Payment Mode',
                'Cheque Number',
                'Payout Required',
                'POS Code',
                'POS Name',
                'Non POS Name',
                'Location Name',
                'SM Name',
                'OD Inward',
                'TP Inward',
                'Net Inward',
                'OD Outward',
                'TP Outward',
                'Net Outward',
                'Remarks',
                'LL Premium',
                'Month Name',
                'Inward Point',
                'Outward Point',
                'Margin',
                'Our Entry No',
                'Financial Year',
                'Booking Status',
                'Mapped Zone',
                'Mapped Zone ID'
            ];

            // Write the headers to the CSV file
            fputcsv($output, $headers);

            // Write the fetched data into the CSV file
            while ($row = mysqli_fetch_assoc($result)) {
                if (isset($row['policy_no'])) {
                    $row['policy_no'] = "'" . $row['policy_no']; // Prefix with single quote
                }
                if (isset($row['od_inward']) && isset($row['od_outward']) && isset($row['tp_inward']) && isset($row['tp_outward']) && isset($row['net_inward']) && isset($row['net_outward'])) {
                    $row['od_inward'] = sprintf("%.2f%%", $row['od_inward']);
                    $row['od_outward'] = sprintf("%.2f%%", $row['od_outward']);
                    $row['tp_inward'] = sprintf("%.2f%%", $row['tp_inward']);
                    $row['tp_outward'] = sprintf("%.2f%%", $row['tp_outward']);
                    $row['net_inward'] = sprintf("%.2f%%", $row['net_inward']);
                    $row['net_outward'] = sprintf("%.2f%%", $row['net_outward']);
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