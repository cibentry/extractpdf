<?php
ini_set('session.gc_maxlifetime', 180); // 3 minutes
include('db.php');

session_start();

if (isset($_SESSION['last_entry_no'])) {
    // Output the last entry number
    echo "<script>alert('Last Entry Number: " . $_SESSION['last_entry_no'] . "');</script>";
    unset($_SESSION['last_entry_no']); // Clear the session variable after use
}
$zonequery = mysqli_query($con, "SELECT * FROM `newemp` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
$zonefetch = mysqli_fetch_array($zonequery);

$zonename = $zonefetch['mapped_zone'];
$zoneid = $zonefetch['mapped_zone_id'];




?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid m-auto mx-1 ">
        <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
            <div class="row">
                <div class="col-10 col-sm-6 col-md-10"><!-- header--to show loged in user->
                    <!--<h1>Hello, </h1>-->
                    <h1 class="head text-light">MANAGEMENT</h1>
                    <?php
                    require 'db.php';


                    $query = mysqli_query($con, "SELECT * FROM `newemp` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                    $fetch = mysqli_fetch_array($query);

                    echo "<h5 class='text-light mx-3 fw-bolder'>" . $fetch['name'] . "</h5>";
                    ?>
                </div>
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="logout.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">logout</a>
                </div>

            </div>
        </div>
        <div class="cont my-1"><!-- button to retun to home page ------>
            <div class="col-12 col-sm-6 col-md-1 ">
                <a href="franchaise.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                    aria-pressed="true">Dashboard</a>
            </div>
        </div>
        <div class="cont my-1 "><!----- Entry form starts -------->
            <div class="row">

            </div>
            <div class="col-sm-12 m-1 p-2 mx-auto">
                <form action="franchaisesavedata.php" method="post" enctype="multipart/form-data"
                    class="needs-validation was-validated">
                    <div class="row">
                        <h3 class="report bg-primary m-1 p-1 text-light">Business Entry</h3>
                    </div>
                    <div class="row"><!------- Agent Details ----->
                        <h3
                            class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                            Agent Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label class="form-control my-1">Entry Date</label>
                                    <input type="text" id="entrydate" name="entrydate" class="form-control my-1"
                                        value="<?php echo date("Y-m-d") ?>" required>
                                </div>
                                <div class="col-sm-4 m-1 p-2 ">
                                    <label class="form-control my-1">Manager
                                        Name</label><!-- textbox for managername--->
                                    <input type="text" id="managername" name="managername" class="form-control my-1"
                                        value="<?php echo $fetch['name']; ?>" readonly>
                                </div>
                                <div class="col-sm-4 m-1 p-2 ">
                                    <label class="form-control my-1">Agent Name</label><!-- Selectbox for agent name--->
                                    <select id="agent" name="agent" class="form-select my-1"
                                        onchange="selectagentcode()" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row"><!--- Display manager / agent details----->
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="rmname" class="form-control my-1">RM Name</label>
                                    <input type="text" class="form-control" id="RMname" name="rmname">
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="agentname" class="form-control my-1">Agent Name</label>
                                    <input type="text" class="form-control" id="Agentname" name="Agentname">
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="agentcode" class="form-control my-1">Agent Code</label>

                                    <input type="text" class="form-control" id="agentcode" name="agentcode">
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="agentrole" class="form-control my-1">Role</label>

                                    <input type="text" class="form-control" id="agentrole" name="agentrole">
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="nonposname" class="form-control my-1">Non POS Name</label>

                                    <input type="text" class="form-control" id="nonposname" name="nonposname">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                                Insured Details</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="col-sm-8 m-1 p-2 ">
                                    <label for="insuredname" class="form-control my-1">Insured Name</label>

                                    <input type="text" class="form-control" id="insuredname" name="insuredname"
                                        placeholder="Enter Insured Name" required>
                                </div>

                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="insuredno" class="form-control my-1">Insured No</label>

                                    <input type="text" class="form-control" id="insuredno" name="insuredno"
                                        placeholder="Enter Insured No" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                                Product / Plan Details</h3>
                        </div>
                        <div class="row"><!--- Product / Plan details ----->
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="producttype" class="form-control my-1">Product Type</label>
                                    <select id="producttype" name="producttype" class="form-select my-1"
                                        onchange="selectsubproducttype()" required>
                                        <option value="">Select Product</option>
                                        <?php
                                        $queryproduct = mysqli_query($con, "SELECT * FROM `product_table` ") or die(mysqli_error());
                                        while ($fetchproduct = mysqli_fetch_array($queryproduct)) {

                                            echo "<option value='" . $fetchproduct['id'] . "'>" . $fetchproduct['Product_type'] . "</option>";

                                            ?>
                                        <?php } ?>
                                    </select>

                                </div>

                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="subproducttype" class="form-control my-1">Sub Product Type</label>
                                    <select id="subproducttype" name="subproducttype" class="form-select my-1"
                                        onchange="selectsegmenttype()" required>
                                        <option value="">Select Sub Product</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="segmenttype" class="form-control my-1">Segment Type</label>
                                    <select id="segmenttype" name="segmenttype" class="form-select my-1"
                                        onchange="selectplan()" required>
                                        <option value="">Select Segment</option>
                                    </select>

                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="plan" class="form-control my-1">Plan</label>
                                    <select id="plan" name="plan" class="form-select my-1" required>
                                        <option value="">Select Plan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                                Vehicle Details</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="row">
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="insuranceco" class="form-control my-1">Insurance
                                            Company</label>
                                        <select id="insuranceco" name="insuranceco" class="form-select my-1" required>
                                            <option value="">Select Insurance Company</option>
                                            <?php
                                            $sqlinsuranceco = "select * from insurance_com";
                                            $resultinsuranceco = mysqli_query($con, $sqlinsuranceco);
                                            while ($datainsuranceco = mysqli_fetch_array($resultinsuranceco)) {
                                                echo "<option value = " . $datainsuranceco['insurer'] . ">" . $datainsuranceco['insurer'] . "</option>";
                                                ?>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="policyno" class="form-control my-1">Policy No</label>
                                        <input type="text" id="policyno" name="policyno" class="form-control my-1"
                                            required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <Label for="businesstype" class="form-control my-1">Business Type</Label>
                                        <select id="businesstype" name="businesstype" class="form-select my-1"
                                            onchange="rtocodechange()" required>
                                            <option value="">Select Business Type</option>
                                            <option value="New">New</option>
                                            <option value="Renewal">Renewal</option>
                                            <option value="Rollover">Rollover</option>
                                            <option value="Fresh">Fresh</option>
                                            <Option vlaue="Portability">Portability</option>
                                        </select>

                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="vehicleno" class="form-control my-1">Vehicle No</label>
                                        <input type="text" id="vehicleno" name="vehicleno" class="form-control my-1"
                                            onchange="vehiclenocheck()" required>
                                    </div>
                                    <div class="col-sm-1 m-1 p-2 ">
                                        <label for="rtocode" class="form-control my-1">Rto Code</label>
                                        <input type="text" id="rtocode" name="rtocode" class="form-control my-1"
                                            onchange="rtolocationchange()" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="rtolocation" class="form-control my-1">Rto Location</label>
                                        <input type="text" id="rtolocation" name="rtolocation" class="form-control my-1"
                                            required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 m-1 p-2 ">
                                        <label for="policyissudate" class="form-control my-1">Policy Issue
                                            Date</label>
                                        <input type="date" id="policyissudate" name="policyissudate"
                                            class="form-control my-1" title="YYYY-MM-DD"
                                            onchange="updateSelectedTexts()" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="rsd" class="form-control my-1">Risk Start Date
                                        </label>
                                        <input type="date" id="rsd" name="rsd" class="form-control my-1"
                                            title="YYYY-MM-DD" onchange="setred()" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="red" class="form-control my-1">Risk End Date
                                        </label>
                                        <input type="date" id="red" name="red" class="form-control my-1"
                                            title="YYYY-MM-DD" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="regdate" class="form-control my-1">Registration Date
                                        </label>
                                        <input type="date" id="regdate" name="regdate" class="form-control my-1"
                                            title="YYYY-MM-DD" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="age" class="form-control my-1">Age</label>
                                        <input type="text" id="age" name="age" class="form-control my-1" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="engineno" class="form-control my-1">Engine No</label>
                                        <input type="text" id="engineno" name="engineno" class="form-control my-1"
                                            required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="chassisno" class="form-control my-1">Chassis No</label>
                                        <input type="text" id="chassisno" name="chassisno" class="form-control my-1"
                                            required>
                                    </div>
                                    <div class="col-sm-3 m-1 p-2 ">
                                        <label for="vehiclemake" class="form-control my-1">Vehicle Make</label>
                                        <input type="text" id="vehiclemake" name="vehiclemake" class="form-control my-1"
                                            required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="vehiclemodel" class="form-control my-1">Vehicle
                                            Model</label>
                                        <input type="text" id="vehiclemodel" name="vehiclemodel"
                                            class="form-control my-1" required>
                                    </div>
                                    <div class="col-sm-2 m-1 p-2 ">
                                        <label for="fueltype" class="form-control my-1">Fuel Type</label>
                                        <select id="fueltype" name="fueltype" class="form-select my-1" required>
                                            <option value="">Select Fuel Type</option>
                                            <option value="Petrol">Petrol</option>
                                            <option value="Diesel">Diesel</option>
                                            <option value="CNG">CNG</option>
                                            <option value="Electric">Electric</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 m-1 p-2 ">
                                        <label for="gvwcc" class="form-control my-1">GVW/CC</label>
                                        <input type="text" id="gvwcc" name="gvwcc" class="form-control my-1" required>
                                    </div>
                                    <div class="col-sm-3 m-1 p-2 ">
                                        <label for="seatingcapacity" class="form-control my-1">Seating
                                            Capacity</label>
                                        <input type="text" id="seatingcapacity" name="seatingcapacity"
                                            class="form-control my-1" required>
                                    </div>
                                    <div class="col-sm-3 m-1 p-2 ">
                                        <label for="ncb" class="form-control my-1">NCB</label>
                                        <select id="ncb" name="ncb" class="form-select my-1" required>
                                            <option value="">Select NCB</option>
                                            <option value="0">0</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                            <option value="35">35</option>
                                            <option value="45">45</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                                Premium Details</h3>
                            <div class="row">
                                <div
                                    class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="grosspremium" class="form-control my-1">Gross Premium</label>
                                            <input type="text" id="grosspremium" name="grosspremium"
                                                class="form-control my-1" onchange="updateDateFields()" required>
                                        </div>
                                        <div class="col-sm-1 m-1 p-2"></div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="netpremium" class="form-control my-1">Net Premium</label>
                                            <input type="text" id="netpremium" name="netpremium"
                                                class="form-control my-1" required>
                                        </div>
                                        <div class="col-sm-1 m-1 p-2"></div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="commissionablepremium" class="form-control my-1">Commissionable
                                                Premium</label>
                                            <input type="text" id="commissionablepremium" name="commissionablepremium"
                                                class="form-control my-1" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="odpremium" class="form-control my-1">OD Premium</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="odpremium" name="odpremium" class="form-control my-1"
                                                value="0" onchange="calculateodpremium()" required>
                                        </div>
                                        <div class="col-sm-1  p-2 ">

                                        </div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="netpremium" class="form-control my-1">TP Premium</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="tppremium" name="tppremium" class="form-control my-1"
                                                value="0" onchange="calculatepremium()" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="addonpremium" class="form-control my-1">Addon Premium</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="addonpremium" name="addonpremium"
                                                class="form-control my-1" value="0" onchange="calculateodpremium()"
                                                required>
                                        </div>
                                        <div class="col-sm-1  p-2 ">

                                        </div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="cpapremium" class="form-control my-1">CPA Premium</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="cpapremium" name="cpapremium"
                                                class="form-control my-1" value="0" onchange="calculatepremium()"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 ">

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">

                                        </div>
                                        <div class="col-sm-1  p-2 ">

                                        </div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="llpremium" class="form-control my-1">LL Paid
                                                Driver/Cleaner</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="llpremium" name="llpremium" class="form-control my-1"
                                                value="0" onchange="calculatepremium()" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="totalodpremium" class="form-control my-1">Total OD
                                                Premium</label>
                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="totalodpremium" name="totalodpremium"
                                                class="form-control my-1" required>
                                        </div>
                                        <div class="col-sm-1  p-2 ">

                                        </div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="totaltppremium" class="form-control my-1">Total TP
                                                Premium</label>

                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="totaltppremium" name="totaltppremium"
                                                class="form-control my-1" onchange="calculatepremium()" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 "></div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="totalnetpremium" class="form-control my-1">Net
                                                Premium</label>
                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="totalnetpremium" name="totalnetpremium"
                                                class="form-control my-1" required>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2 "></div>
                                        <div class="col-sm-3 m-1 p-2 ">
                                            <label for="terrorismpremium" class="form-control my-1">Terrorism
                                                Premium</label>
                                        </div>
                                        <div class="col-sm-2 m-1 p-2 ">
                                            <input type="text" id="terrorismpremium" name="terrorismpremium"
                                                class="form-control my-1" required>
                                        </div>
                                        <div class="col-sm-3 m-1 p-3 fst-italic text-danger fw-bold">*For non-motor
                                            policy only</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                                Payment Details</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="row">

                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2">
                                            <label for="paymentmode" class="form-control my-1">Payment Mode</label>
                                        </div>
                                        <div class="col-sm-3 m-1 p-2">
                                            <select id="paymentmode" name="paymentmode" class="form-control" required>
                                                <option value="Online">Online</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Cutpay">Cutpay</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 m-1 p-1">
                                            <div id="cheque-no-container">
                                                <input type="text" id="cheque-no" name="cheque-no"
                                                    class="form-control my-1" placeholder="Enter Cheque No." required>
                                            </div>
                                        </div>

                                        <div class="col-sm-1 m-1 p-2">
                                            <label for="state" class="form-control my-1">State</label>
                                        </div>
                                        <div class="col-sm-2 m-1 p-2">
                                            <select name="state" id="state" class="form-control" required>
                                                <option value="">Select State</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="WestBengal">West Bengal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 m-1 p-2">
                                            <label for="payoutrequired" class="form-control my-1">Payout
                                                Required</label>
                                        </div>
                                        <div class="col-sm-3 m-1 p-2">
                                            <select id="payoutrequired" name="payoutrequired" class="form-control"
                                                required>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 m-1 p-2">
                                            <label for="poslocation" class="form-control my-1">POS Location</label>
                                        </div>
                                        <div class="col-sm-2 m-1 p-2">
                                            <input type="text" id="poslocation" name="poslocation"
                                                class="form-control my-1" required>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                                Payout Details</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-success bg-opacity-10 shadow-sm mx-1 ">
                                <div class="row">
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="odinward" class="form-control my-1 text-success">Franchaise OD
                                            Inward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="odinward" name="odinward"
                                            class="form-control my-1 text-success" required>
                                    </div>
                                    <div class="col-sm-3 m-2 p-2">

                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="odoutward" class="form-control my-1 text-success">Franchaise OD
                                            Outward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="odoutward" name="odoutward"
                                            class="form-control my-1 text-success" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="tpinward" class="form-control my-1 text-success">Franchaise TP
                                            Inward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="tpinward" name="tpinward"
                                            class="form-control my-1 text-success" required>
                                    </div>
                                    <div class="col-sm-3 m-2 p-2">

                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="tpoutward" class="form-control my-1">Franchaise TP Outward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="tpoutward" name="tpoutward" class="form-control my-1"
                                            required>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="netinward" class="form-control my-1">Franchaise Net Inward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="netinward" name="netinward" class="form-control my-1"
                                            required>
                                    </div>
                                    <div class="col-sm-3 m-2 p-2">

                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="netoutward" class="form-control my-1">Franchaise Net Outward</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="netoutward" name="netoutward" class="form-control my-1"
                                            required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                                Commission</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="row">
                                    <div class="col-sm-1 m-2 p-2">
                                        <input type="checkbox" id="margin-checkbox" name="margin-checkbox" value="1"
                                            class="form-check-input my-1 float-right" onclick="toggleMarginInput()">
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="incommission" class="form-control my-1">Franchaise Inward
                                            Point</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="incommission" class="form-control my-1"
                                            name="incommission" required>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <label for="outcommission" class="form-control my-1">Franchaise Outward
                                            Point</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="outcommission" class="form-control my-1"
                                            name="outcommission" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 m-2 p-2"> </div>
                                    <div class="col-sm-2 m-2 p-2">

                                        <label for="margin" class="form-control my-1">Franchaise Margin</label>
                                    </div>
                                    <div class="col-sm-2 m-2 p-2">
                                        <input type="text" id="margin" class="form-control my-1" name="margin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3
                                class="report bg-primary bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                                Remarks</h3>
                        </div>
                        <div class="row">
                            <div
                                class="row border border-danger rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                                <div class="row">
                                    <div class="col-sm-7 m-2 p-2">
                                        <textarea id="remarks" name="remarks" class="form-control my-1"
                                            required></textarea>
                                    </div>
                                    <div class="col-sm-3 m-2 p-2">
                                        <input type="text" id="zonename" name="zonename" class="form-control my-1"
                                            value="<?php echo $zonename; ?>" readonly>

                                    </div>
                                    <div class="col-sm-1 m-2 p-2">
                                        <input type="text" id="zonename" name="zoneid" class="form-control my-1"
                                            value="<?php echo $zoneid; ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-2 m-2 p-2">
                                            <label id="month" class="form-control my-1">Month</label>
                                        </div>
                                        <div class="col-sm-2 m-2 p-2">
                                            <input type="text" id="monthname" name="monthname" class="form-control my-1"
                                                readonly>
                                        </div>
                                        <div class="col-sm-2 m-2 p-2">
                                            <label id="year" class="form-control my-1">Financial Year</label>
                                        </div>
                                        <div class="col-sm-2 m-2 p-2">
                                            <input type="text" id="fiscalyear" name="fiscalyear"
                                                class="form-control my-1" readonly>
                                        </div>
                                        <div class="col-sm-1 m-2 p-2">
                                            <input type="text" id="bookstatus" name="bookstatus"
                                                class="form-control my-1" readonly>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 m-2 p-2 mb-2">
                                            <label for="pdf_file" class="form-label">Upload Policy</label>
                                            <input class="form-control form-control-sm" id="pdf_file" type="file"
                                                name="pdf_file" accept="application/pdf" onchange="validatePDF(this)"
                                                required>
                                            <p id="error-message"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 m-2 p-2">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                        </div>
                                        <input type="hidden" name="producttype_text" id="producttype_text">
                                        <input type="hidden" name="subproducttype_text" id="subproducttype_text">
                                        <input type="hidden" name="segmenttype_text" id="segmenttype_text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validatePDF(input) {
            var file = input.files[0];
            var fileType = file.type;
            var fileName = file.name;

            if (fileType !== 'application/pdf') {
                var errorMessage = document.getElementById('error-message');
                errorMessage.textContent = 'Only PDF files are allowed!';
                errorMessage.style.color = 'red';
                input.value = '';
            } else {
                var errorMessage = document.getElementById('error-message');
                errorMessage.textContent = '';
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            selectagent();  // Call the function to populate agents when the page loads
        });
        function selectagent() {
            var manager = $("#managername").val();

            $.ajax({
                url: "selectagent.php",
                type: "POST",
                data: {
                    manager: manager
                },
                success: function (data) {
                    $("#agent").html(data);

                }
            });
        }
    </script>
    <script>
        function selectagentcode() {
            var agent = $("#agent").val();
            $.ajax({
                url: "selectagentcode.php",
                type: "POST",
                data: {
                    agent: agent
                },
                success: function (response) {
                    //console.log(response); 
                    try {
                        var responsedata = JSON.parse(response);
                    }
                    catch (error) {
                        console.error("Error parsing response:", error);
                    }
                    var responseData = JSON.parse(response);

                    $("#RMname").val(responseData.rmn);
                    $("#Agentname").val(responseData.uname);
                    $("#agentcode").val(responseData.posid);
                    $("#agentrole").val(responseData.orgrole);
                    $("#nonposname").val(responseData.npos);
                    //alert(#Agentname);
                }

            });
        }
    </script>
    <script>
        function selectsubproducttype() {
            var producttype = $("#producttype").val();
            // alert(producttype);
            $.ajax({
                url: "selectsubproducttype.php",
                type: "POST",
                data: {
                    producttype: producttype
                },
                success: function (data) {

                    $("#subproducttype").html(data);

                }
            });
        }
    </script>

    <script>
        function selectsegmenttype() {
            var subproducttype = $("#subproducttype").val();
            //alert(subproducttype);
            $.ajax({
                url: "selectsegmenttype.php",
                type: "POST",
                data: {
                    subproducttype: subproducttype
                },
                success: function (data) {
                    $("#segmenttype").html(data);
                }
            });
        }
    </script>

    <script>
        function selectplan() {
            var segmenttype = $("#segmenttype").val();
            //alert("segnmenttype" + segmenttype);
            $.ajax({
                url: "selectplan.php",
                type: "POST",
                data: {
                    segmenttype: segmenttype
                },
                success: function (data) {
                    $("#plan").html(data);
                }
            });
        }
    </script>
    <script>

        $("#businesstype").on("change", function () {
            if ($(this).val() == "New") {
                $("#vehicleno").val("new");
            }
        });
        function rtocodechange() {
            $("#businesstype").trigger('change');
        }
    </script>
    <script>
        function rtolocationchange() {
            var rtocode = $("#rtocode").val();
            //alert(rtocode);
            $.ajax({
                url: "selectrtolocation.php",
                type: "POST",
                data: {
                    rtocode: rtocode
                },
                success: function (data) {
                    $("#rtolocation").val(data);
                    alert("RTO Location" + data);
                }
            });
        }
    </script>
    <script>
        function updateSelectedTexts() {
            // Get selected texts
            var productTypeText = document.getElementById("producttype").options[document.getElementById("producttype").selectedIndex].text;
            var subProductTypeText = document.getElementById("subproducttype").options[document.getElementById("subproducttype").selectedIndex].text;
            var segmentTypeText = document.getElementById("segmenttype").options[document.getElementById("segmenttype").selectedIndex].text;
            var planNameText = document.getElementById("plan").options[document.getElementById("plan").selectedIndex].text;
            // Set hidden input values
            document.getElementById("producttype_text").value = productTypeText;
            document.getElementById("subproducttype_text").value = subProductTypeText;
            document.getElementById("segmenttype_text").value = segmentTypeText;
            document.getElementById("planname_text").value = planNameText;
            //alert(producttype_text.value); // Check if the value is set correctly
            //alert(subproducttype_text.value); // Check if the value is set correctly
            //alert(segmenttype_text.value); // Check if the value is set correctly
        }
    </script>
    <script>
        function setred() {
            var rsdValue = document.getElementById("rsd").value;
            var dateParts = rsdValue.split("-");
            var date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            var newDate = new Date(date.getTime() + 364 * 24 * 60 * 60 * 1000);
            var newDateStr = newDate.getFullYear() + "-" + (newDate.getMonth() + 1).toString().padStart(2, "0") + "-" + newDate.getDate().toString().padStart(2, "0");
            document.getElementById("red").value = newDateStr;
        }

        document.getElementById("regdate").addEventListener("input", calculateAge);

    </script>
    <script>
        function calculateodpremium() {
            var odprem = parseFloat(document.getElementById("odpremium").value);
            var adprem = parseFloat(document.getElementById("addonpremium").value);


            var totalodprem = odprem + adprem;

            document.getElementById("totalodpremium").value = totalodprem;
        }
    </script>

    <script>
        function calculatepremium() {

            var netprem = parseFloat(document.getElementById("tppremium").value);
            var cpaprem = parseFloat(document.getElementById("cpapremium").value);
            var llprem = parseFloat(document.getElementById("llpremium").value);
            //alert("net premium"+ netprem);
            //alert("cpa premium"+ cpaprem);
            //alert("ll premium"+ llprem);
            var totalnetprem = netprem + cpaprem + llprem;

            document.getElementById("totaltppremium").value = totalnetprem;

            var odprem = parseFloat(document.getElementById("odpremium").value);
            var adprem = parseFloat(document.getElementById("addonpremium").value);


            //var totalodprem = odprem + adprem;

            var odpremium = parseFloat(document.getElementById("totalodpremium").value);
            console.log(odpremium);

            var netpremium = odpremium + totalnetprem;

            //console.log(odpremium + document.getElementById("tppremium"));

            document.getElementById("totalnetpremium").value = netpremium;

        }

    </script>
    <script>
        function toggleMarginInput() {

            var commissionablepremium = document.getElementById("commissionablepremium");
            var totalodpremium = document.getElementById("totalodpremium");
            var totaltppremium = document.getElementById("totaltppremium");
            var odinward = document.getElementById("odinward").value;
            var tpinward = document.getElementById("tpinward").value;
            var netinward = document.getElementById("netinward").value;
            var odoutward = document.getElementById("odoutward").value;
            var tpoutward = document.getElementById("tpoutward").value;
            var netoutward = document.getElementById("netoutward").value;
            var totalod = document.getElementById("totalodpremium").value;
            var totaltp = document.getElementById("totaltppremium").value;
            var net = document.getElementById("netpremium").value;
            //var producttype = document.getElementById("producttype");
            //var selectedproduct = producttype.options[producttype.selectedIndex].text;
            //var plan = document.getElementById("plan");
            //var selectedplan = plan.options[plan.selectedIndex].text;
            //alert(selectedproduct);

            if (odinward != 0 && tpinward != 0) {

                var inwardcommission = (totalodpremium.value * (odinward / 100)) + (totaltppremium.value * (tpinward / 100));
                var outwardcommission = (totalodpremium.value * (odoutward / 100)) + (totaltppremium.value * (tpoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);

            } else if (odinward != 0 && tpinward == 0) {
                var inwardcommission = (totalodpremium.value * (odinward / 100));
                var outwardcommission = (totalodpremium.value * (odoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            } else if (odinward == 0 && tpinward != 0) {
                var inwardcommission = (totaltppremium.value * (tpinward / 100));
                var outwardcommission = (totaltppremium.value * (tpoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            } else {
                var inwardcommission = (net * (netinward / 100));
                var outwardcommission = (net * (netoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            }
        }
    </script>
    <script>
        function validateinput() {
            //alert("1");
            var insurername = document.getElementById("insuranceco").value;
            var planname = document.getElementById("plan").value;
            var productDropdown = document.getElementById("producttype"); // Reference the select element, not its value
            var selectedText = productDropdown.options[productDropdown.selectedIndex].text; // Get the selected option's text
            //alert("Product is " + selectedText + ", plan is " + planname);
            var insurancename = document.getElementById("insuranceco");
            vars selectedco = productDropdown.options[productDropdown.selectedIndex].text;
            if (selectedco != "Future Generali" AND selectedco != "National Insurance" AND selectedco != "Oriental"
                AND selectedco != "The New India Assurance" AND selectedco 1 = "United India" AND planname != "Comprehensive (1 OD + 1 TP)"
            document.getElementById("odoutward").value = "0";
            alert("For Product " + selectedText + " and Plan " + planname + "and Insurance Co. " + selectedco + " OD Outward is not applicable");
            ) else if (selectedText != "Four Wheeler" && planname != "Own Damage (1 OD)") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            }
            else if (selectedText != "Four Wheeler" && planname != "Four wheeler Bundled (1 OD + 3 TP)") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            }
            else if (selectedText != "Two Wheeler" && planname != "Own Damage (1 OD)") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            } else if (selectedText != "Four Wheeler" && planname != "Comprehensive (1 OD + 1 TP)") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            } else if (selectedText != "Commercial Vehicle" && planname != "Comprehensive (1 OD + 1 TP)" && insurername != "Future Generali") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            } else if (planname == "Third Party (1 TP)") {
                document.getElementById("odoutward").value = "0";
                alert("For Product " + selectedText + " and Plan " + planname + " OD Outward is not applicable");
            }
        }
        //planname == "Own Damage (1 OD)"
        //productname != "Two Wheeler"
        //&& planname != "Comprehensive (1 OD + 1 TP)"
    </script>
    <script>
        function calculateAge() {
            var regDate = document.getElementById("regdate").value;
            var regDateParts = regDate.split("-");
            var regDateObj = new Date(regDateParts[0], regDateParts[1] - 1, regDateParts[2]);
            var today = new Date();
            var ageInMonths = (today.getFullYear() - regDateObj.getFullYear()) * 12 + today.getMonth() - regDateObj.getMonth();
            var years = Math.floor(ageInMonths / 12);
            var months = ageInMonths % 12;
            document.getElementById("age").value = years + " Y-" + months + " M";
        }

        document.getElementById("regdate").addEventListener("blur", function () {
            if (this.value.length === 10) { // check if the date is complete
                calculateAge();
            }
        });
    </script>

    <script>
        function setred() {
            var rsdValue = document.getElementById("rsd").value;
            var dateParts = rsdValue.split("-");
            var date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            var newDate = new Date(date.getTime() + 364 * 24 * 60 * 60 * 1000);
            var newDateStr = newDate.getFullYear() + "-" + (newDate.getMonth() + 1).toString().padStart(2, "0") + "-" + newDate.getDate().toString().padStart(2, "0");
            document.getElementById("red").value = newDateStr;
        }

        document.getElementById("regdate").addEventListener("input", calculateAge);

    </script>
    <script>
        function getMonthWords(monthValue) {
            var monthWords = "";
            switch (monthValue) {
                case "01": monthWords = "January"; break;
                case "02": monthWords = "February"; break;
                case "03": monthWords = "March"; break;
                case "04": monthWords = "April"; break;
                case "05": monthWords = "May"; break;
                case "06": monthWords = "June"; break;
                case "07": monthWords = "July"; break;
                case "08": monthWords = "August"; break;
                case "09": monthWords = "September"; break;
                case "10": monthWords = "October"; break;
                case "11": monthWords = "November"; break;
                case "12": monthWords = "December"; break;
                default: monthWords = ""; // Handle invalid input
            }
            return monthWords;
        }

        // Function to update the month name and fiscal year based on the entry date (policy issue date)
        function updateDateFields() {
            // Get the date value from the policy issue date textbox
            var dateValue = document.getElementById("policyissudate").value;

            // Check if dateValue is valid and non-empty
            if (dateValue) {
                // Split the date value into parts (assuming format YYYY-MM-DD)
                var dateParts = dateValue.split("-");

                // Ensure dateParts has at least 3 parts (YYYY, MM, DD)
                if (dateParts.length === 3) {
                    // Get the month value (MM) and year value (YYYY)
                    var monthValue = dateParts[1];
                    var yearValue = parseInt(dateParts[0], 10);

                    // Convert the month value to words
                    var monthWords = getMonthWords(monthValue);
                    document.getElementById("monthname").value = monthWords; // Use value to set input field

                    // Calculate financial year
                    var fiscalYear;
                    if (monthValue >= "04") { // From April onwards
                        fiscalYear = yearValue + "-" + (yearValue + 1).toString().slice(-2); // e.g., 2024-25
                    } else { // Before April
                        fiscalYear = (yearValue - 1) + "-" + yearValue.toString().slice(-2); // e.g., 2023-24
                    }
                    document.getElementById("fiscalyear").value = fiscalYear; // Set the fiscal year textbox
                } else {
                    // If date is not in expected format, clear the monthname and fiscalyear fields
                    document.getElementById("monthname").value = "";
                    document.getElementById("fiscalyear").value = "";
                }
            }
        }

    </script>
    <script>
        // Function to update selected texts and monthname based on policy issue date
            function updateSelectedTexts() {
            // Get selected texts
            var productTypeText = document.getElementById("producttype").options[document.getElementById("producttype").selectedIndex].text;
            var subProductTypeText = document.getElementById("subproducttype").options[document.getElementById("subproducttype").selectedIndex].text;
            var segmentTypeText = document.getElementById("segmenttype").options[document.getElementById("segmenttype").selectedIndex].text;
            var planNameText = document.getElementById("plan").options[document.getElementById("plan").selectedIndex].text;

            // Set hidden input values
            document.getElementById("producttype_text").value = productTypeText;
            document.getElementById("subproducttype_text").value = subProductTypeText;
            document.getElementById("segmenttype_text").value = segmentTypeText;
            document.getElementById("planname_text").value = planNameText;

            // Update the month textbox based on entry date

        }


    </script>
    <script>
            // Get the input fields
            var vehicleNo = document.getElementById('vehicleno');
            var engineNo = document.getElementById('engineno');
            var chassisNo = document.getElementById('chassisno');
            var policyNo = document.getElementById('policyno');

            // Add an event listener to the chassis no input field
            chassisNo.addEventListener('change', function () {
                console.log('Chassis no changed');
            // Get the values of the input fields
            var vehicleNoValue = vehicleNo.value;
            var engineNoValue = engineNo.value;
            var chassisNoValue = this.value;
            var policyNoValue = policyNo.value;

            console.log('Values:', vehicleNoValue, engineNoValue, chassisNoValue, policyNoValue);

            // Make an AJAX request to check if any of the values already exist
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check-values.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                console.log('Response:', xhr.responseText);
            if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
            if (response.exists) {
                console.log('Entry exists');
            // Get the RSD from the database
            var rsdValue = response.rsd;

            // Calculate the difference between the current date and the RSD
            var currentDate = new Date();
            var rsdDate = new Date(rsdValue);
            var diffDays = Math.round((currentDate - rsdDate) / (1000 * 60 * 60 * 24));

                        // Check if the RSD is greater than or equal to 330 days from the current date
                        if (diffDays >= 330) {
                console.log('Entry allowed');
                        } else {
                console.log('Entry not allowed');
            alert('Entry exists with our_entry_no: ' + response.entryNo + ' and RSD: ' + rsdValue);


                        }
                    } else {
                console.log('No entry exists');
                    }
                }
            };
            xhr.send('vehicleNo=' + vehicleNoValue + '&engineNo=' + engineNoValue + '&chassisNo=' + chassisNoValue + '&policyNo=' + policyNoValue);
        });
    </script>
    <script>
            // Set the inactivity timeout (3 minutes in this example)
            const inactivityTimeout = 5 * 60 * 1000; // 3 minutes

            // Set the timer
            let timer = setTimeout(logout, inactivityTimeout);

            // Function to track user activity
            function trackActivity() {
                // Reset the timer
                clearTimeout(timer);
            timer = setTimeout(logout, inactivityTimeout);
        }

            // Add event listeners to track user activity
            document.addEventListener('click', trackActivity);
            document.addEventListener('keydown', trackActivity);
            document.addEventListener('scroll', trackActivity);

            // Function to log out the user
            function logout() {
                // Send an AJAX request to log out the user
                $.ajax({
                    type: 'POST',
                    url: 'logout.php',
                    success: function () {
                        console.log('Logged out due to inactivity');
                        window.location.replace('logout.php'); // Replace current page with logout.php
                    }
                });
        }
    </script>

</body>

</html>