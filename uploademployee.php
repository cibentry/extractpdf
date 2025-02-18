<?php
include('db.php');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_FILES["file"]["size"] > 0) {
    $file = $_FILES["file"]["tmp_name"];
    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    
    $rowsProcessed = 0;
    $totalRows = 0;
    
    if ($ext == "csv") {
        $handle = fopen($file, "r");
        fgetcsv($handle); // Skip header row
        $data = [];
        while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    } else {
        $spreadsheet = IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        array_shift($data); // Remove header row
    }

    $totalRows = count($data);
    
    foreach ($data as $index => $row) {
        $e_code = $conn->real_escape_string($row[0]);
        $name = $conn->real_escape_string($row[1]);
        $phone = $conn->real_escape_string($row[2]);
        $email = $conn->real_escape_string($row[3]);
        $password = password_hash($row[4], PASSWORD_BCRYPT); // Encrypt password
        $designation = $conn->real_escape_string($row[5]);
        $funcationality = $conn->real_escape_string($row[6]);
        $department = $conn->real_escape_string($row[7]);
        $reporting_name = $conn->real_escape_string($row[8]);
        $reporting_ecode = $conn->real_escape_string($row[9]);
        $reporting_funcationality = $conn->real_escape_string($row[10]);
        $salary = $conn->real_escape_string($row[11]);
        $hire_date = $conn->real_escape_string($row[12]);
        $status = $conn->real_escape_string($row[13]);
        $employee_type = $conn->real_escape_string($row[14]);
        $location = $conn->real_escape_string($row[15]);
        $zone = $conn->real_escape_string($row[16]);
        $access_id = $conn->real_escape_string($row[17]);
        $mapped_zone = $conn->real_escape_string($row[18]);

        // Check if e_code exists
        $check_sql = "SELECT id FROM employee_master WHERE e_code = '$e_code'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {  
            // Update existing record
            $update_sql = "UPDATE employee_master SET 
                name='$name', phone='$phone', email='$email', password='$password',
                designation='$designation', funcationality='$funcationality', department='$department',
                reporting_name='$reporting_name', reporting_ecode='$reporting_ecode', reporting_funcationality='$reporting_funcationality',
                salary='$salary', hire_date='$hire_date', status='$status',
                employee_type='$employee_type', location='$location', zone='$zone',
                access_id='$access_id', mapped_zone='$mapped_zone'
                WHERE e_code='$e_code'";
            
            $con->query($update_sql);
        } else {
            // Insert new record
            $sql = "INSERT INTO employee_master 
                (e_code, name, phone, email, password, designation, funcationality, department, reporting_name, reporting_ecode, reporting_funcationality, salary, hire_date, status, employee_type, location, zone, access_id, mapped_zone) 
                VALUES 
                ('$e_code', '$name', '$phone', '$email', '$password', '$designation', '$funcationality', '$department', '$reporting_name', '$reporting_ecode', '$reporting_funcationality', '$salary', '$hire_date', '$status', '$employee_type', '$location', '$zone', '$access_id', '$mapped_zone')";
            
            $con->query($sql);
        }

        // Send progress update
        $progress = round(($index + 1) / $totalRows * 100);
        echo "<script>$('#progress-bar').css('width', '{$progress}%').text('{$progress}%');</script>";
        flush();
        $rowsProcessed++;
    }
    
    echo "Upload Completed: $rowsProcessed records processed!";
}
$con->close();
?>
