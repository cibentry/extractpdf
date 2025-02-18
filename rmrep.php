<?php
include('db.php');
session_start();
                            $zonequery = "SELECT mapped_zone_id FROM `newemp` WHERE `name`='$_SESSION[username]'";
                            $zoneresult = mysqli_query($con, $zonequery) or die(mysqli_error());
                            $zonerow = mysqli_fetch_array($zoneresult); 
                            if($zonerow > 0){
                                $zoneid = $zonerow['mapped_zone_id'];
                            }

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

                            $sqldisplay = "SELECT 
                            sm_name, 
                            SUM(CASE WHEN product_type = 'Four Wheeler' THEN net_premium ELSE 0 END) as PVT, 
                            SUM(CASE WHEN product_type = 'Two Wheeler' THEN net_premium ELSE 0 END) as Two_Wheeler, 
                            SUM(CASE WHEN product_type = 'Commercial Vehicle' THEN net_premium ELSE 0 END) as Commercial_vehicle, 
                            SUM(CASE WHEN product_type = 'Health' THEN net_premium ELSE 0 END) as Health,
                            SUM(net_premium) AS Total_Premuim
                            SUM(CASE WHEN entry_date = '$currentDate' THEN net_premium ELSE 0 END) AS ftd,
                            SUM(CASE WHEN month_name = '$monthName' THEN net_premium ELSE 0 END) AS mtd
                            FROM 
                            daily_booking 
                            WHERE
                            month_name = '$monthName' AND mapped_zone_id = '$zoneid'
                            GROUP BY 
                            sm_name
                            ORDER BY 
                            Total_Premuim DESC;";
                            $sqlresult = $con->query($sqldisplay); //echo $sqldisplay;
                            $disrow = mysqli_num_rows($sqlresult);
                            if($disrow > 0){
                                echo "<table class='table table-hover text-center table-danger bg-gradient bg-opacity-10 shadow-sm m-auto'>";
                                echo "<tr>";
                                echo "<th>SM Name</th>";
                                echo "<th>PVT</th>";
                                echo "<th>Two Wheeler</th>";
                                echo "<th>Commercial Vehicle</th>";
                                echo "<th>Health</th>";
                                echo "<th>Total Premium</th>";
                                echo "<th>F-T-D</th>";
                                echo "<th>M-T-D</th>";
                                echo "</tr>";
                                while($row = mysqli_fetch_assoc($sqlresult)){
                                    echo "<tr>
                                        <td>".htmlspecialchars($row['sm_name'])."</td>
                                        <td>".htmlspecialchars($row['PVT'])."</td>
                                        <td>".htmlspecialchars($row['Two_Wheeler'])."</td>
                                        <td>".htmlspecialchars($row['Commercial_vehicle'])."</td>
                                        <td>".htmlspecialchars($row['Health'])."</td>
                                        <td style='font-weight: bold;'>".htmlspecialchars($row['Total_Premuim'])."</td>
                                        <td style='font-weight: bold;>".htmlspecialchars($row['Total_Current_Entry_Date'])."</td>
                                        <td style='font-weight: bold;>".htmlspecialchars($row['Total_Current_Month'])."</td>
                                        </tr>";

                                }
                                echo "</table>";

                            }else{
                                echo "No Record Found";
                            }
                    ?>