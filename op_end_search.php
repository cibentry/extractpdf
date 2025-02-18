<?php
include('db.php');


$searchby = $_POST['searchby'];
$searchvalue = $_POST['searchvalue'];
$zoneid = $_POST['zoneid'];

switch ($searchby) {

    case 1:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
        daily_booking WHERE entry_no = '$searchvalue' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                <td>' . htmlspecialchars($row['entry_no']) . '</td>
                                <td>' . htmlspecialchars($row['customer_name']) . '</td>
                                <td>' . htmlspecialchars($row['vehicle_registration_no']) . '</td>
                                <td>' . htmlspecialchars($row['Policy_no']) . '</td>
                                <td>' . htmlspecialchars($row['Policy_start_date']) . '</td>
                                <td>' . htmlspecialchars($row['booking_status']) . '</td>
                                <td>
                                    <a href="op_end_entry.php?id=' . urlencode($row['entry_no']) . '" 
                                       class="btn btn-sm btn-warning text-white fw-bold">
                                        Endorsement
                                    </a>
                                </td>
                                <td>
                                    <button class="form-control bg-danger text-white fw-bold">Cancellation</button>
                                </td>
                            </tr>';
            }
            
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 2:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
            daily_booking WHERE policy_no = '$searchvalue' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                    <td>' . $row['entry_no'] . '</a></td>
                                    <td>' . $row['customer_name'] . '</td>
                                    <td>' . $row['vehicle_registration_no'] . '</td>
                                    <td>' . $row['Policy_no'] . '</td>
                                    <td>' . $row['Policy_start_date'] . '</td>
                                    <td>' . $row['booking_status'] . '</td>
                                    <td>
                                    <button>Endorsement</button>
                                    <button>Cancellation</button>
                                </td>
                                </tr>';
            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 3:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                daily_booking WHERE customer_name LIKE '%$searchvalue%' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                        <td>' . $row['entry_no'] . '</a></td>
                                        <td>' . $row['customer_name'] . '</td>
                                        <td>' . $row['vehicle_registration_no'] . '</td>
                                        <td>' . $row['Policy_no'] . '</td>
                                        <td>' . $row['Policy_start_date'] . '</td>
                                        <td>' . $row['booking_status'] . '</td>
                                        <td>
                                    <button>Endorsement</button>
                                    <button>Cancellation</button>
                                </td>
                                    </tr>';
            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 4:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                    daily_booking WHERE vehicle_registration_no LIKE '%$searchvalue%' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                            <td>' . $row['entry_no'] . '</a></td>
                                            <td>' . $row['customer_name'] . '</td>
                                            <td>' . $row['vehicle_registration_no'] . '</td>
                                            <td>' . $row['Policy_no'] . '</td>
                                            <td>' . $row['Policy_start_date'] . '</td>
                                            <td>' . $row['booking_status'] . '</td>
                                            <td>
                                    <button>Endorsement</button>
                                    <button>Cancellation</button>
                                </td>
                                        </tr>';
            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 5:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                        daily_booking WHERE engine_number LIKE '%$searchvalue%' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                <td>' . $row['entry_no'] . '</a></td>
                                                <td>' . $row['customer_name'] . '</td>
                                                <td>' . $row['vehicle_registration_no'] . '</td>
                                                <td>' . $row['Policy_no'] . '</td>
                                                <td>' . $row['Policy_start_date'] . '</td>
                                                <td>' . $row['booking_status'] . '</td>
                                                <td>
                                    <button>Endorsement</button>
                                    <button>Cancellation</button>
                                </td>
                                            </tr>';
            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line

    case 6:
        $sqlsearch = "SELECT entry_no, customer_name, vehicle_registration_no, Policy_no, Policy_start_date, booking_status FROM 
                            daily_booking WHERE chassi_number LIKE '%$searchvalue%' AND mapped_zone_id = '$zoneid'";
        $result = mysqli_query($con, $sqlsearch);
        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                                                    <td>' . $row['entry_no'] . '</a></td>
                                                    <td>' . $row['customer_name'] . '</td>
                                                    <td>' . $row['vehicle_registration_no'] . '</td>
                                                    <td>' . $row['Policy_no'] . '</td>
                                                    <td>' . $row['Policy_start_date'] . '</td>
                                                    <td>' . $row['booking_status'] . '</td>
                                                    <td>
                                    <button>Endorsement</button>
                                    <button>Cancellation</button>
                                </td>
                                                </tr>';
            }
        } else {
            $output .= '<tr><td colspan="6">No records found</td></tr>';
        }
        break; // Add this line
}

echo $output;
