<?php
include('db.php');
$producttype = $_POST['producttype'];


$sqlsubproduct = "select * from sub_product_table where parent_id = '".$producttype."'";
$resultsubproduct = mysqli_query($con,$sqlsubproduct);

$outputsubproduct = '<option>Select Sub Product</option>';

while($datasubproduct = mysqli_fetch_array($resultsubproduct)){
    $outputsubproduct.="<option value='".$datasubproduct['id'] ." '>".$datasubproduct['sub_product']."</option>";
}
echo $outputsubproduct;


?>