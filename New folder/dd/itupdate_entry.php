<?php
include('db.php');
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //echo "<script>alert('Form submitted');</script>";
    //var_dump($_POST);
    // Collecting and sanitizing input data
    $entry_no = $_POST['entry_no'];
    $entrydate = strip_tags($_POST['entry_date']);
    $state = strip_tags($_POST['statename']);
    $producttype = strip_tags($_POST['producttype']);
    $subproducttype = strip_tags($_POST['subproduct']);
    $segmenttype = strip_tags($_POST['segment']);
    $rtocode = strip_tags($_POST['rtocode']);
    $rtolocation = strip_tags($_POST['rtolocation']);
    $policyno = strip_tags($_POST['policyno']);
    $customername = strip_tags($_POST['customername']);
    $customerno = strip_tags($_POST['customernumber']);
    $policysolddate = strip_tags($_POST['issuedate']);
    $plan = strip_tags($_POST['plan']);
    $businesstype = strip_tags($_POST['businesstype']);
    $ncb = strip_tags($_POST['ncb']);
    $rsd = strip_tags($_POST['rsd']);
    $red = strip_tags($_POST['red']);
    $soldby = strip_tags($_POST['manager']);
    $vehicleno = strip_tags($_POST['vehicleno']);
    $dateofregistration = strip_tags($_POST['registrationdate']);
    $age = strip_tags($_POST['age']);
    $engineno = strip_tags($_POST['engineno']);
    $chassisno = strip_tags($_POST['chassisno']);
    $vehiclemake = strip_tags($_POST['makename']);
    $vehiclemodel = strip_tags($_POST['modelname']);
    $fueltype = strip_tags($_POST['fueltype']);
    $gvwcc = strip_tags($_POST['gvwcc']);
    $seatingcapacity = strip_tags($_POST['seating']);
    $insuranceco = strip_tags($_POST['insurername']);
    $totalpremium = strip_tags($_POST['grosspremium']);
    $netpremium = strip_tags($_POST['netpremium']);
    $commissionablepremium = strip_tags($_POST['commissionablepremium']);
    $odpremium = strip_tags($_POST['totalodpremium']);
    $tppremium = strip_tags($_POST['totaltppremium']);
    $cpapremium = strip_tags($_POST['cpapremium']);
    $terrorismpremium = strip_tags($_POST['terrorismpremium']);
    $paymentmode = strip_tags($_POST['paymentmode']);
    $chequeno = strip_tags($_POST['chequeno']);
    $payoutrequired = strip_tags($_POST['payoutrequired']);
    $poscode = strip_tags($_POST['agentcode']);
    $posname = strip_tags($_POST['agentname']);
    $nonposname = strip_tags($_POST['nonposname']);
    $location = strip_tags($_POST['poslocation']);
    $smname = strip_tags($_POST['manager']);
    $odinward = strip_tags($_POST['odinward']);
    $tpinward = strip_tags($_POST['tpinward']);
    $netinward = strip_tags($_POST['netinward']);
    $odoutward = strip_tags($_POST['odoutward']);
    $tpoutward = strip_tags($_POST['tpoutward']);
    $netoutward = strip_tags($_POST['netoutward']);
    $remarks = strip_tags($_POST['remarks']);
    $llpremium = strip_tags($_POST['llpremium']);
    $monthname = strip_tags($_POST['monthname']);
    $inwardpoint = strip_tags($_POST['incommission']);
    $outwardpoint = strip_tags($_POST['outcommission']);
    $margin = strip_tags($_POST['margin']);
    $fyear = strip_tags($_POST['fyyear']);
    $bookstatus = strip_tags($_POST['bookingstatus']);
    $mappedzone = strip_tags($_POST['mappedzone']);
    $mappedid = strip_tags($_POST['mappedzoneid']);


    $updateQuery = "UPDATE daily_booking SET
            entry_date = '$entrydate', 
            state_name = '$state', 
            product_type = '$producttype', 
            sub_product = '$subproducttype', 
            segment = '$segmenttype', 
            rto_code = '$rtocode', 
            rto_location = '$rtolocation', 
            policy_no = '$policyno', 
            customer_name = '$customername', 
            customer_contact_number = '$customerno', 
            policy_sold_date = '$policysolddate', 
            plan_name = '$plan', 
            business_type = '$businesstype', 
            ncb = '$ncb', 
            policy_start_date = '$rsd', 
            policy_end_date = '$red', 
            sold_by = '$soldby', 
            vehicle_registration_no = '$vehicleno', 
            date_of_registration = '$dateofregistration', 
            age_of_the_vehicle = '$age', 
            engine_number = '$engineno', 
            chassi_number = '$chassisno', 
            make = '$vehiclemake', 
            model = '$vehiclemodel', 
            fuel_type = '$fueltype', 
            gvw_cc = '$gvwcc', 
            seating_capacity = '$seatingcapacity', 
            insurer = '$insuranceco', 
            total_premium = '$totalpremium', 
            net_premium = '$netpremium', 
            commissionable_premium = '$commissionablepremium', 
            od_premium = '$odpremium', 
            tp_premium = '$tppremium', 
            cpa_premium = '$cpapremium', 
            terrorism_premium = '$terrorismpremium', 
            payment_mode = '$paymentmode', 
            cheque_number = '$chequeno', 
            payout_required = '$payoutrequired', 
            pos_code = '$poscode', 
            pos_name = '$posname', 
            non_pos_name = '$nonposname', 
            location_name = '$location', 
            sm_name = '$smname', 
            od_inward = '$odinward', 
            tp_inward = '$tpinward', 
            net_inward = '$netinward', 
            od_outward = '$odoutward', 
            tp_outward = '$tpoutward', 
            net_outward = '$netoutward', 
            remarks = '$remarks', 
            ll_premium = '$llpremium', 
            month_name = '$monthname', 
            inward_point = '$inwardpoint', 
            outward_point = '$outwardpoint', 
            margin = '$margin', 
            f_year = '$fyear',
            booking_status = '$bookstatus',
            mapped_zone = '$mappedzone',
            mapped_zone_id = '$mappedid'
        WHERE entry_no = '$entry_no'";
echo "Update query: $updateQuery\n";
    $result = mysqli_query($con, $updateQuery);

    if (!$result) {
        echo "Error updating data: " . mysqli_error($con) . "\n";
        echo "Query: $updateQuery\n";
        echo "Error code: " . mysqli_errno($con) . "\n";
        exit;
    } else {
        echo "Record updated successfully!\n";
        echo "Affected rows: " . mysqli_affected_rows($con) . "\n";
    }
    $affectedRows = mysqli_affected_rows($con);
    if ($affectedRows > 0) {
        echo "Update successful!";
    }
    echo "Update successful!";
    $_SESSION['message'] = "Update successful!"; // Success message
    $_SESSION['msg_type'] = "success"; // Optional: You can also set a message type
    echo "<script>alert('Updated');</script>";
    header('Location: superuser.php');
    exit();


} else {
    echo "form not submitted";
}
?>
