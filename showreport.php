<?php
include('db.php');
session_start();

$mzone = $_POST['mzone'];
$currentDate = date("Y-m-d");

$monthName = date("F", strtotime($currentDate));

// Calculate the fiscal year
$currentYear = date("Y");
$fiscalYearStart = $currentYear; // Current year
$fiscalYearEnd = $currentYear + 1; // Next year

// Determine if the current month is before or after April
if (date("n") < 4) { // If the month is January (1), February (2), or March (3)
    $fiscalYearStart = $currentYear - 1; // Previous year
    $fiscalYearEnd = $currentYear; // Current year
}
// Format the fiscal year as "YYYY-YY"
$fiscalYear = $fiscalYearStart . '-' . substr($fiscalYearEnd, -2); // e.g., "2024-25"

$query = "SELECT
                                    mapped_zone,sm_name,
                                    SUM(CASE WHEN f_year = '$fiscalYear' THEN net_premium ELSE 0 END) AS YTD,
                                    SUM(CASE WHEN MONTH(CURRENT_DATE) = MONTH(STR_TO_DATE(policy_sold_date, '%Y-%m-%d')) 
                                            AND YEAR(CURRENT_DATE) = YEAR(STR_TO_DATE(policy_sold_date, '%Y-%m-%d')) THEN net_premium ELSE 0 END) AS MTD,
                                    SUM(CASE WHEN entry_date = CURRENT_DATE THEN net_premium ELSE 0 END) AS FTD,
                                    SUM(CASE WHEN booking_status = 'pending' THEN net_premium ELSE 0 END) AS Pending
                                FROM 
                                    daily_booking
                                WHERE
                                    mapped_zone = '$mzone'
                                GROUP BY
                                    sm_name
                                ORDER BY
                                    FTD DESC;";


$result = $con->query($query);
if ($result->num_rows > 0) {
    $reportoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Report For: ' . $mzone . '
            </p2>
            <table class="table table-striped" id="gridtable">
                    <thead>
                        <tr>
                            <th>Mapped Zone</th>
                            <th>SM Name</th>
                            <th>YTD</th>
                            <th>MTD</th>
                            <th>FTD</th>
                            <th>Pending</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $totalYTD = 0;
                    $totalMTD = 0;
                    $totalFTD = 0;
                    $totalPending = 0;
                    while ($row = $result->fetch_assoc()) {
                        $totalYTD += $row['YTD'];
                        $totalMTD += $row['MTD'];
                        $totalFTD += $row['FTD'];
                        $totalPending += $row['Pending'];
                        $reportoutput .= '<tr>
                                            <td>' . $row['mapped_zone'] . '</td>
                                            <td>' . $row['sm_name'] . '</td>
                                            <td><b style="color: blue;">' . $row['YTD'] . '</b></td>
                                            <td><b style="color: green;">' . $row['MTD'] . '</b></td>
                                            <td><b>' . $row['FTD'] . '</b></td>
                                            <td><b style="color: red;">' . $row['Pending'] . '</b></td>
                                        </tr>';
                    }
                
                    $reportoutput .= '<tfoot style="background-color: #f2f2f2;">
                                        <tr>
                                            <th colspan="2">Total:</th>
                                            <th><b style="color: blue;">' . $totalYTD . '</b></th>
                                            <th><b style="color: green;">' . $totalMTD . '</b></th>
                                            <th><b>' . $totalFTD . '</b></th>
                                            <th><b style="color: red;">' . $totalPending . '</b></th>
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                    </table>';
                
                    echo $reportoutput;
}
?>
