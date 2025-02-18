<?php
include('db.php');
session_start();

if(isset($_POST['submit']))
{
    $entryDateLabel = $dom->getElementById('entrydate');
$dateStr = $entryDateLabel->nodeValue;
$dateParts = explode('-', $dateStr);
$monthNum = (int)$dateParts[1];
$monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$monthName = $monthNames[$monthNum - 1];
echo "<div class='popup'>Month Name: $monthName</div>";
die();

    
}
?>