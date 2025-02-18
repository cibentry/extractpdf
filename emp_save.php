<?php
include('db.php');
session_start();

if (isset($_POST['submit'])) {
    // Collecting and sanitizing input data
    $e_code = strip_tags($_POST['e_code']);
    $name = strip_tags($_POST['name']);
    $phone = strip_tags($_POST['phone']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $designation = strip_tags($_POST['designation']);
    $functionality = strip_tags($_POST['functionality']);
    $department = strip_tags($_POST['department']);
    $mapped_zone = strip_tags($_POST['mapped_zone']);
    $mapped_zone_id = strip_tags($_POST['mapped_zone_id']);
    $reporting_name = strip_tags($_POST['reporting_name']);
    $reporting_ecode = strip_tags($_POST['reporting_ecode']);
    $reporting_functionality = strip_tags($_POST['reporting_funcationality']);
    $salary = strip_tags($_POST['salary']);
    $hire_date = strip_tags($_POST['hire_date']);
    $status = strip_tags($_POST['status']);
    $employee_type = strip_tags($_POST['employee_type']);
    $location = strip_tags($_POST['location']);
    $zone = strip_tags($_POST['zone']);
    $access_id = strip_tags($_POST['access_id']);
    $remarks = " "; // Initialization for branch remarks

    // Check if functionality is not empty
    if (empty($functionality)) {
        echo "Error: Functionality is required.";
    } else {
        // Prepared statement to insert data into employee_master table
        $stmt = $con->prepare("INSERT INTO employee_master 
            (e_code, name, phone, email, password, designation, funcationality, department, reporting_name, reporting_ecode, 
             reporting_funcationality, salary, hire_date, status, employee_type, location, zone, access_id, mapped_zone, mapped_zone_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters (s - string, i - integer, d - double, b - blob)
        $stmt->bind_param("ssssssssssssssssssss", 
            $e_code, $name, $phone, $email, $password, $designation, $functionality, $department, $reporting_name, $reporting_ecode, 
            $reporting_functionality, $salary, $hire_date, $status, $employee_type, $location, $zone, $access_id, $mapped_zone, $mapped_zone_id);
        
        // Prepared statement to insert data into login_master table
        $loginquery = $con->prepare("INSERT INTO login_master(code, name, email_id, password, type, access_id, mapped_zone, mapped_zone_id, remarks) 
            VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Bind parameters for login table
        $loginquery->bind_param("sssssssss", $e_code, $name, $email, $password, $employee_type, $access_id, $mapped_zone, $mapped_zone_id, $remarks);    
        $loginquery->execute();

        // Execute the first insert statement for employee_master
        if($stmt->execute()) {
            // Get the last inserted entry number
            $lastecode = $con->insert_id;

            // Prepare and execute insert into posp_master table for 'Cut-Pay' role
            $posp_id = '';
            $organisation_role = '';
            $username = 'Cut-Pay';
            $email_id = '';
            $password = '';
            $contact_no = '';
            $rm_name = strip_tags($_POST['name']);
            $rm_number = strip_tags($_POST['phone']);
            $e_code = strip_tags($_POST['e_code']);
            $pincode = '';
            $district = '';
            $state_name = '';
            $zone = '';
            $mapped_zone = strip_tags($_POST['mapped_zone']);
            $mapped_zone_id = strip_tags($_POST['mapped_zone_id']);
            $retention = '0';
            $portal_access = '0';

            $pospquery = $con->prepare("INSERT INTO posp_master(posp_id, organisation_role, username, email_id, password, contact_no, rm_name, rm_number, e_code, pincode, district, state_name, zone, mapped_zone, mapped_zone_id, retention, portal_access) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pospquery->bind_param("sssssssssssssssss", $posp_id, $organisation_role, $username, $email_id, $password, $contact_no, $rm_name, $rm_number, $e_code, $pincode, $district, $state_name, $zone, $mapped_zone, $mapped_zone_id, $retention, $portal_access);
            $pospquery->execute();

            // Prepare and execute insert into posp_master table for 'Direct' role
            $posp_id = '';
            $organisation_role = '';
            $username = 'Direct';
            $email_id = '';
            $password = '';
            $contact_no = '';
            $rm_name = strip_tags($_POST['name']);
            $rm_number = strip_tags($_POST['phone']);
            $e_code = strip_tags($_POST['e_code']);
            $pincode = '';
            $district = '';
            $state_name = '';
            $zone = '';
            $mapped_zone = strip_tags($_POST['mapped_zone']);
            $mapped_zone_id = strip_tags($_POST['mapped_zone_id']);
            $retention = '0';
            $portal_access = '0';
            $_SESSION['last_ecode'] = $lastecode;

            $pospquery = $con->prepare("INSERT INTO posp_master(posp_id, organisation_role, username, email_id, password, contact_no, rm_name, rm_number, e_code, pincode, district, state_name, zone, mapped_zone, mapped_zone_id, retention, portal_access) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $pospquery->bind_param("sssssssssssssssss", $posp_id, $organisation_role, $username, $email_id, $password, $contact_no, $rm_name, $rm_number, $e_code, $pincode, $district, $state_name, $zone, $mapped_zone, $mapped_zone_id, $retention, $portal_access);
            $pospquery->execute();



            // Redirect to employee_creation_it.php
            header("Location: employee_creation_it.php"); 
            exit();
        } else {
            echo "Error saving data: " . $stmt->error;
        }
    }
}
?>
