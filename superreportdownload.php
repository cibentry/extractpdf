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
    if (isset($_POST['entrymonth'])) {
        $entrymonth = $_POST['entrymonth'];
        $entryyear = $_POST['fy-year'];
        
        
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
    commissionable_premium,
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
    mapped_zone_id,
    file_path,
    sm_remarks
FROM daily_booking 
WHERE month_name = '$entrymonth' AND f_year = '$entryyear'";

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
                'Entry No', 'Entry Date', 'State Name', 'Product Type', 
                'Sub Product', 'Segment', 'RTO Code', 'RTO Location', 'Policy No', 
                'Customer Name', 'Customer Contact Number', 'Policy Sold Date', 
                'Plan Name', 'Business Type', 'NCB', 'Policy Start Date', 
                'Policy End Date', 'Sold By', 'Vehicle Registration No', 
                'Date of Registration', 'Age of the Vehicle', 'Engine Number', 
                'Chassi Number', 'Make', 'Model', 'Fuel Type', 'GVW CC', 
                'Seating Capacity', 'Insurer', 'Total Premium', 'Net Premium', 
                'Commissionable Premium', 'OD Premium', 'TP Premium', 
                'CPA Premium', 'Terrorism Premium', 'Payment Mode', 'Cheque Number', 
                'Payout Required', 'POS Code', 'POS Name', 'Non POS Name', 
                'Location Name', 'SM Name', 'OD Inward', 'TP Inward', 'Net Inward', 
                'OD Outward', 'TP Outward', 'Net Outward', 'Remarks', 
                'LL Premium', 'Month Name', 'Inward Point', 'Outward Point', 
                'Margin', 'Our Entry No', 'F Year', 'Booking Status', 
                'Mapped Zone', 'Mapped Zone ID', 'File Path', 'SM Remarks'
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
