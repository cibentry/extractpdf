<?php
include('db.php');
$subproducttype =$_POST['subproducttype'];

$sqlsegment = "select * from segment_table where parent_id = '".$subproducttype."'";
$resultsegment = mysqli_query($con,$sqlsegment);

$outputsegment = '<option>Select Segment</option>';

while($datasegment = mysqli_fetch_array($resultsegment)){
    $outputsegment.="<option value='".$datasegment['id'] ." '>".$datasegment['segment']."</option>";
}
echo $outputsegment;
?>