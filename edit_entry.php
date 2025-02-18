<?php
// Include the database connection
include('db.php');
session_start();
// Check if the entry ID is provided in the URL
if (isset($_GET['id'])) {
    $entry_id = $_GET['id'];


    // Query to get the data for the given ID
    $query = "SELECT * FROM daily_booking WHERE entry_no = $entry_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result); // Fetch the data as an associative array
    } else {
        echo "No record found for ID: $entry_id";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .light-green-bg {
            background-color: lightgreen;
        }
    </style>


</head>

<body>
    <div class="container mt-1">
        <h2>Edit Entry</h2>
        <div class="row">
            <P2 class="fw-bold">Download the policy copy from the below link</P2>
            <table class="table table-bordered table-hover shadow-sm">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Policy PDF</th>
                        <th>School Bus Permit</th>
                        <th>Cheque</th>
                        <th>Customer Name</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider bg-info bg-gradient bg-opacity-10 shadow-sm" id="tablebody">
                    <tr>
                        <td class="text-center">
                            <a href="<?php echo str_replace('.htm', '.pdf', $data['file_path']); ?>" target="_blank">
                                <i class="fa-solid fa-file-arrow-down fa-lg text-primary"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($data['school_path'])) { ?>
                                <a href="<?php echo str_replace('.htm', '.pdf', $data['school_path']); ?>" target="_blank">
                                    <i class="fa-solid fa-file-arrow-down fa-lg text-success"></i>
                                </a>
                            <?php } else { ?>
                                <i class="fa-solid fa-file-arrow-down fa-lg text-secondary opacity-50"></i>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($data['cheque_path'])) { ?>
                                <a href="<?php echo str_replace('.htm', '.pdf', $data['cheque_path']); ?>" target="_blank">
                                    <i class="fa-solid fa-file-arrow-down fa-lg text-danger"></i>
                                </a>
                            <?php } else { ?>
                                <i class="fa-solid fa-file-arrow-down fa-lg text-secondary opacity-50"></i>
                            <?php } ?>
                        </td>
                        <td><?php echo $data['customer_name']; ?></td>
                    </tr>
                </tbody>
            </table>

        </div>

        <form method="POST" action="update_entry.php?id=<?php echo $number; ?>" class="light-green-bg">
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
                                value="<?php echo htmlspecialchars($data['sold_by']); ?>" required readonly>
                        </div>
                        <!-- POSP Name -->
                        <div class="col-sm-3 mb-3">
                            <label for="agentname" class="form-label">Agent Name</label>
                            <input type="text" class="form-control" id="agentname" name="agentname"
                                value="<?php echo htmlspecialchars($data['pos_name']); ?>" required readonly>
                        </div>
                        <!-- POSP Code -->
                        <div class="col-sm-2 mb-3">
                            <label for="agentcode" class="form-label">Agent Code</label>
                            <input type="text" class="form-control" id="agentcode" name="agentcode"
                                value="<?php echo htmlspecialchars($data['pos_code']); ?>" required readonly>
                        </div>
                        <!-- NON POSP Name -->
                        <div class="col-sm-2 mb-3">
                            <label for="nonposname" class="form-label">NON POSP Name</label>
                            <input type="text" class="form-control" id="nonposname" name="nonposname"
                                value="<?php echo htmlspecialchars($data['pos_code']); ?>" required readonly>
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
                                <button type="button" class="btn btn-primary" id="simpleModalButton">Open Simple Modal</button>
                                <!-- Simple Modal -->
                                <div id="simpleModal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document" style="max-width: 800px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Simple Modal Title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>This is a simple modal popup!</p>
                                                <div class="row">
                                                    <div class="col-sm-2 m-1 ">
                                                        <label for="pname" class="form-label">Product</label>
                                                    </div>
                                                    <div class="col-sm-2 m-1 ">
                                                        <input type="text" class="form-control" id="pname" name="pname" required readonly>
                                                    </div>

                                                    <div class="col-sm-2 m-1 ">
                                                        <label for="sname" class="form-label">State Name</label>
                                                    </div>
                                                    <div class="col-sm-2 m-1 ">
                                                        <input type="text" class="form-control" id="sname" name="sname" required readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2 m-1">
                                                        <label for="seg" class="form-label">Segment</label>
                                                    </div>
                                                    <div class="col-sm-2 m-1">
                                                        <input type="text" class="form-control" id="seg" name="seg" required readonly>
                                                    </div>
                                                    <div class="col-sm-2 m-1">
                                                        <label for="planname" class="form-label">Plan Name</label>
                                                    </div>
                                                    <div class="col-sm-2 m-1">
                                                        <input type="text" class="form-control" id="planname" name="planname" required readonly>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3 border-success">
                            <div class="row"><!--- Start of row ----->
                                <div class="col-sm-4 mb-3">
                                    <!-- OD Inward -->
                                    <label for="odinward" class="form-label">OD Inward</label>
                                    <input type="text" class="form-control" id="odinward" name="odinward"
                                        value="<?php echo htmlspecialchars($data['od_inward']); ?>" required>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- TP Inward -->
                                    <label for="tpinward" class="form-label">TP Inward</label>
                                    <input type="text" class="form-control" id="tpinward" name="tpinward"
                                        value="<?php echo htmlspecialchars($data['tp_inward']); ?>" required>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- Net Inward -->
                                    <label for="netinward" class="form-label">Net Inward</label>
                                    <input type="text" class="form-control" id="netinward" name="netinward"
                                        value="<?php echo htmlspecialchars($data['net_inward']); ?>" required>
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <!-- OD Outward -->
                                    <label for="odoutward" class="form-label">OD Outward</label>
                                    <input type="text" class="form-control" id="odoutward" name="odoutward"
                                        value="<?php echo htmlspecialchars($data['od_outward']); ?>" required>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- TP Outward -->
                                    <label for="tpoutward" class="form-label">TP Outward</label>
                                    <input type="text" class="form-control" id="tpoutward" name="tpoutward"
                                        value="<?php echo htmlspecialchars($data['tp_outward']); ?>" required>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <!-- Net Outward -->
                                    <label for="netoutward" class="form-label">Net Outward</label>
                                    <input type="text" class="form-control" id="netoutward" name="netoutward"
                                        value="<?php echo htmlspecialchars($data['net_outward']); ?>" required>
                                </div>
                            </div><!--- End of row ----->
                            <hr class="my-3 border-success">
                            <div class="row"><!--- Start of row ----->


                                <div class="col-sm-2 mb-3">
                                    <!-- Toggle button to calculate Margin-->
                                    <label class="form-label" for="margincalculation">Margin Calculation</label>
                                    <input type="checkbox" id="margin-checkbox" name="margin-checkbox" value="1"
                                        class="form-check-input my-1 float-right" onclick="toggleMarginInput()">
                                </div>

                                <div class="col-sm-3 mb-3">
                                    <!-- Inward Point -->
                                    <label for="incommission" class="form-label">Inward Point</label>
                                    <input type="text" class="form-control" id="incommission" name="incommission"
                                        value="<?php echo htmlspecialchars($data['inward_point']); ?>" required>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <!-- Outward Point -->
                                    <label for="outcommission" class="form-label">Outward Point</label>
                                    <input type="text" class="form-control" id="outcommission" name="outcommission"
                                        value="<?php echo htmlspecialchars($data['outward_point']); ?>" required>
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <!-- Margin -->
                                    <label for="margin" class="form-label">Margin</label>
                                    <input type="text" class="form-control" id="margin" name="margin"
                                        value="<?php echo htmlspecialchars($data['margin']); ?>" required>
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
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['sm_remarks']); ?>" readonly>
                                <textarea id="remarks" name="remarks" class="form-control my-1"
                                    value="<?php echo htmlspecialchars($data['remarks']); ?>" required></textarea>
                            </div>
                            <div class="col-sm-2 mb-3"></div>
                            <div class="col-sm-2 mb-3">
                                <!-- Submit Button -->
                                <button type="submit" name="submit" class="btn btn-success mt-5">Update Entry</button>
                            </div>
                        </div><!--- End of row ----->

                    </div>

                </div>


        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
            if (odinward == 0 && tpinward == 0 && netinward == 0) {
                alert("Please enter a value for inward commission");
                document.getElementById("odinward").focus();
                return;
            }
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
    <!-- Custom JavaScript -->
    <script>
        // Handle dropdown selection
        document.getElementById('productDropdown').addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue) {
                // Hide the first modal
                const firstModal = bootstrap.Modal.getInstance(document.getElementById('firstModal'));
                firstModal.hide();

                // Show the corresponding second modal
                const modalToShow = new bootstrap.Modal(document.getElementById(`${selectedValue}Modal`));
                modalToShow.show();
            }
        });

        // Handle "Back" buttons
        document.getElementById('backToFirstModal1').addEventListener('click', () => {
            bootstrap.Modal.getInstance(document.getElementById('product1Modal')).hide();
            const firstModal = new bootstrap.Modal(document.getElementById('firstModal'));
            firstModal.show();
        });

        document.getElementById('backToFirstModal2').addEventListener('click', () => {
            bootstrap.Modal.getInstance(document.getElementById('product2Modal')).hide();
            const firstModal = new bootstrap.Modal(document.getElementById('firstModal'));
            firstModal.show();
        });

        document.getElementById('backToFirstModal3').addEventListener('click', () => {
            bootstrap.Modal.getInstance(document.getElementById('product3Modal')).hide();
            const firstModal = new bootstrap.Modal(document.getElementById('firstModal'));
            firstModal.show();
        });
    </script>
    <script>
        document.getElementById('simpleModalButton').addEventListener('click', function() {

            var statename = document.getElementById('statename').value;
            var productname = document.getElementById('producttype').value;
            var segment = document.getElementById('segment').value;
            var planname = document.getElementById('plan').value;
            document.getElementById('sname').value = statename;
            document.getElementById('pname').value = productname;
            document.getElementById('seg').value = segment;
            document.getElementById('planname').value = planname;
            $('#simpleModal').modal('show');
        });
    </script>
</body>

</html>