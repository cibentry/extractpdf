<?php
include('db.php');
session_start();

$searchby = $_POST['searchby'];
$searchvalue = $_POST['searchvalue'];
$manager = $_SESSION['username'];

$posname = "SELECT password FROM `newemp` where `name`='$_SESSION[username]'";
$pospresult = mysqli_query($con, $posname) or die(mysqli_error());
$posprow = mysqli_fetch_array($pospresult);
if ($posprow > 0) {
    $poscode = $posprow['password'];
}


$output = '';

switch ($searchby) {

    case 1:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
        daily_booking WHERE entry_no = '$searchvalue' AND pos_code='$poscode'";
        $result = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#8595;</a></td>
                                <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                <td>' . $row['customer_name'] . '</td>
                                <td>' . $row['vehicle_registration_no'] . '</td>
                                <td>' . $row['Policy_no'] . '</td>
                                <td>' . $row['Policy_start_date'] . '</td>
                                <td>' . $row['booking_status'] . '</td>
                            </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 2:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
            daily_booking WHERE policy_no = '$searchvalue' AND pos_code='$poscode'";
        ;
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                    <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#xf1c1;</a></td>
                                    <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                    <td>' . $row['customer_name'] . '</td>
                                    <td>' . $row['vehicle_registration_no'] . '</td>
                                    <td>' . $row['Policy_no'] . '</td>
                                    <td>' . $row['Policy_start_date'] . '</td>
                                    <td>' . $row['booking_status'] . '</td>
                                </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 3:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                daily_booking WHERE customer_name LIKE '%$searchvalue%'AND pos_code='$poscode'";
        $result = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                        <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#xf1c1;</a></td>
                                        <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                        <td>' . $row['customer_name'] . '</td>
                                        <td>' . $row['vehicle_registration_no'] . '</td>
                                        <td>' . $row['Policy_no'] . '</td>
                                        <td>' . $row['Policy_start_date'] . '</td>
                                        <td>' . $row['booking_status'] . '</td>
                                    </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 4:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                    daily_booking WHERE vehicle_registration_no LIKE '%$searchvalue%'AND pos_code='$poscode'";
        $result = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                            <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#xf1c1;</a></td>
                                            <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                            <td>' . $row['customer_name'] . '</td>
                                            <td>' . $row['vehicle_registration_no'] . '</td>
                                            <td>' . $row['Policy_no'] . '</td>
                                            <td>' . $row['Policy_start_date'] . '</td>
                                            <td>' . $row['booking_status'] . '</td>
                                        </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 5:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                        daily_booking WHERE engine_number LIKE '%$searchvalue%'AND pos_code='$poscode'";
        $result = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#xf1c1;</a></td>
                                                <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                                <td>' . $row['customer_name'] . '</td>
                                                <td>' . $row['vehicle_registration_no'] . '</td>
                                                <td>' . $row['Policy_no'] . '</td>
                                                <td>' . $row['Policy_start_date'] . '</td>
                                                <td>' . $row['booking_status'] . '</td>
                                            </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 6:
        $sqlsearch = "SELECT file_path, entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                            daily_booking WHERE chassi_number LIKE '%$searchvalue%'AND pos_code='$poscode'";
        $result = mysqli_query($con, $sqlsearch);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                    <td><a href="' . str_replace('.htm', '.pdf', $row['file_path']) . '" target="_blank">&#xf1c1;</a></td>
                                                    <td><a href="agent_entry_details.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
                                                    <td>' . $row['customer_name'] . '</td>
                                                    <td>' . $row['vehicle_registration_no'] . '</td>
                                                    <td>' . $row['Policy_no'] . '</td>
                                                    <td>' . $row['Policy_start_date'] . '</td>
                                                    <td>' . $row['booking_status'] . '</td>
                                                </tr>';


            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line
}

echo $output;
?>