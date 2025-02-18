<?php
include('db.php');
session_start();
echo("1");
if (isset($_POST['submit'])) {
    var_dump($_POST);
    // Collecting and sanitizing input data
    $agentname = strip_tags($_POST['agentname']);
    $agentcode = strip_tags($_POST['agentcode']);
    $emailid = strip_tags($_POST['emailid']); // Corrected this line
    $rmname = strip_tags($_POST['rmname']);
    $rmnumber = strip_tags($_POST['rmnumber']);
    $orgroll = strip_tags($_POST['orgroll']);

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO agent_table (POSP_ID, Organisation_Role, Username, Email_ID, RM_Name, Contact) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind the parameters
    $stmt->bind_param("ssssss", $agentcode, $orgroll, $agentname, $emailid, $rmname, $rmnumber);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        echo("1");
        $_SESSION['success'] = "Agent created successfully";
        header("Location: agentcreation.php");
    } else {
        $_SESSION['error'] = "Error creating agent: " . $stmt->error; // Use $stmt->error instead of mysqli_error($con)
        header("Location: agentcreation.php");
    }

    // Close the statement
    $stmt->close();
}
?>
