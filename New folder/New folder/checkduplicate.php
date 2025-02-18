<?php
include('db.php');
session_start();

$agentname = $_POST['agentname'];
$agentcode = $_POST['agentcode'];

$checksql = "SELECT COUNT(*) FROM agent_table WHERE Username = '$agentname' AND POSP_ID = '$agentcode'";
$checkquery = mysqli_query($con, $checksql);

echo(mysqli_num_rows($checkquery));

if (mysqli_num_rows($checkquery) > 0) {
    echo 1;
} else {
    echo 0;
}
?>
