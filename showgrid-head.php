<?php

include('db.php');
session_start();
$vehicle = $_POST['vehicle'];
$state = $_POST['state'];
$policy = $_POST['policy'];
$gvw = $_POST['gvw'];
$insurer = $_POST['insurer'];
$age = $_POST['age'];








        if ($insurer == 'ALL') {
            $gridquery = "SELECT 
                po_in_final AS 'Inward Points',
                final_out_posp As 'Outward Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
             WHERE State_Name = '$state'
               AND (Lower_GVW <= $gvw AND Upper_GVW >= $gvw)
               AND (
                   ($age BETWEEN Lower_Age AND Upper_Age) 
                   OR (Lower_Age = '' AND Upper_Age = '')
                   OR (Lower_Age IS NULL AND $age <= Upper_Age)
                   OR (Upper_Age IS NULL AND $age >= Lower_Age)
               )
               AND Policy_Type = '$policy'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
             ORDER BY po_in_final DESC";
        
        } else {
            $gridquery = "SELECT 
                po_in_final AS 'Inward Points',
                final_out_posp As 'Outward Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_gcv
             WHERE State_Name = '$state'
               AND (Lower_GVW <= $gvw AND Upper_GVW >= $gvw)
               AND (
                   ($age BETWEEN Lower_Age AND Upper_Age) 
                   OR (Lower_Age = '' AND Upper_Age = '')
                   OR (Lower_Age IS NULL AND $age <= Upper_Age)
                   OR (Upper_Age IS NULL AND $age >= Lower_Age)
               )
               AND Policy_Type = '$policy'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
               AND Insurance_Co = '$insurer'
             ORDER BY po_in_final DESC";
        }
        
        $gridresult = $con->query($gridquery);
        
        
        if ($gridresult->num_rows > 0) {
            $vehicleType = ($vehicle == 1) ? "GCV" : (($vehicle == 2) ? "Misc" : "Unknown");
            $currentDate = date('d-m-Y');
            $gridoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Search Results for Vehicle: GCV,  State: ' . $state . ' | Policy: ' . $policy . ' | 
                GVW: ' . $gvw . ' | Age: ' . $age . ' | Date: ' . $currentDate . '
            </p2>
            <table class="table table-striped" id="gridtable">
                    <thead>
                        <tr>
                            <th>Inward Points</th>
                            <th>Outward Points</th>
                            <th>Insurance Co</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        
            while ($row = $gridresult->fetch_assoc()) {
                $gridoutput .= '<tr>
                                            <td style="color: green;"><b>' . $row['Inward Points'] . '</b></td>
                                            <td style="color: blue;"><b>' . $row['Outward Points'] . '</b></td>
                                            <td>' . $row['Insurance Co'] . '</td>
                                            <td>' . $row['Details'] . '</td>
                                        </tr>';
            }
        
            $gridoutput .= '</tbody>
                            </table>';
        
            echo $gridoutput;
        }
        
    



?>