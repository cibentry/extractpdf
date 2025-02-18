
<?php
include('db.php');
$designationn = $_POST['designationn'];

    $queryaccess = "SELECT access_id FROM designation_list WHERE designation ='$designationn'";
    $degresult = mysqli_query($con,$queryaccess);

    $accessoutput = '';
    while($accid = mysqli_fetch_array($degresult)){
        $accessoutput = $accid['access_id'];

    }
    echo($accessoutput);
?>