<?php
include('db.php');
session_start();

if (isset($_POST['submit'])) {
    echo "<script>alert('Form submitted');</script>";
    // Collecting and sanitizing input data
    //var_dump($_POST);
    $entrydate = strip_tags($_POST['entrydate']);
    $state = strip_tags($_POST['state']);
    $producttype = strip_tags($_POST['producttype_text']);
    $subproducttype = strip_tags($_POST['subproducttype_text']);
    $segmenttype = strip_tags($_POST['segmenttype_text']);
    $rtocode = strip_tags($_POST['rtocode']);
    $rtolocation = strip_tags($_POST['rtolocation']);
    $policyno = strip_tags($_POST['policyno']);
    $customername = strip_tags($_POST['insuredname']);
    $customerno = strip_tags($_POST['insuredno']);
    $policysolddate = strip_tags($_POST['policyissudate']);
    $plan = strip_tags($_POST['plan']);
    $businesstype = strip_tags($_POST['businesstype']);
    $ncb = strip_tags($_POST['ncb']);
    $rsd = strip_tags($_POST['rsd']);
    $red = strip_tags($_POST['red']);
    $soldby = $_SESSION['username'];
    $vehicleno = strip_tags($_POST['vehicleno']);
    $dateofregistration = strip_tags($_POST['regdate']);
    $age = strip_tags($_POST['age']);
    $engineno = strip_tags($_POST['engineno']);
    $chassisno = strip_tags($_POST['chassisno']);
    $vehiclemake = strip_tags($_POST['vehiclemake']);
    $vehiclemodel = strip_tags($_POST['vehiclemodel']);
    $fueltype = strip_tags($_POST['fueltype']);
    $gvwcc = strip_tags($_POST['gvwcc']);
    $seatingcapacity = strip_tags($_POST['seatingcapacity']);
    $insuranceco = strip_tags($_POST['insuranceco']);
    $totalpremium = strip_tags($_POST['grosspremium']);
    $netpremium = strip_tags($_POST['netpremium']);
    $commissionablepremium = strip_tags($_POST['commissionablepremium']);
    $odpremium = strip_tags($_POST['totalodpremium']);
    $tppremium = strip_tags($_POST['totaltppremium']);
    $cpapremium = strip_tags($_POST['cpapremium']);
    $terrorismpremium = strip_tags($_POST['terrorismpremium']);
    $paymentmode = strip_tags($_POST['paymentmode']);
    $chequeno = strip_tags($_POST['cheque-no']);
    $payoutrequired = strip_tags($_POST['payoutrequired']);
    $poscode = strip_tags($_POST['agentcode']);
    $posname = strip_tags($_POST['Agentname']);
    $nonposname = strip_tags($_POST['nonposname']);
    $location = strip_tags($_POST['poslocation']);
    $smname = $_SESSION['username'];
    $odinward = strip_tags($_POST['odinward']);
    $tpinward = strip_tags($_POST['tpinward']);
    $netinward = strip_tags($_POST['netinward']);
    $odoutward = strip_tags($_POST['odoutward']);
    $tpoutward = strip_tags($_POST['tpoutward']);
    $netoutward = strip_tags($_POST['netoutward']);
    $remarks = ""; // initilization for branch remarks
    $llpremium = strip_tags($_POST['llpremium']);
    $monthname = strip_tags($_POST['monthname']);
    $inwardpoint = strip_tags($_POST['incommission']);
    $outwardpoint = strip_tags($_POST['outcommission']);
    $margin = strip_tags($_POST['margin']);
    $ourentryno = ""; // Initialize
    $financialyear = strip_tags($_POST['fiscalyear']);
    $bookingstatus = "Pending";// Initialize
    $zonename = strip_tags($_POST['zonename']);
    $zoneid = strip_tags($_POST['zoneid']);
    $smremark = strip_tags($_POST['remarks']); // sales remarks

    //file details
    $pdffile = $_FILES['pdf_file'];
    $file_name = $pdffile['name'];
    $file_size = $pdffile['size'];
    $file_tmp = $pdffile['tmp_name'];
    $file_type = $_FILES['pdf_file']['type'];

    if ($file_type !== 'application/pdf') {
        echo 'Only PDF files are allowed!';
        exit;
      }

      // Save the file in the uploads directory
      $upload_dir = 'uploads/';
      $file_path = $upload_dir . $file_name;
      move_uploaded_file($file_tmp, $file_path);

    var_dump($entrydate);

    $insertQuery = "INSERT INTO daily_booking (
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
        sm_remarks) VALUES (
        '$entrydate',
        '$state',
        '$producttype',
        '$subproducttype',
        '$segmenttype',
        '$rtocode',
        '$rtolocation',
        '$policyno',
        '$customername',
        '$customerno',
        '$policysolddate',
        '$plan',
        '$businesstype',
        '$ncb',
        '$rsd',
        '$red',
        '$soldby',
        '$vehicleno',
        '$dateofregistration',
        '$age',
        '$engineno',
        '$chassisno',
        '$vehiclemake',
        '$vehiclemodel',
        '$fueltype',
        '$gvwcc',
        '$seatingcapacity',
        '$insuranceco',
        '$totalpremium',
        '$netpremium',
         $commissionablepremium,
        '$odpremium',
        '$tppremium',
        '$cpapremium',
        '$terrorismpremium',
        '$paymentmode',
        '$chequeno',
        '$payoutrequired',
        '$poscode',
        '$posname',
        '$nonposname',
        '$location',
        '$smname',
        '$odinward',
        '$tpinward',
        '$netinward',
        '$odoutward',
        '$tpoutward',
        '$netoutward',
        '$remarks',
        '$llpremium',
        '$monthname',
        '$inwardpoint',
        '$outwardpoint',
        '$margin',
        '$ourentryno',
        '$financialyear',
         '$bookingstatus',
         '$zonename',
        '$zoneid',
        '$file_path',
        '$smremark')";
    //echo "<script>alert($insertQuery)</script>";// Output the query for debugging
    // Execute the INSERT query
    $result = mysqli_query($con, $insertQuery);

    // Debug: Output the SQL query if it fails
    if (!$result) {
        //  echo "<script>alert('first:'  . mysqli_error($con))</script>";
        echo "Error inserting data: " . mysqli_error($con);
        exit; // Stop execution
    }

    // Get the last inserted entry number
    $entryno = $con->insert_id;
    if ($businesstype == 'Renewal') {
        $entryno_prefix = 'WB-' . $entryno . '-R';
    } else {
        $entryno_prefix = 'WB-' . $entryno . '-N';
    }
    // Update the entry number in the database
    // $update_sql = "UPDATE daily_booking SET our_entry_no = '$entryno' WHERE entry_no = '$entryno'";
    $update_sql = "UPDATE daily_booking SET our_entry_no = '$entryno_prefix' WHERE entry_no = (SELECT MAX(entry_no) FROM daily_booking)";

    $result = mysqli_query($con, $update_sql);
    //echo ($entryno_prefix);
    $_SESSION['last_entry_no'] = $entryno_prefix;

    // Redirect to businessentry.php
    header("Location: rmsbusinessentry.php");
    exit();
}
?>