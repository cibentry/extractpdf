<?php
include('db.php');
session_start();

// Enable full PHP error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    // ✅ Check if database connection is established
    if (!$con) {
        die("❌ Database connection failed: " . mysqli_connect_error());
    } else {
        echo "✅ Database connection successful.<br>";
    }
    echo("post");
    // ✅ Collect and sanitize input data
    $posp_id = strip_tags($_POST['posp_id']);
    $organisation_role = strip_tags($_POST['organisation_role']);
    $name = strip_tags($_POST['name']);
    $email_id = strip_tags($_POST['email_id']);
    $password = strip_tags($_POST['password']);
    $contact_no = strip_tags($_POST['contact_no']);
    $district = strip_tags($_POST['district']);
    $state_name = strip_tags($_POST['state_name']);
    $mapped_zone = strip_tags($_POST['mapped_zone']);
    $mapped_zone_id = strip_tags($_POST['mapped_zone_id']);
    $rm_name = strip_tags($_POST['rm_name']);
    $rm_number = strip_tags($_POST['rm_number']);
    $e_code = strip_tags($_POST['e_code']);
    $pincode = strip_tags($_POST['pincode']);
    $zone = strip_tags($_POST['zone']);
    $retention = strip_tags($_POST['retention']);
    $portal_access = strip_tags($_POST['portal_access']);
    $timestamp = date("Y-m-d H:i:s"); // ✅ CORRECT: Formats timestamp properly for MySQL


    
    
    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT into posp_master(posp_id, organisation_role, username, email_id, password, contact_no, rm_name, rm_number, e_code, pincode, district, state_name, zone, mapped_zone, mapped_zone_id, retention, portal_access)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("sssssssssssssssss", 
        $posp_id, 
        $organisation_role, 
        $name, 
        $email_id, 
        $password, 
        $contact_no, 
        $rm_name, 
        $rm_number, 
        $e_code, 
        $pincode, 
        $district, 
        $state_name, 
        $zone, 
        $mapped_zone, 
        $mapped_zone_id, 
        $retention, 
        $portal_access
        );

    // Execute the statement
    $result = $stmt->execute();
    if($organisation_role =='POSP'||$organisation_role=='posp')
    {
        // Prepared statement to insert data into login_master table
        $access_id = "7";
        $remarks = " ";
        $loginquery = $con->prepare("INSERT INTO login_master(code, name, email_id, password, type, access_id, mapped_zone, mapped_zone_id, remarks) 
            VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters for login table
        $loginquery->bind_param("sssssssss", $posp_id, $name, $email_id, $password,$organisation_role,$access_id, $mapped_zone, $mapped_zone_id, $remarks);    
        $loginquery->execute();
    }

    if ($result) {
        echo "✅ Data inserted successfully! Redirecting...";
        // Redirect to POSP_creation_it.php
        header("Location: posp_creation_it.php");
        exit(); 
    } else {
        // ❌ Show detailed error if insertion fails
        echo "❌ Error saving data: " . $stmt->error;
        echo "Affected rows: " . mysqli_affected_rows($con);
    }
}
?>