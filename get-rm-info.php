<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');
session_start();

$searchby = $_POST['searchby'];
$searcrm = $_POST['searcrm'];


if (isset($_POST['searchby']) && isset($_POST['searcrm'])) {
    $searchby = $_POST['searchby'];
    $searcrm = $_POST['searcrm'];

    
        switch ($searchby) {

            case 1:
                $sqlsearch = "SELECT emp_id, name, email_id FROM newemp where name Like '%$searcrm%'";
                
                $result = mysqli_query($con, $sqlsearch);
                $output = '';
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $output .= '<tr>
                                        <td><a href="rmupdate.php?emp_id=' . $row['emp_id'] . '">' . $row['emp_id'] . '</a></td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['email_id'] . '</td>
                                        
                                    </tr>';


                    }
                } else {
                    $output .= '<tr><td colspan="6">No records found</td></tr>';
                }
                echo $output;

        }
    } else {
        echo "Error: Invalid form submission";
}
    
?>
