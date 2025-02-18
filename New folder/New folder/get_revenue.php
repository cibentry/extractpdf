<?php
include('db.php');
session_start();

$fyear = $_POST['financialyear'];
$month = $_POST['selectedMonth'];
$zoneid = $_POST['zoneid'];
$user = $_SESSION['username'];


$sqldisplay = "
    SELECT 
        db.sm_name, 
        SUM(db.margin) AS margin,
        ne.salary
    FROM 
        daily_booking db
    INNER JOIN 
        newemp ne ON db.sm_name = ne.name
    WHERE
        db.month_name = '$month' AND db.mapped_zone_id = '$zoneid' and f_year = '$fyear'
    GROUP BY 
        db.sm_name, ne.salary
    ORDER BY 
        margin DESC;";

$sqlresult = $con->query($sqldisplay);
$disrow = mysqli_num_rows($sqlresult);
if ($disrow > 0) {
    echo "<table class='table table-hover text-center'>";
    echo "<tr>";
    echo "<th>SM Name</th>";
    echo "<th>Revenue</th>";
    echo "</tr>";
    while ($row = mysqli_fetch_assoc($sqlresult)) {
        $revenue = $row['margin'] - $row['salary'];
        echo "<tr>
                <td>" . htmlspecialchars($row['sm_name']) . "</td>
                <td>" . htmlspecialchars($revenue) . "</td>
            </tr>";
    }
    echo "</table>";
    
} else {
    echo "No Record Found";
}
?>