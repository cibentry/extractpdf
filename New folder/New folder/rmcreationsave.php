<?php
include('db.php');
session_start();
echo("1");
if (isset($_POST['submit'])) {
    $employeename = strip_tags($_POST['empname']);
    $empdesignation = strip_tags($_POST['designationname']);
    $statename = strip_tags($_POST['statename']);
    $accessid = strip_tags($_POST['accessid']);
    $zonalid = strip_tags($_POST['zonalid']);
    $emailid = strip_tags($_POST['emailid']);
    $password = strip_tags($_POST['password']);

    $stmt = $con->prepare("INSERT INTO newemp (name, designation, zone, zonal_id, access_id, designation_id, email_id, password,
            mapped_zone, mapped_zone_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss",$employeename, $empdesignation, $statename, $zonalid, $accessid, $accessid, $emailid, $password,
          $statename, $zonalid);
          $result = $stmt->execute();
          if ($result) {
            echo("1");
            $_SESSION['success'] = "Employee created successfully";
            header("Location: rmcreation.php");
        } else {
            $_SESSION['error'] = "Error creating agent: " . $stmt->error; // Use $stmt->error instead of mysqli_error($con)
            header("Location: rmcreation.php");
        }
    
        // Close the statement
        $stmt->close();
    }
?>