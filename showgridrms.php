<?php

include('db.php');
session_start();
$vehicle = $_POST['vehicle'];
$state = $_POST['state'];
$policy = $_POST['policy'];
$gvw = $_POST['gvw'];
$insurer = $_POST['insurer'];
$age = $_POST['age'];
$vehicletype = $_POST['vehicletype'];
$user = $_SESSION['username'];
$month = $_POST['month'];

$currentmonth = date('F');



if ($currentmonth == $month) {

    if ($insurer == 'ALL') {
        $gridquery = "SELECT 
            final_out_posp AS 'Points',
                Insurance_Co AS 'Insurance Co',
                COALESCE(RTO_Remarks, '-') AS 'RTO',
    COALESCE(Cluster, '-') AS 'Cluster Name',
    COALESCE(Make_Remarks, '-') AS 'Make',
                CONCAT( COALESCE(Other_Remarks, ''), ',', 
                'Fuel: ', COALESCE(Fuel, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
        WHERE Vehicle_Type = '$vehicletype'
          AND State_Name = '$state'
          AND (
              ($gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NOT NULL AND $gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NULL AND $gvw >= Lower_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NOT NULL AND $gvw <= Upper_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NULL)
          )
          AND (
              ($age BETWEEN Lower_Age AND Upper_Age) 
              OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
              OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
              OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
              OR (Lower_Age IS NULL AND Upper_Age IS NULL)
          )
          AND Policy_Type = '$policy'
          AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
        ORDER BY final_out_posp DESC";
    } else {
        $gridquery = "SELECT 
            final_out_posp AS 'Points',
                Insurance_Co AS 'Insurance Co',
                COALESCE(RTO_Remarks, '-') AS 'RTO',
    COALESCE(Cluster, '-') AS 'Cluster Name',
    COALESCE(Make_Remarks, '-') AS 'Make',
                CONCAT( COALESCE(Other_Remarks, ''), ',', 
                'Fuel: ', COALESCE(Fuel, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
        WHERE Vehicle_Type = '$vehicletype'
         AND State_Name = '$state'
           AND (
              ($gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NOT NULL AND $gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NULL AND $gvw >= Lower_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NOT NULL AND $gvw <= Upper_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NULL)
          )
           AND (
               ($age BETWEEN Lower_Age AND Upper_Age) 
                OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                OR (Lower_Age IS NULL AND Upper_Age IS NULL)
           )
           AND Policy_Type = '$policy'
           AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
           AND Insurance_Co = '$insurer'
         ORDER BY final_out_posp DESC";
    }
} else {
    if ($insurer == 'ALL') {
        $gridquery = "SELECT 
            final_out_posp AS 'Points',
                Insurance_Co AS 'Insurance Co',
                COALESCE(RTO_Remarks, '-') AS 'RTO',
    COALESCE(Cluster, '-') AS 'Cluster Name',
    COALESCE(Make_Remarks, '-') AS 'Make',
                CONCAT( COALESCE(Other_Remarks, ''), ',', 
                        'Fuel: ', COALESCE(Fuel, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
        WHERE Vehicle_Type = '$vehicletype'
          AND State_Name = '$state'
          AND (
              ($gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NOT NULL AND $gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NULL AND $gvw >= Lower_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NOT NULL AND $gvw <= Upper_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NULL)
          )
          AND (
              ($age BETWEEN Lower_Age AND Upper_Age) 
              OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
              OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
              OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
              OR (Lower_Age IS NULL AND Upper_Age IS NULL)
          )
          AND Policy_Type = '$policy'
          AND Month = '$month'
        ORDER BY final_out_posp DESC";
    } else {
        $gridquery = "SELECT 
            final_out_posp AS 'Points',
                Insurance_Co AS 'Insurance Co',
                COALESCE(RTO_Remarks, '- ') AS 'RTO',
                COALESCE(Cluster, '- ') AS 'Cluster Name',
                COALESCE(Make_Remarks, '- ') AS 'Make',COALESCE(RTO_Remarks, '- ') AS 'RTO',
                COALESCE(Cluster, '- ') AS 'Cluster Name',
                COALESCE(Make_Remarks, '- ') AS 'Make',
                CONCAT( COALESCE(Other_Remarks, ''), ',', 
                'Fuel: ', COALESCE(Fuel, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
        WHERE Vehicle_Type = '$vehicletype'
         AND State_Name = '$state'
           AND (
              ($gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NOT NULL AND $gvw BETWEEN Lower_GVW AND Upper_GVW)
              OR (Lower_GVW IS NOT NULL AND Upper_GVW IS NULL AND $gvw >= Lower_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NOT NULL AND $gvw <= Upper_GVW)
              OR (Lower_GVW IS NULL AND Upper_GVW IS NULL)
          )
           AND (
               ($age BETWEEN Lower_Age AND Upper_Age) 
                OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                OR (Lower_Age IS NULL AND Upper_Age IS NULL)
           )
           AND Policy_Type = '$policy'
           AND Insurance_Co = '$insurer'
           AND Month = '$month'
         ORDER BY final_out_posp DESC";
    }
}



$gridresult = $con->query($gridquery);


if ($gridresult->num_rows > 0) {
    $vehicleType = ($vehicle == 1) ? "GCV" : (($vehicle == 2) ? "Misc" : "Unknown");
    $currentDate = date('d-m-Y');
    $gridoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Search Results for ' . $vehicletype . ' | State: ' . $state . ' | Policy: ' . $policy . ' | 
                GVW: ' . $gvw . ' | Age: ' . $age . ' | Date: ' . $currentDate . '
            </p2>
            <table class="table table-striped" id="gridtable">
                    <thead>
                        <tr>
                            <th>Final Output</th>
                            <th>Insurance Co</th>
                            <th>RTO</th>
                            <th>Cluster</th>
                            <th>Make</th>
                            <th>Details</th>

                        </tr>
                    </thead>
                    <tbody>';


    while ($row = $gridresult->fetch_assoc()) {
        $gridoutput .= '<tr>
                                    <td style="font-weight: bold;">' . $row['Points'] . '</td>
                                    <td>' . $row['Insurance Co'] . '</td>
                                    <td>' . $row['RTO'] . '</td>
                                    <td>' . $row['Cluster Name'] . '</td>
                                    <td>' . $row['Make'] . '</td>
                                    <td>' . $row['Details'] . '</td>
                                </tr>';
    }

    $gridoutput .= '</tbody>
                            </table>';

    echo $gridoutput;
}
