<?php
include('db.php');


$searchby = $_POST['searchby'];
$searchvalue = $_POST['searchvalue'];

switch ($searchby) {

    case 1:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
        daily_booking WHERE entry_no = '$searchvalue'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
            daily_booking WHERE policy_no = '$searchvalue'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                    <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                daily_booking WHERE customer_name LIKE '%$searchvalue%'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                        <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                    daily_booking WHERE vehicle_registration_no LIKE '%$searchvalue%'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                            <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                        daily_booking WHERE engine_number LIKE '%$searchvalue%'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                            daily_booking WHERE chassi_number LIKE '%$searchvalue%'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                    <td><a href="super_edit_entry.php?entry_no=' . $row['entry_no'] . '">' . $row['entry_no'] . '</a></td>
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