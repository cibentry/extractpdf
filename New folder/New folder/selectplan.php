<?php
include('db.php');
$segmenttype =$_POST['segmenttype'];

$sqlplan = "select * from plan_table where parent_id = '".$segmenttype."'";
$resultplan = mysqli_query($con,$sqlplan);

$outputplan = '<option>Select Plan</option>';

while($dataplan = mysqli_fetch_array($resultplan))
{
    $outputplan.="<option value='".$dataplan['plan'] ." '>". $dataplan['plan'] ."</option>";
}
echo $outputplan;

?>