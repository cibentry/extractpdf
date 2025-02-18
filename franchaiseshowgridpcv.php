<?php

include('db.php');
session_start();
$vehicle = $_POST['vehicle'];
$state = $_POST['state'];
$policy = $_POST['policy'];
$str = $_POST['str'];
$insurer = $_POST['insurer'];
$age = $_POST['age'];

        if ($insurer == 'ALL') {
            $gridquery = "SELECT 
                final_out_franchaise AS 'Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ' ', Sub_varient, ', ', Cluster, ',',
                        'Policy Type:', COALESCE(Policy_Type, ''), ',',
                    'Make-Model: ',  COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                       'RTO: ', COALESCE(RTO_Remarks, ''), ',',
                       'Fuel: ', COALESCE(Fuel, ''), ',',
                       'Discount: ', COALESCE(Discount, ''), ',',
                       'S-Cap: ', COALESCE(Lower_SC, ''), '-', COALESCE(Upper_SC, ''), ',',
                       'Age: ', COALESCE(Lower_Age, ''), '-', COALESCE(Upper_Age, ''), ',',
                        'Effective From:',DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_pcv
             WHERE State_Name = '$state'
               AND (
               ($str BETWEEN Lower_sc AND Upper_sc)
               OR (Lower_sc IS NOT NULL AND Upper_sc IS NOT NULL AND $str BETWEEN lower_sc AND upper_sc)
               OR (Lower_sc IS NOT NULL AND Upper_sc IS NULL AND $str >= Lower_sc)
               OR (Lower_sc IS NULL AND Upper_sc IS NOT NULL AND $str <= Upper_sc)
               OR (Lower_sc IS NULL AND Upper_sc IS NULL)
               )
               AND (
                   ($age BETWEEN Lower_Age AND Upper_Age) 
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NULL)
               )
               AND Our_Segment = '$vehicle'
               AND Policy_Type = '$policy'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
             ORDER BY final_out_franchaise DESC";
        
        } else {
            $gridquery = "SELECT 
                final_out_franchaise AS 'Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ' ', Sub_varient, ', ', Cluster, ',',
                        'Policy Type:', COALESCE(Policy_Type, ''), ',',
                    'Make-Model: ',  COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                       'RTO: ', COALESCE(RTO_Remarks, ''), ',',
                       'Fuel: ', COALESCE(Fuel, ''), ',',
                       'Discount: ', COALESCE(Discount, ''), ',',
                       'Age: ', COALESCE(Lower_Age, ''), '-', COALESCE(Upper_Age, ''), ',',
                        'Effective From: ',DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_pcv
             WHERE State_Name = '$state'
               AND (
               ($str BETWEEN Lower_sc AND Upper_sc)
               OR (Lower_sc IS NOT NULL AND Upper_sc IS NOT NULL AND $str BETWEEN lower_sc AND upper_sc)
               OR (Lower_sc IS NOT NULL AND Upper_sc IS NULL AND $str >= Lower_sc)
               OR (Lower_sc IS NULL AND Upper_sc IS NOT NULL AND $str <= Upper_sc)
               OR (Lower_sc IS NULL AND Upper_sc IS NULL)
               )
               AND (
                   ($age BETWEEN Lower_Age AND Upper_Age) 
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NULL)
               )
               AND Our_Segment = '$vehicle'
               AND Policy_Type = '$policy'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
               AND Insurance_Co = '$insurer'
             ORDER BY final_out_franchaise DESC";
        }       
        $gridresult = $con->query($gridquery);              
        if ($gridresult->num_rows > 0) {
            $vehicleType = $vehicle;
            $currentDate = date('d-m-Y');
            $gridoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Search Results for ' . $vehicleType . ' | State: ' . $state . ' | Policy: ' . $policy . ' | 
                S-capacity: ' . $str . ' | Age: ' . $age . ' | Date: ' . $currentDate . '
            </p2>
            <table class="table table-striped" id="gridtable">
                    <thead>
                        <tr>
                            <th>Final Output</th>
                            <th>Insurance Co</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        
            while ($row = $gridresult->fetch_assoc()) {
                $gridoutput .= '<tr>
                                    <td>' . $row['Points'] . '</td>
                                    <td>' . $row['Insurance Co'] . '</td>
                                    <td>' . $row['Details'] . '</td>
                                </tr>';
            }
        
            $gridoutput .= '</tbody>
                            </table>';
        
            echo $gridoutput;
        }
        
    



?>