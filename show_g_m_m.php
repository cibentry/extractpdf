<?php

include('db.php');
session_start();

$state = $_POST['state'];
$policy = $_POST['policy'];
$insurer = $_POST['insurer'];
$age = $_POST['age'];
$miscd = $_POST['miscd'];
$month = $_POST['month'];

$currentmonth = date('F');
if ($currentmonth == $month){
        if ($insurer == 'ALL') {
            $gridquery = "SELECT 
                PO_final_in AS 'In-Points',
                final_out_posp AS 'Out-Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_miscd
             WHERE Vehicle_type = '$miscd'
             AND State_Name = '$state'
               AND (
                  ($age BETWEEN Lower_Age AND Upper_Age) 
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NULL)
              )
               AND Policy_Type = '$policy'
               AND Month = '$month'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
             ORDER BY final_out_posp DESC";
        
        } else {
            $gridquery = "SELECT 
                PO_final_in AS 'In-Points',
                final_out_posp AS 'Out-Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_miscd
            WHERE Vehicle_type = '$miscd'
             AND State_Name = '$state'
               AND (
                  ($age BETWEEN Lower_Age AND Upper_Age) 
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NULL)
              )
               AND Policy_Type = '$policy'
               AND Month = '$month'
               AND CURDATE() BETWEEN STR_TO_DATE(Effective_From, '%d-%m-%Y') AND STR_TO_DATE(Effective_To, '%d-%m-%Y')
               AND Insurance_Co = '$insurer'
             ORDER BY final_out_posp DESC";
        }
    }else{
        if ($insurer == 'ALL') {
            $gridquery = "SELECT 
                PO_final_in AS 'In-Points',
                final_out_posp AS 'Out-Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_miscd
             WHERE Vehicle_type = '$miscd'
             AND State_Name = '$state'
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
                PO_final_in AS 'In-Points',
                final_out_posp AS 'Out-Points',
                Insurance_Co AS 'Insurance Co',
                CONCAT(Our_Segment, ', ', Cluster, ',',
                        COALESCE(Make_Remarks, ''), ',',
                        COALESCE(Other_Remarks, ''), ',',
                        DATE_FORMAT(STR_TO_DATE(Effective_From, '%d-%m-%Y'), '%d-%m-%Y'), ' to ',
                        DATE_FORMAT(STR_TO_DATE(Effective_To, '%d-%m-%Y'), '%d-%m-%Y'), ',',
                        Month) AS 'Details'
            FROM grid_miscd
            WHERE Vehicle_type = '$miscd'
             AND State_Name = '$state'
               AND (
                  ($age BETWEEN Lower_Age AND Upper_Age) 
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NOT NULL AND $age BETWEEN Lower_Age AND Upper_Age)
                  OR (Lower_Age IS NOT NULL AND Upper_Age IS NULL AND $age >= Lower_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NOT NULL AND $age <= Upper_Age)
                  OR (Lower_Age IS NULL AND Upper_Age IS NULL)
              )
               AND Policy_Type = '$policy'
               AND Month = '$month'
               
               AND Insurance_Co = '$insurer'
             ORDER BY final_out_posp DESC";
        }
    }

        
        $gridresult = $con->query($gridquery);
        if ($gridresult->num_rows > 0) {
            
            $currentDate = date('d-m-Y');
            $gridoutput = '
            <p2 class="text-center mb-3 text-primary fw-bold">
                Search Results for Vehicle: '.$miscd.' | State: ' . $state . ' | Policy: ' . $policy . ' | 
                Age: ' . $age . ' | Date: ' . $currentDate . '
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
                                    <td>' . $row['In-Points'] . '</td>
                                    <td>' . $row['Out-Points'] . '</td>
                                    <td>' . $row['Insurance Co'] . '</td>
                                    <td>' . $row['Details'] . '</td>
                                </tr>';
            }
        
            $gridoutput .= '</tbody>
                            </table>';
        
            echo $gridoutput;
        }
        
?>