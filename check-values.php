<?php
include('db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Debug: Log raw input
$raw_input = file_get_contents('php://input');
error_log('Raw input: ' . $raw_input);
error_log('POST Data: ' . print_r($_POST, true));

// Get and sanitize the values, with strict checking
$vehicleNo = isset($_POST['vehicleNo']) ? trim($_POST['vehicleNo']) : '';
$engineNo = isset($_POST['engineNo']) ? trim($_POST['engineNo']) : '';
$chassisNo = isset($_POST['chassisNo']) ? trim($_POST['chassisNo']) : '';
$policyNo = isset($_POST['policyNo']) ? trim($_POST['policyNo']) : '';

// Debug log
error_log(sprintf(
    "Received values - Vehicle: %s, Engine: %s, Chassis: %s, Policy: %s",
    $vehicleNo,
    $engineNo,
    $chassisNo,
    $policyNo
));

// Validate inputs
if ($engineNo === '' || $chassisNo === '' || $policyNo === '') {
    error_log('Validation failed - missing parameters');
    echo json_encode([
        'exists' => false,
        'error' => 'Missing required parameters',
        'received' => [
            'vehicleNo' => $vehicleNo,
            'engineNo' => $engineNo,
            'chassisNo' => $chassisNo,
            'policyNo' => $policyNo
        ]
    ]);
    exit;
}

try {
    if (strtoupper($vehicleNo) === 'NEW') {
        $query = "SELECT entry_no, policy_start_date FROM daily_booking 
                  WHERE UPPER(engine_number) = UPPER(?) 
                  OR UPPER(chassi_number) = UPPER(?) 
                  OR UPPER(policy_no) = UPPER(?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sss", $engineNo, $chassisNo, $policyNo);
    } else {
        $query = "SELECT entry_no, policy_start_date FROM daily_booking 
                  WHERE UPPER(vehicle_registration_no) = UPPER(?) 
                  OR UPPER(engine_number) = UPPER(?) 
                  OR UPPER(chassi_number) = UPPER(?) 
                  OR UPPER(policy_no) = UPPER(?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $vehicleNo, $engineNo, $chassisNo, $policyNo);
    }

    error_log('Executing query: ' . $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = [
            'exists' => true,
            'entryNo' => $row['entry_no'],
            'rsd' => $row['policy_start_date']
        ];
    } else {
        $response = ['exists' => false];
    }

    error_log('Response: ' . json_encode($response));
    echo json_encode($response);
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode([
        'exists' => false,
        'error' => 'Database error occurred: ' . $e->getMessage()
    ]);
} finally {
    mysqli_close($con);
}
?>