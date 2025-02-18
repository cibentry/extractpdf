<?php

include('db.php');
session_start();

$state = $_POST['state'];
$policy = $_POST['policy'];
$cc = $_POST['cc'];
$insurer = $_POST['insurer'];
$age = $_POST['age'];
$fueltype = $_POST['fueltype'];
$fncb = $_POST['fncb'];
$month = $_POST['month'];

$currentmonth = date('F');


if ($currentmonth == $month){
    if ($insurer == 'ALL') {
        $insuranceCondition = "1"; // No filter applied
    } else {
        $insuranceCondition = "(Insurance_Co = '$insurer' OR Insurance_Co = '' OR Insurance_Co IS NULL)";
    }
    
    
    if ($insurer == 'ALL') {
        $gridquery = "SELECT 
        final_out_posp AS 'Points', 
        Insurance_Co AS 'Insurance Co',
        Fuel AS 'Fuel',
        ncb AS 'NCB',
        CONCAT(
            COALESCE(Our_Segment, ''), ' ',
            'CLUSTER: ', COALESCE(Cluster, ''), ' ',
            'RTO: ', COALESCE(RTO_Remarks, ''), ' ',
            'Policy Type: ', COALESCE(Policy_Type, ''), ' ', 
            'Age: ', COALESCE(Age, ''), ', ',
            'Make-Model: ', COALESCE(Make_Remarks, ''), ', ',
            COALESCE(Other_Remarks, ''), ', ',
            COALESCE(Month, '')
        ) AS 'Details'
    FROM 
        grid_pvt
    WHERE 
        State_Name = '$state'
        AND (
            ($cc BETWEEN Lower_cc AND Upper_cc)
            OR (Lower_cc IS NOT NULL AND $cc >= Lower_cc AND Upper_cc IS NULL)
            OR (Upper_cc IS NOT NULL AND $cc <= Upper_cc AND Lower_cc IS NULL)
            OR (Lower_cc IS NULL AND Upper_cc IS NULL)
        )
        AND (Fuel = '$fueltype' OR Fuel = 'NA')
        AND Policy_Type = '$policy'
                  
                ORDER BY final_out_posp DESC";
    } else {
        $gridquery = "SELECT 
        final_out_posp AS 'Points', 
        Insurance_Co AS 'Insurance Co',
        Fuel AS 'Fuel',
        ncb AS 'NCB',
        CONCAT(
            COALESCE(Our_Segment, ''), ' ',
            'CLUSTER: ', COALESCE(Cluster, ''), ' ',
            'RTO: ', COALESCE(RTO_Remarks, ''), ' ',
            'Policy Type: ', COALESCE(Policy_Type, ''), ' ', 
            'Age: ', COALESCE(Age, ''), ', ',
            'Make-Model: ', COALESCE(Make_Remarks, ''), ', ',
            COALESCE(Other_Remarks, ''), ', ',
            COALESCE(Month, '')
        ) AS 'Details'
    FROM 
        grid_pvt
    WHERE 
        State_Name = '$state'
        AND (
            ($cc BETWEEN Lower_cc AND Upper_cc)
            OR (Lower_cc IS NOT NULL AND $cc >= Lower_cc AND Upper_cc IS NULL)
            OR (Upper_cc IS NOT NULL AND $cc <= Upper_cc AND Lower_cc IS NULL)
            OR (Lower_cc IS NULL AND Upper_cc IS NULL)
        )
        AND (Fuel = '$fueltype' OR Fuel = 'NA')
        AND Policy_Type = '$policy'
        AND Insurance_Co = '$insurer'    
                 ORDER BY final_out_posp DESC";
    }
} else {
    if ($insurer == 'ALL') {
        $insuranceCondition = "1"; // No filter applied
    } else {
        $insuranceCondition = "(Insurance_Co = '$insurer' OR Insurance_Co = '' OR Insurance_Co IS NULL)";
    }
    
    
    if ($insurer == 'ALL') {
        $gridquery = "SELECT 
        final_out_posp AS 'Points', 
        Insurance_Co AS 'Insurance Co',
        Fuel AS 'Fuel',
        ncb AS 'NCB',
        CONCAT(
            COALESCE(Our_Segment, ''), ' ',
            'CLUSTER: ', COALESCE(Cluster, ''), ' ',
            'RTO: ', COALESCE(RTO_Remarks, ''), ' ',
            'Policy Type: ', COALESCE(Policy_Type, ''), ' ', 
            'Age: ', COALESCE(Age, ''), ', ',
            'Make-Model: ', COALESCE(Make_Remarks, ''), ', ',
            COALESCE(Other_Remarks, ''), ', ',
            COALESCE(Month, '')
        ) AS 'Details'
    FROM 
        grid_pvt
    WHERE 
        State_Name = '$state'
        AND (
            ($cc BETWEEN Lower_cc AND Upper_cc)
            OR (Lower_cc IS NOT NULL AND $cc >= Lower_cc AND Upper_cc IS NULL)
            OR (Upper_cc IS NOT NULL AND $cc <= Upper_cc AND Lower_cc IS NULL)
            OR (Lower_cc IS NULL AND Upper_cc IS NULL)
        )
        AND (Fuel = '$fueltype' OR Fuel = 'NA')
        AND Policy_Type = '$policy'
        AND Month = '$month'         
        ORDER BY final_out_posp DESC";
    } else {
        $gridquery = "SELECT 
        final_out_posp AS 'Points', 
        Insurance_Co AS 'Insurance Co',
        Fuel AS 'Fuel',
        ncb AS 'NCB',
        CONCAT(
            COALESCE(Our_Segment, ''), ' ',
            'CLUSTER: ', COALESCE(Cluster, ''), ' ',
            'RTO: ', COALESCE(RTO_Remarks, ''), ' ',
            'Policy Type: ', COALESCE(Policy_Type, ''), ' ', 
            'Age: ', COALESCE(Age, ''), ', ',
            'Make-Model: ', COALESCE(Make_Remarks, ''), ', ',
            COALESCE(Other_Remarks, ''), ', ',
            COALESCE(Month, '')
        ) AS 'Details'
    FROM 
        grid_pvt
    WHERE 
        State_Name = '$state'
        AND (
            ($cc BETWEEN Lower_cc AND Upper_cc)
            OR (Lower_cc IS NOT NULL AND $cc >= Lower_cc AND Upper_cc IS NULL)
            OR (Upper_cc IS NOT NULL AND $cc <= Upper_cc AND Lower_cc IS NULL)
            OR (Lower_cc IS NULL AND Upper_cc IS NULL)
        )
        AND (Fuel = '$fueltype' OR Fuel = 'NA')
        AND Policy_Type = '$policy'
        AND Insurance_Co = '$insurer'  
        AND Month = '$month'   
                 ORDER BY final_out_posp DESC";
    }
}




$gridresult = $con->query($gridquery);



if ($gridresult->num_rows > 0) {

    $currentDate = date('d-m-Y');
    $gridoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Search Results for Four Wheeler | State: ' . $state . ' | Policy: ' . $policy . ' | 
                GVW: ' . $cc . ' | Age: ' . $age . ' | Date: ' . $currentDate . '
            </p2>
            <table class="table table-striped" id="gridtable">
                    <thead>
                        <tr>
                            <th>Final Output</th>
                            <th>Insurance Co</th>
                            <th>Fuel Type</th>
                            <th>NCB Required</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>';


    while ($row = $gridresult->fetch_assoc()) {
        $gridoutput .= '<tr>
                                    <td>' . $row['Points'] . '</td>
                                    <td>' . $row['Insurance Co'] . '</td>
                                    <td>' . $row['Fuel'] . '</td>
                                    <td>' . $row['NCB'] . '</td>
                                    <td>' . $row['Details'] . '</td>
                                </tr>';
    }

    $gridoutput .= '</tbody>
                            </table>';

    echo $gridoutput;
}
