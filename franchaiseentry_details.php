<?php
// Include the database connection
include('db.php');
session_start();
if (isset($_GET['entry_no'])) {
$entry_no = $_GET['entry_no'];
// Retrieve the entry details from the database
$sql = "SELECT * FROM franchaise_booking WHERE entry_no = '$entry_no'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result); // Fetch the data as an associative array
} else {
    echo "No record found for ID: $entry_no";
    exit;
}
} else {
    echo "No ID provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-1">
        <h2>View Entry</h2>
        <form method="POST" action="update_entry.php?id=<?php echo $number; ?>">
            <div class="container-fluid m-auto mx-1 ">
                <div class="row border border-success rounded bg-success bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                    <div class="row"><!-- row starts -->
                        <!-- Entry Date -->
                        <div class="col-sm-2 mb-3">
                            <label for="entry_date" class="form-label">Entry Date</label>
                            <input type="date" class="form-control" id="entry_date" name="entry_date"
                                value="<?php echo htmlspecialchars($data['entry_date']); ?>" required>
                        </div>
                        <!-- Manager Name -->
                        <div class="col-sm-3 mb-3">
                            <label for="manager" class="form-label">Sold By</label>
                            <input type="text" class="form-control" id="manager" name="manager"
                                value="<?php echo htmlspecialchars($data['sold_by']); ?>" required>
                        </div>
                        <!-- POSP Name -->
                        <div class="col-sm-3 mb-3">
                            <label for="agentname" class="form-label">Agent Name</label>
                            <input type="text" class="form-control" id="agentname" name="agentname"
                                value="<?php echo htmlspecialchars($data['pos_name']); ?>" required>
                        </div>
                        <!-- POSP Code -->
                        <div class="col-sm-2 mb-3">
                            <label for="agentcode" class="form-label">Agent Code</label>
                            <input type="text" class="form-control" id="agentcode" name="agentcode"
                                value="<?php echo htmlspecialchars($data['pos_code']); ?>" required>
                        </div>
                        <!-- NON POSP Name -->
                        <div class="col-sm-2 mb-3">
                            <label for="nonposname" class="form-label">NON POSP Name</label>
                            <input type="text" class="form-control" id="nonposname" name="nonposname"
                                value="<?php echo htmlspecialchars($data['pos_code']); ?>" required>
                        </div>
                    </div> <!--- End of row ----->
                    <hr class="my-3 border-success">
                    <div class="row"><!-- row starts -->
                        <!-- Customer Name -->
                        <div class="col-sm-6 mb-3">
                            <label for="customername" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customername" name="customername"
                                value="<?php echo htmlspecialchars($data['customer_name']); ?>" required>
                        </div>
                        <!-- Customer Contact Number -->
                        <div class="col-sm-3 mb-3">
                            <label for="customernumber" class="form-label">Customer Contact Number</label>
                            <input type="text" class="form-control" id="customernumber" name="customernumber"
                                value="<?php echo htmlspecialchars($data['customer_contact_number']); ?>" required>
                        </div>

                        <!-- Entry Number -->
                        <div class="col-sm-3 mb-3">
                            <label for="entrynumber" class="form-label">Entry Number</label>
                            <input type="text" class="form-control" id="entrynumber" name="entrynumber"
                                value="<?php echo htmlspecialchars($data['entry_no']); ?>" readonly>
                        </div>
                    </div> <!--- End of row ----->
                    <hr class="my-3 border-success">
                    <div class="row"><!-- row starts -->
                        <!-- Product Type -->
                        <div class="col-sm-3 mb-3">
                            <label for="producttype" class="form-label">Product Type</label>
                            <input type="text" class="form-control" id="producttype" name="producttype"
                                value="<?php echo htmlspecialchars($data['product_type']); ?>" required>
                        </div>
                        <!-- Sub Product Type -->
                        <div class="col-sm-3 mb-3">
                            <label for="sub_product" class="form-label">Sub Product</label>
                            <input type="text" class="form-control" id="subproduct" name="subproduct"
                                value="<?php echo htmlspecialchars($data['sub_product']); ?>" required>
                        </div>
                        <!-- Segment Type -->
                        <div class="col-sm-3 mb-3">
                            <label for="segment" class="form-label">Segment</label>
                            <input type="text" class="form-control" id="segment" name="segment"
                                value="<?php echo htmlspecialchars($data['segment']); ?>" required>
                        </div>
                        <!-- Plan Type -->
                        <div class="col-sm-3 mb-3">
                            <label for="plan" class="form-label">Plan Name</label>
                            <input type="text" class="form-control" id="plan" name="plan"
                                value="<?php echo htmlspecialchars($data['plan_name']); ?>" required>
                        </div>
                    </div> <!--- End of row ----->
                    <div class="row"><!-- row starts -->
                        <!-- Insurance Co -->
                        <div class="col-sm-3 mb-3">
                            <label for="insurername" class="form-label">Insurance Co.</label>
                            <input type="text" class="form-control" id="insurername" name="insurername"
                                value="<?php echo htmlspecialchars($data['insurer']); ?>" required>
                        </div>

                        <!-- Policy no -->
                        <div class="col-sm-3 mb-3">
                            <label for="policyno" class="form-label">Policy No.</label>
                            <input type="text" class="form-control" id="policyno" name="policyno"
                                value="<?php echo htmlspecialchars($data['policy_no']); ?>" required>
                        </div>


                        <!-- Business Type -->
                        <div class="col-sm-3 mb-3">
                            <label for="businesstype" class="form-label">Business Type</label>
                            <input type="text" class="form-control" id="businesstype" name="businesstype"
                                value="<?php echo htmlspecialchars($data['business_type']); ?>" required>
                        </div>

                        <!-- Vehicle No -->
                        <div class="col-sm-3 mb-3">
                            <label for="vehicleno" class="form-label">Vehicle No.</label>
                            <input type="text" class="form-control" id="vehicleno" name="vehicleno"
                                value="<?php echo htmlspecialchars($data['vehicle_registration_no']); ?>" required>
                        </div>

                        <!-- RTO Code -->
                        <div class="col-sm-3 mb-3">
                            <label for="rtocode" class="form-label">RTO Code</label>
                            <input type="text" class="form-control" id="rtocode" name="rtocode"
                                value="<?php echo htmlspecialchars($data['rto_code']); ?>" required>
                        </div>

                        <!-- RTO Location -->
                        <div class="col-sm-3 mb-3">
                            <label for="rtolocation" class="form-label">RTO Location</label>
                            <input type="text" class="form-control" id="rtolocation" name="rtolocation"
                                value="<?php echo htmlspecialchars($data['rto_location']); ?>" required>
                        </div>

                        <!-- Issue Date -->
                        <div class="col-sm-3 mb-3">
                            <label for="issuedate" class="form-label">Issue Date</label>
                            <input type="date" class="form-control" id="issuedate" name="issuedate"
                                value="<?php echo htmlspecialchars($data['policy_sold_date']); ?>" required>
                        </div>

                        <!-- RSD -->
                        <div class="col-sm-3 mb-3">
                            <label for="rsd" class="form-label">Risk Start Date</label>
                            <input type="date" class="form-control" id="rsd" name="rsd"
                                value="<?php echo htmlspecialchars($data['policy_start_date']); ?>" required>
                        </div>

                        <!-- RED -->
                        <div class="col-sm-3 mb-3">
                            <label for="red" class="form-label">Risk End Date</label>
                            <input type="date" class="form-control" id="red" name="red"
                                value="<?php echo htmlspecialchars($data['policy_end_date']); ?>" required>
                        </div>

                        <!-- Registration Date -->
                        <div class="col-sm-3 mb-3">
                            <label for="registrationdate" class="form-label">Registration Date</label>
                            <input type="date" class="form-control" id="registrationdate" name="registrationdate"
                                value="<?php echo htmlspecialchars($data['date_of_registration']); ?>" required>
                        </div>

                        <!-- Age -->
                        <div class="col-sm-3 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="text" class="form-control" id="age" name="age"
                                value="<?php echo htmlspecialchars($data['age_of_the_vehicle']); ?>" required>
                        </div>

                        <!-- Engine -->
                        <div class="col-sm-3 mb-3">
                            <label for="engineno" class="form-label">Engine No.</label>
                            <input type="text" class="form-control" id="engineno" name="engineno"
                                value="<?php echo htmlspecialchars($data['engine_number']); ?>" required>
                        </div>

                        <!-- Chassis -->
                        <div class="col-sm-3 mb-3">
                            <label for="chassisno" class="form-label">Chassis No.</label>
                            <input type="text" class="form-control" id="chassisno" name="chassisno"
                                value="<?php echo htmlspecialchars($data['chassi_number']); ?>" required>
                        </div>

                        <!-- Make -->
                        <div class="col-sm-3 mb-3">
                            <label for="makename" class="form-label">Make</label>
                            <input type="text" class="form-control" id="makename" name="makename"
                                value="<?php echo htmlspecialchars($data['make']); ?>" required>
                        </div>

                        <!-- Model -->
                        <div class="col-sm-3 mb-3">
                            <label for="modelname" class="form-label">Model</label>
                            <input type="text" class="form-control" id="modelname" name="modelname"
                                value="<?php echo htmlspecialchars($data['model']); ?>" required>
                        </div>

                        <!-- Fuel -->
                        <div class="col-sm-3 mb-3">
                            <label for="fueltype" class="form-label">Fuel Type</label>
                            <input type="text" class="form-control" id="fueltype" name="fueltype"
                                value="<?php echo htmlspecialchars($data['fuel_type']); ?>" required>
                        </div>
                        <!-- gvwcc -->
                        <div class="col-sm-3 mb-3">
                            <label for="gvwcc" class="form-label">GVW/CC</label>
                            <input type="text" class="form-control" id="gvwcc" name="gvwcc"
                                value="<?php echo htmlspecialchars($data['gvw_cc']); ?>" required>
                        </div>
                        <!-- Seating Capacity -->
                        <div class="col-sm-3 mb-3">
                            <label for="seating" class="form-label">Seating Capacity</label>
                            <input type="text" class="form-control" id="seating" name="seating"
                                value="<?php echo htmlspecialchars($data['seating_capacity']); ?>" required>
                        </div>
                        <!-- NCB -->
                        <div class="col-sm-3 mb-3">
                            <label for="ncb" class="form-label">NCB</label>
                            <input type="text" class="form-control" id="ncb" name="ncb"
                                value="<?php echo htmlspecialchars($data['ncb']); ?>" required>
                        </div>
                    </div> <!--- End of row ----->
                    <hr class="my-3 border-success">
                    <div class="row"><!-- row starts -->
                        <!-- Gross Premium -->
                        <div class="col-sm-4 mb-3">
                            <label for="grosspremium" class="form-label">Gross Premium</label>
                            <input type="text" class="form-control" id="grosspremium" name="grosspremium"
                                value="<?php echo htmlspecialchars($data['total_premium']); ?>" required>
                        </div>

                        <!-- Net Premium -->
                        <div class="col-sm-4 mb-3">
                            <label for="netpremium" class="form-label">Net Premium</label>
                            <input type="text" class="form-control" id="netpremium" name="netpremium"
                                value="<?php echo htmlspecialchars($data['net_premium']); ?>" required>
                        </div>

                        <!-- Commissionable Premium -->
                        <div class="col-sm-4 mb-3">
                            <label for="commissionablepremium" class="form-label">Commissionable Premium</label>
                            <input type="text" class="form-control" id="commissionablepremium"
                                name="commissionablepremium"
                                value="<?php echo htmlspecialchars($data['commissionable_premium']); ?>" required>
                        </div>
                    </div> <!--- End of row ----->
                    <div class="row"><!--- Start of row ----->
                        <div class="col-sm-3 mb-3">
                            <!-- OD Premium -->
                            <label for="odpremium" class="form-label">Total OD Premium</label>
                            <input type="text" class="form-control" id="totalodpremium" name="totalodpremium"
                                value="<?php echo htmlspecialchars($data['od_premium']); ?>" required>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <!-- TP Premium -->
                            <label for="tppremium" class="form-label">Total TP Premium</label>
                            <input type="text" class="form-control" id="totaltppremium" name="totaltppremium"
                                value="<?php echo htmlspecialchars($data['tp_premium']); ?>" required>
                        </div>

                        <div class="col-sm-2 mb-3">
                            <!-- CPA Premium -->
                            <label for="cpapremium" class="form-label">CPA Premium</label>
                            <input type="text" class="form-control" id="cpapremium" name="cpapremium"
                                value="<?php echo htmlspecialchars($data['cpa_premium']); ?>" required>
                        </div>
                        <div class="col-sm-2 mb-3">
                            <!-- LL Premium -->
                            <label for="llpremium" class="form-label">LL Premium</label>
                            <input type="text" class="form-control" id="llpremium" name="llpremium"
                                value="<?php echo htmlspecialchars($data['ll_premium']); ?>" required>
                        </div>
                        <div class="col-sm-2 mb-3">
                            <!-- Terrorism Premium -->
                            <label for="terrorismpremium" class="form-label">Terrorism Premium</label>
                            <input type="text" class="form-control" id="terrorismpremium" name="terrorismpremium"
                                value="<?php echo htmlspecialchars($data['terrorism_premium']); ?>" required>

                        </div><!--- End of row ----->
                        <hr class="my-3 border-success">
                        <div class="row"><!--- Start of row ----->
                            <div class="col-sm-2 mb-3">
                                <!-- Payment Mode -->
                                <label for="paymentmode" class="form-label">Payment Mode</label>
                                <input type="text" class="form-control" id="paymentmode" name="paymentmode"
                                    value="<?php echo htmlspecialchars($data['payment_mode']); ?>" required>
                            </div>
                            <div class="col-sm-2 mb-3">
                                <!-- Cheque No -->
                                <label for="chequeno" class="form-label">Cheque No.</label>
                                <input type="text" class="form-control" id="chequeno" name="chequeno"
                                    value="<?php echo htmlspecialchars($data['cheque_number']); ?>" required>
                            </div>
                            <div class="col-sm-2 mb-3">
                                <!-- State -->
                                <label for="statename" class="form-label">State</label>
                                <input type="text" class="form-control" id="statename" name="statename"
                                    value="<?php echo htmlspecialchars($data['state_name']); ?>" required>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <!-- Payout Required -->
                                <label for="payoutrequired" class="form-label">Payout Required</label>
                                <input type="text" class="form-control" id="payoutrequired" name="payoutrequired"
                                    value="<?php echo htmlspecialchars($data['payout_required']); ?>" required>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <!-- Posp Location -->
                                <label for="poslocation" class="form-label">POSP Location</label>
                                <input type="text" class="form-control" id="poslocation" name="poslocation"
                                    value="<?php echo htmlspecialchars($data['location_name']); ?>" required>
                            </div>
                        </div><!--- End of row ----->
                        <hr class="my-3 border-success">
                        
                        <div class="row"><!--- Start of row ----->
                            <div class="col-sm-4 mb-3">
                                <!-- OD Inward -->
                                <label for="fodinward" class="form-label">Franchaise OD Inward</label>
                                <input type="text" class="form-control" id="fodinward" name="fodinward"
                                    value="<?php echo htmlspecialchars($data['franchaise_od_inward']); ?>" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <!-- TP Inward -->
                                <label for="ftpinward" class="form-label">Franchaise TP Inward</label>
                                <input type="text" class="form-control" id="ftpinward" name="ftpinward"
                                    value="<?php echo htmlspecialchars($data['franchaise_tp_inward']); ?>" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <!-- Net Inward -->
                                <label for="fnetinward" class="form-label">Franchaise Net Inward</label>
                                <input type="text" class="form-control" id="fnetinward" name="fnetinward"
                                    value="<?php echo htmlspecialchars($data['franchaise_net_inward']); ?>" required>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <!-- OD Outward -->
                                <label for="fodoutward" class="form-label">Franchaise OD Outward</label>
                                <input type="text" class="form-control" id="fodoutward" name="fodoutward"
                                    value="<?php echo htmlspecialchars($data['franchaise_od_outward']); ?>" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <!-- TP Outward -->
                                <label for="ftpoutward" class="form-label">Franchaise TP Outward</label>
                                <input type="text" class="form-control" id="ftpoutward" name="ftpoutward"
                                    value="<?php echo htmlspecialchars($data['franchaise_tp_outward']); ?>" required>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <!-- Net Outward -->
                                <label for="fnetoutward" class="form-label">Franchaise Net Outward</label>
                                <input type="text" class="form-control" id="fnetoutward" name="fnetoutward"
                                    value="<?php echo htmlspecialchars($data['franchaise_net_outward']); ?>" required>
                            </div>
                        </div><!--- End of row ----->

                        <hr class="my-3 border-success">
                        <div class="row"><!--- Start of row ----->
                        <div class="col-sm-3 mb-3">
                                <!-- Outward Point -->
                                <label for="outcommission" class="form-label">Franchaise In Point</label>
                                <input type="text" class="form-control" id="outcommission" name="outcommission"
                                    value="<?php echo htmlspecialchars($data['franchaise_inward_point']); ?>" required>
                            </div>

                            <div class="col-sm-3 mb-3">
                                <!-- Outward Point -->
                                <label for="outcommission" class="form-label">Franchaise Out Point</label>
                                <input type="text" class="form-control" id="outcommission" name="outcommission"
                                    value="<?php echo htmlspecialchars($data['franchaise_outward_point']); ?>" required>
                            </div>
                            
                        </div>
                    </div><!--- End of row ----->
                    <hr class="my-3 border-success">
                    <div class="row"><!--- start of row ----->
                        <div class="col-sm-4 mb-3">
                            <!-- Business Month -->
                            <label for="monthname" class="form-label">Month</label>
                            <input type="text" class="form-control" id="monthname" name="monthname"
                                value="<?php echo htmlspecialchars($data['month_name']); ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <!-- Financial Year -->
                            <label for="fyyear" class="form-label">Financial Year</label>
                            <input type="text" class="form-control" id="fyyear" name="fyyear"
                                value="<?php echo htmlspecialchars($data['f_year']); ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <!-- Booking Status -->
                            <label for="fyyear" class="form-label">Booking Status</label>
                            <select class="form-control" id="bookingstatus" name="bookingstatus" required>
                                <option value="">Select</option>
                                <option value="Booked" <?php echo ($data['booking_status'] == 'Booked') ? 'selected' : ''; ?>>Booked</option>
                                <option value="<?php echo htmlspecialchars($data['booking_status']); ?>" <?php echo ($data['booking_status'] != 'Booked') ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($data['booking_status']); ?>
                                </option>
                            </select>
                        </div>
                    </div><!--- End of row ----->
                    <hr class="my-3 border-success">
                    <div class="row"><!--- start of row ----->
                        <div class="col-sm-4 mb-3">
                            <!--- Mapped Zone ---->
                            <label for="mappedzone" class="form-label">Mapped Zone</label>
                            <input type="text" class="form-control" id="mappedzone" name="mappedzone"
                                value="<?php echo htmlspecialchars($data['mapped_zone']); ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <!--- Mapped Zone id --->
                            <label for="mappedzoneid" class="form-label">Mapped Zone ID</label>
                            <input type="text" class="form-control" id="mappedzoneid" name="mappedzoneid"
                                value="<?php echo htmlspecialchars($data['mapped_zone_id']); ?>" required>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <!--- Mapped Area ---->
                        </div>
                    </div><!--- End of row ----->
                    
                    <hr class="my-3 border-success">
                    <div class="row"><!--- start of row ----->
                        <div class="col-sm-8 mb-3">
                            <!-- Remarks -->
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control my-1"
                                value="<?php echo htmlspecialchars($data['remarks']); ?>" required></textarea>
                        </div>
                        <div class="col-sm-2 mb-3"></div>
                        <div class="col-sm-2 mb-3">
                            <!-- Submit Button -->
                            <a href="franchaisesearch.php" class="btn btn-outline-danger m-3 mx-3" role="button"
                            aria-pressed="true">Back to search</a>
                        </div>
                    </div><!--- End of row ----->

                </div>

            </div>


        </form>
    </div>

