<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include('db.php'); // Ensure db.php correctly initializes $con
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
} else {
    echo "Database Connected Successfully!<br>";
}

if (isset($_POST['submit'])) {
    // Check if file is uploaded
    if (!isset($_FILES['import-file']) || $_FILES['import-file']['error'] !== UPLOAD_ERR_OK) {
        die("File upload failed! Error Code: " . $_FILES['import-file']['error']);
    }

    $filename = $_FILES['import-file']['name'];
    echo "File uploaded successfully: " . $filename . "<br>";

    $allowed_ext = array('xls', 'xlsx', 'csv');
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

    // Validate file type
    if (!in_array($file_ext, $allowed_ext)) {
        $_SESSION['message'] = "Invalid file type!";
        header("Location: employee_bulk.php");
        exit();
    }

    $inputFileNamePath = $_FILES['import-file']['tmp_name'];

    // Load Excel file
    try {
        $spreadsheet = IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
    } catch (Exception $e) {
        die("Error loading file: " . $e->getMessage());
    }

    echo "<pre>";
    print_r($data); // Debug: Check Excel data
    echo "</pre>";

    if (count($data) <= 1) {
        die("No data found in the uploaded file!");
    }

    $count = 0;
    foreach ($data as $row) {
        if ($count > 0) {
            // Assign values from Excel
            $ecode = trim($row[1]);
            $name = trim($row[2]);
            $phone = trim($row[3]);
            $email = trim($row[4]);
            $password = trim($row[5]);
            $designation = trim($row[6]);
            $funcationality = trim($row[7]);
            $department = trim($row[8]);
            $reporting_name = trim($row[9]);
            $reporting_ecode = trim($row[10]);
            $reporting_funcationality = trim($row[11]);
            $salary = trim($row[12]);
            $hire_date = trim($row[13]);
            $status = trim($row[14]);
            $employee_type = trim($row[15]);
            $location = trim($row[16]);
            $zone = trim($row[17]);
            $access_id = trim($row[18]);
            $mapped_zone = trim($row[19]);
            $mapped_zone_id = trim($row[20]);

            // Debug: Print data before inserting
            echo "Inserting Row: $ecode, $name, $phone, $email, $salary<br>";

            // Prepare Insert Query
            $stmt = $con->prepare("INSERT INTO employee_master 
                (e_code, name, phone, email, password, designation, funcationality, department, reporting_name, reporting_ecode, 
                 reporting_funcationality, salary, hire_date, status, employee_type, location, zone, access_id, mapped_zone, mapped_zone_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            }

            $stmt->bind_param("ssssssssssssssssssss", 
                $ecode, $name, $phone, $email, $password, $designation, $funcationality, $department, $reporting_name, $reporting_ecode, 
                $reporting_funcationality, $salary, $hire_date, $status, $employee_type, $location, $zone, $access_id, $mapped_zone, $mapped_zone_id
            );

            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            } else {
                echo "Row Inserted Successfully!<br>";
            }

            $stmt->close();
        } else {
            $count = 1;
        }
    }

    $_SESSION['message'] = "Upload Successful";
    header("Location: employee_bulk.php");
    exit();
}
?>
