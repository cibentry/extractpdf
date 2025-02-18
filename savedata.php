<?php
include('db.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['submit'])) {
    echo "<script>alert('Form submitted but data not saved');</script>";

    // File upload directory
    $upload_dir = 'uploads/';

    // Function to handle file uploads
    function uploadFile($file_input, $upload_dir) {
        if (isset($_FILES[$file_input]) && $_FILES[$file_input]['size'] > 0) { // Check if file is uploaded
            $file = $_FILES[$file_input];
            $file_name = time() . '_' . basename($file['name']); // Unique file name
            $file_path = $upload_dir . $file_name;

            if ($file['type'] !== 'application/pdf') {
                echo '<script>alert("Only PDF files are allowed!");</script>';
                exit;
            }

            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                return $file_path; // Return file path if uploaded successfully
            } else {
                echo '<script>alert("Error uploading file.");</script>';
                exit;
            }
        }
        return null; // Return null if no file uploaded
    }

    // **Handle File Uploads**
    $policy_file_path = uploadFile('pdf_file', $upload_dir); // Mandatory file
    $cheque_file_path = uploadFile('cheque_file', $upload_dir); // Optional
    $school_file_path = uploadFile('school_file', $upload_dir); // Optional

    // **Ensure at least one file is uploaded (Mandatory)**
    if (!$policy_file_path) {
        echo '<script>alert("Policy file is required!"); window.history.back();</script>';
        exit;
    }
    
    // Collecting and sanitizing input data
    $entrydate = strip_tags($_POST['entrydate']);
    $state = strip_tags($_POST['poslocation']);
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
    $soldby = strip_tags($_POST['manager']);
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
    $commissionablepremium = 0;
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
    $smname = strip_tags($_POST['manager']);
    $ecode = strip_tags($_POST['e_code']);
    $odinward = strip_tags($_POST['odinward']);
    $tpinward = strip_tags($_POST['tpinward']);
    $netinward = strip_tags($_POST['netinward']);
    $odoutward = strip_tags($_POST['odoutward']);
    $tpoutward = strip_tags($_POST['tpoutward']);
    $netoutward = strip_tags($_POST['netoutward']);
    $remarks = ""; // Initialization for branch remarks
    $llpremium = "";
    $monthname = strip_tags($_POST['monthname']);
    $inwardpoint = strip_tags($_POST['incommission']);
    $outwardpoint = strip_tags($_POST['outcommission']);
    $margin = strip_tags($_POST['margin']);
    $ourentryno="0";
    $financialyear = strip_tags($_POST['fiscalyear']);
    $bookingstatus = "Booked"; // Initialization
    $zonename = strip_tags($_POST['zonename']);
    $zoneid = strip_tags($_POST['zoneid']);
    $etype = strip_tags($_POST['e_type']); 

    $smremark = strip_tags($_POST['remarks']); // Sales remarks
    $po_status = "Pending"; // initialization
    $po_amount = "0"; // initialization
    $po_date =" "; // initialization
    $utr_no = " "; // initialization
    $discrepancy_remarks = " "; // initialization

     // Check if school_file_path is set; if not, set it to an empty string
     $school_file_path = isset($school_file_path) ? $school_file_path : '';

     // Check if cheque_file_path is set; if not, set it to an empty string
     $cheque_file_path = isset($cheque_file_path) ? $cheque_file_path : '';
 

    
    // Prepared statement to insert data
    $stmt = $con->prepare("INSERT INTO daily_booking (
        entry_date, state_name, product_type, sub_product, segment, rto_code, rto_location, 
        policy_no, customer_name, customer_contact_number, policy_sold_date, plan_name, 
        business_type, ncb, policy_start_date, policy_end_date, sold_by, vehicle_registration_no, 
        date_of_registration, age_of_the_vehicle, engine_number, chassi_number, make, model, 
        fuel_type, gvw_cc, seating_capacity, insurer, total_premium, net_premium, 
        commissionable_premium, od_premium, tp_premium, cpa_premium, terrorism_premium, 
        payment_mode, cheque_number, payout_required, pos_code, pos_name, non_pos_name, 
        location_name, sm_name,e_code, od_inward, tp_inward, net_inward, od_outward, tp_outward, 
        net_outward, remarks, ll_premium, month_name, inward_point, outward_point, margin, 
        our_entry_no, f_year, booking_status, mapped_zone, mapped_zone_id,employee_type, file_path, 
        sm_remarks, po_status, po_amount, po_date, utr_no, discrepancy_remarks, school_path, cheque_path
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)");

    $stmt->bind_param(
        'sssssssssssssissssssssssssssdddddddsssssssssddddddsdsdddssssissssssssss',
        $entrydate, $state, $producttype, $subproducttype, $segmenttype, $rtocode, $rtolocation, 
        $policyno, $customername, $customerno, $policysolddate, $plan, $businesstype, $ncb, 
        $rsd, $red, $soldby, $vehicleno, $dateofregistration, $age, $engineno, $chassisno, 
        $vehiclemake, $vehiclemodel, $fueltype, $gvwcc, $seatingcapacity, $insuranceco, 
        $totalpremium, $netpremium, $commissionablepremium, $odpremium, $tppremium, 
        $cpapremium, $terrorismpremium, $paymentmode, $chequeno, $payoutrequired, $poscode, 
        $posname, $nonposname, $location, $smname,$ecode, $odinward, $tpinward, $netinward, $odoutward, 
        $tpoutward, $netoutward, $remarks, $llpremium, $monthname, $inwardpoint, $outwardpoint, 
        $margin, $ourentryno, $financialyear, $bookingstatus, $zonename, $zoneid,$etype, $policy_file_path, 
        $smremark, $po_status, $po_amount, $po_date, $utr_no, $discrepancy_remarks, $school_file_path, $cheque_file_path
    );

    if ($stmt->execute()) {
        // Get the last inserted entry number
    $entryno = $con->insert_id;
    


    $_SESSION['last_entry_no'] = $entryno;

    // Update out_entry_no with the same entry_no
    $updateSql = "UPDATE daily_booking SET our_entry_no = ? WHERE entry_no = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param("si", $entryno, $entryno); // Both values are the same
    $stmt->execute();
    // Redirect to businessentry.php
    // Fetch form data


    $emailid = "Select * from posp_master where posp_id = '$poscode'";
    $emailquery = mysqli_query($con, $emailid);
    $emailfetch = mysqli_fetch_array($emailquery);
    


    $agent_email = $emailfetch['email_id'];  // Get agent email from form or database
    $pdf_path = $_FILES['policy_pdf']['tmp_name']; // Uploaded PDF file
    $pdf_name = $_FILES['policy_pdf']['name']; // Original file name
    //$customername// Example field from form
    //$policyno // Example field from form
    //$vehicleno 
    //$entrydate
    //$entryno;

    if (!empty($agent_email)) {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';  // Change this to your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'noreply@cibentry.com'; // Your email
            $mail->Password = 'Apple.@2025'; // Your email password (Use App Passwords if 2FA enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email settings
            $mail->setFrom('noreply@cibentry.com', 'CIB Entry');
            $mail->addAddress($agent_email); // Send email to the agent
            $mail->Subject = "New Business Entry Submitted for - Entry Date: ".$entrydate." Entry No: ".$entryno." Vehicle No: ".$vehicleno." Customer Name: ".$customername;
            $mail->isHTML(true);
            $mail->Body = "
                <p>Dear $posname,</p>
                <p>A new business entry has been submitted.</p>
                <p><strong>Customer Name:</strong> $customername</p>
                <p><strong>Policy Number:</strong> $policyno</p>
                <p><strong>Vehicle Number:</strong> $vehicleno</p>
                <p><strong>Entry Date:</strong> $entrydate</p>
                <p><strong>Entry Number:</strong> $entryno</p>
                <p>Regards,<br>cibentry.com</p>
            ";

            // Attach PDF if uploaded
            if (!empty($pdf_path)) {
                $mail->addAttachment($pdf_path, $pdf_name);
            }

            // Send email
            if ($mail->send()) {
                echo "Email sent successfully!";
            } else {
                echo "Email sending failed!";
            }
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "No agent email found.";
    }

        // Redirect to businessentry.php
        header("Location: businessentry.php");
        exit();
    } else {
        echo "Error inserting data: " . $stmt->error;
    }
}
?>
