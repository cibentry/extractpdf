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
        $managername = $_SESSION['username'];
        $entrymonthlabel = $_POST['entrymonth'];
        $entryfyearlabel = $_POST['fy-year'];
        // SQL query to fetch data based on the entry date
        
        //$queryzcode = mysqli_query($con, "SELECT * FROM `newemp` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
        //$fetchcode = mysqli_fetch_array($queryzcode);

        //$mid = $fetchcode['mapped_zone_id'];
       

        $query = "SELECT 
                    entry_date,
                    entry_no,
                    location_name,
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
                    sm_name,
                    franchaise_od_inward,
                    franchaise_tp_inward,
                    franchaise_net_inward,
                    franchaise_od_outward,
                    franchaise_tp_outward,
                    franchaise_net_outward,
                    remarks,
                    od_inward,
                    tp_inward,
                    net_inward,
                    franchaise_inward_point, 
                    franchaise_outward_point,
                    franchaise_margin,
                    margin,
                    f_year,
                    month_name,
                    booking_status,
                    sm_remarks
                    FROM franchaise_booking WHERE  month_name='$entrymonthlabel' AND f_year='$entryfyearlabel'";
        $result = mysqli_query($con, $query);
        
        if (!$result) {
            die("Query Failed: " . mysqli_error($con));  // Display SQL error if the query fails
            echo("err");
        }else {
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
                'Entry Date', 'Entry No','State','Product Type', 'Sub Product', 'Segment',
                'RTO Code','RTO Location','Policy No','Customer Name','Customer Contact Number',
                'Policy Sold Date','Plan', 'Business Type','NCB','Policy Start Date', 'Policy End Date',
                'Sold By','Vehicle Registration No','Date of Registration',
                'Age of the Vehicle','Engine Number', 'Chassi Number', 'Make', 'Model', 'Fuel Type',
                'GVW/CC','Seating Capacity', 'Insurer', 'Total Premium', 'Net Premium','Commissionable Premium', 
                'OD Premium','TP Premium', 'CPA Premium','Terrorism Premium', 'Payment Mode', 'Cheque Number',
                'Payout Required', 'POS Code', 'POS Name', 'Non POS Name', 'Location Name', 'SM Name',
                'Franchaise OD Inward', 'Franchaise TP Inward', 'Franchaise Net Inward', 
                'Franchaise OD Outward', 'Franchaise TP Outward', 'Franchaise Net Outward','Remarks',
                'OD Inward','TP Inward','Net Inward','Franchaise Incommission','Franchaise Outcommission',
                'Franchaise Margin','Our Margin','FY-Year','Month','Booking Status','SM Remarks'                                   
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
