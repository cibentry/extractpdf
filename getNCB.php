<?php
include('db.php');

$insuranceCompany = $_POST['insuranceCompany'];
$policytype = $_POST['policytype'];

$query = mysqli_query($con, "SELECT DISTINCT NCB FROM grid_pvt WHERE Insurance_Co = '$insuranceCompany' and Policy_Type = '$policytype' ORDER BY NCB ASC") or die(mysqli_error());

while ($row = mysqli_fetch_array($query)) {
    echo "<option value='" . $row['NCB'] . "'>" . $row['NCB'] . "</option>";
}
?>