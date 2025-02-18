<?php include('db.php');
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

if (isset($_POST['submit'])) {
    $pdffile = $_FILES['pdf_file'];
    $file_name = $pdffile['name'];
    $file_size = $pdffile['size'];
    $file_tmp = $pdffile['tmp_name'];
    $file_type = $_FILES['pdf_file']['type'];

    if ($file_type !== 'application/pdf') {
        echo 'Only PDF files are allowed!';
        exit;
    }

    // Save the file in the uploads directory
    $upload_dir = 'uploads/';
    $file_path = $upload_dir . $file_name;
    move_uploaded_file($file_tmp, $file_path);
    $_SESSION['message'] = 'File uploaded successfully!';

}
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    echo '<strong>Congratulation,</strong> ' . $_SESSION['message'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['message']); // Unset the session variable after displaying the message
}
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
                <div class="col-10 col-sm-6 col-md-10">
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
        <div class="cont my-1">
            <div class="col-12 col-sm-6 col-md-1 ">
                <a href="operations.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                    aria-pressed="true">Dashboard</a>
            </div>
        </div>
        <div class="cont my-1 ">
            <div class="row">

            </div>
            <div class="col-sm-12 m-1 p-2 mx-auto">
                <form action="savedata.php" method="post" enctype="multipart/form-data"
                    class="needs-validation was-validated">

                    <div class="row">
                        <!--<input type="file" name="pdf_file" accept="application/pdf" id="pdf_file_input"> -->
                        <input type="file" id="pdf_file_input" />
                        <div id="pdf-data"></div>
                    </div>

                    <div class="row">
                        <h3 class="report bg-primary m-1 p-1 text-light">Business Entry</h3>
                    </div>
                    <div class="row">
                        <h3
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                            Agent Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label class="form-control my-1">Entry Date</label>
                                    <input type="text" id="entrydate" name="entrydate" class="form-control my-1"
                                        value="<?php echo date("Y-m-d") ?>" required>
                                </div>
                                <div class="col-sm-4 m-1 p-2 ">
                                    <label class="form-control my-1">Manager Name</label>
                                    <select id="manager" name="manager" class="form-select my-1"
                                        onchange="selectagent()" required>
                                        <option value="">Select</option>
                                        <?php
                                        $query = mysqli_query($con, "SELECT RM_Name FROM `rm_list` ORDER BY RM_Name") or die(mysqli_error());
                                        while ($fetch = mysqli_fetch_array($query)) {

                                            echo "<option value='" . $fetch['RM_Name'] . "'>" . $fetch['RM_Name'] . "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 m-1 p-2 ">
                                    <label class="form-control my-1">Agent Name</label>
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
                    </div>
                    <div class="row">
                        <h3
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                            Insured Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
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
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                            Product / Plan Details</h3>
                    </div>
                    <div class="row"><!--- Product / Plan details ----->
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
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
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                            Vehicle Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
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
                                    <input type="text" id="policyno" name="policyno" class="form-control my-1" required>
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
                                    <input type="text" id="policyissudate" name="policyissudate"
                                        class="form-control my-1" title="YYYY-MM-DD" onchange="updateSelectedTexts()"
                                        required>
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="rsd" class="form-control my-1">Risk Start Date
                                    </label>
                                    <input type="text" id="rsd" name="rsd" class="form-control my-1" title="YYYY-MM-DD"
                                        onchange="setred()" required>
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="red" class="form-control my-1">Risk End Date
                                    </label>
                                    <input type="text" id="red" name="red" class="form-control my-1" title="YYYY-MM-DD"
                                        required>
                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <label for="regdate" class="form-control my-1">Registration Date
                                    </label>
                                    <input type="text" id="regdate" name="regdate" class="form-control my-1"
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
                                    <input type="text" id="engineno" name="engineno" class="form-control my-1" required>
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
                                    <input type="text" id="vehiclemodel" name="vehiclemodel" class="form-control my-1"
                                        required>
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
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                            Premium Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="grosspremium" class="form-control my-1">Gross Premium</label>
                                    <input type="text" id="grosspremium" name="grosspremium" class="form-control my-1"
                                        onchange="updateDateFields()" required>
                                </div>
                                <div class="col-sm-1 m-1 p-2"></div>
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="netpremium" class="form-control my-1">Net Premium</label>
                                    <input type="text" id="netpremium" name="netpremium" class="form-control my-1"
                                        required>
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
                                    <input type="text" id="addonpremium" name="addonpremium" class="form-control my-1"
                                        value="0" onchange="calculateodpremium()" required>
                                </div>
                                <div class="col-sm-1  p-2 ">

                                </div>
                                <div class="col-sm-3 m-1 p-2 ">
                                    <label for="cpapremium" class="form-control my-1">CPA Premium</label>

                                </div>
                                <div class="col-sm-2 m-1 p-2 ">
                                    <input type="text" id="cpapremium" name="cpapremium" class="form-control my-1"
                                        value="0" onchange="calculatepremium()" required>
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
                    <div class="row">
                        <h3
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                            Payment Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-3 m-1 p-2">
                                    <label for="paymentmode" class="form-control my-1">Payment Mode</label>
                                </div>
                                <div class="col-sm-3 m-1 p-2">
                                    <select id="paymentmode" name="paymentmode" class="form-control"
                                        onchange="checkagent()" required>
                                        <option value="Online">Online</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cut-pay">Cut-pay</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 m-1 p-1">
                                    <div id="cheque-no-container">
                                        <input type="text" id="cheque-no" name="cheque-no" class="form-control my-1"
                                            placeholder="Enter Cheque No." required>
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
                                    <label for="payoutrequired" class="form-control my-1">Payout Required</label>
                                </div>
                                <div class="col-sm-3 m-1 p-2">
                                    <select id="payoutrequired" name="payoutrequired" class="form-control" required>

                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 m-1 p-2">
                                    <label for="poslocation" class="form-control my-1">POS Location</label>
                                </div>
                                <div class="col-sm-2 m-1 p-2">
                                    <input type="text" id="poslocation" name="poslocation" class="form-control my-1"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                            Payout Details</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="odinward" class="form-control my-1 text'message">OD Inward</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="odinward" name="odinward"
                                        class="form-control my-1 text-success" required>
                                </div>
                                <div class="col-sm-3 m-2 p-2">

                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="odoutward" class="form-control my-1 text-success">OD Outward</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="odoutward" name="odoutward"
                                        class="form-control my-1 text-success" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="tpinward" class="form-control my-1 text-success">TP Inward</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="tpinward" name="tpinward"
                                        class="form-control my-1 text-success" required>
                                </div>
                                <div class="col-sm-3 m-2 p-2">

                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="tpoutward" class="form-control my-1">TP Outward</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="tpoutward" name="tpoutward" class="form-control my-1"
                                        required>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-2 m-2 p-2">
                                    <label for="netinward" class="form-control my-1">Net Inward</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="netinward" name="netinward" class="form-control my-1"
                                        required>
                                </div>
                                <div class="col-sm-3 m-2 p-2">

                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="netoutward" class="form-control my-1">Net Outward</label>
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
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">

                            Margin</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-1 m-2 p-2">
                                    <input type="checkbox" id="margin-checkbox" name="margin-checkbox" value="1"
                                        class="form-check-input my-1 float-right" onclick="toggleMarginInput()">
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="incommission" class="form-control my-1">Inward Point</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="incommission" class="form-control my-1" name="incommission"
                                        required>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <label for="outcommission" class="form-control my-1">Outward Point</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="outcommission" class="form-control my-1" name="outcommission"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 m-2 p-2"> </div>
                                <div class="col-sm-2 m-2 p-2">

                                    <label for="margin" class="form-control my-1">Margin</label>
                                </div>
                                <div class="col-sm-2 m-2 p-2">
                                    <input type="text" id="margin" class="form-control my-1" name="margin">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3
                            class="report bg-danger bg-gradient bg-opacity-50 shadow-sm m-1 p-1 text-light d-flex justify-content-center">
                            Remarks</h3>
                    </div>
                    <div class="row">
                        <div
                            class="row border border-danger rounded bg-danger bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                            <div class="row">
                                <div class="col-sm-7 m-2 p-2">
                                    <textarea id="remarks" name="remarks" class="form-control my-1" required></textarea>
                                </div>
                                <div class="col-sm-3 m-2 p-2">
                                    <input type="text" id="zonename" name="zonename" class="form-control my-1"
                                        value="<?php echo $zonename; ?>" readonly>

                                </div>
                                <div class="col-sm-1 m-2 p-2">
                                    <input type="text" id="zoneid" name="zoneid" class="form-control my-1"
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
                                        <input type="text" id="fiscalyear" name="fiscalyear" class="form-control my-1"
                                            readonly>
                                    </div>
                                    <div class="col-sm-1 m-2 p-2">
                                        <input type="text" id="bookstatus" name="bookstatus" class="form-control my-1"
                                            readonly>
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
                </form>
            </div>


        </div>





    </div>
    </form>
    </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('pdf_file_input').addEventListener('change', function () {
    var pdfFile = this.files[0];
    var formData = new FormData();
    formData.append('pdf_file', pdfFile);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'parse_pdf_and_extract.php', true);  // Point to the PHP script

    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.error) {
                alert(response.error);
            } else {
                // Display the extracted data
                document.getElementById('pdf-data').innerHTML = `
                    <h2>Extracted Data</h2>
                    <p>Insured Name: ${response.Name}</p>
                    <p>Address: ${response.Address}</p>
                    <p>Policy Number: ${response.Policy_Number}</p>
                    <p>Policy Period: ${response.Policy_Period}</p>
                `;
            }
        }
    };

    xhr.send(formData);
});
</script>


</body>

</html>