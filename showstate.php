<?php
include 'db.php';
session_start();

$rtocode = $_POST['rtocode'];

$stmt = $con->prepare("SELECT * FROM rto_master WHERE RTO_CODE = ?");
$stmt->bind_param("s", $rtocode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $outputsegment = '';
    while ($insrow = $result->fetch_assoc()) {
        $outputsegment .= $insrow['TW_RTO_State_Final'];
    }
    echo $outputsegment;
} else {
    $outputsegment = '';
}

$stmt->close();
$con->close();
?>