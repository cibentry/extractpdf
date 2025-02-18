<?php include('db.php');
session_start();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .coin-icon {
            color: #FFD700;
            font-size: 1.2em;
            margin-right: 5px;
        }
    </style>
    <style>
        .badge-new {
            background-color: #007bff;
            color: #ffffff;
            padding: 2px 6px;
            font-size: 12px;
            border-radius: 10px;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
    <style>
        #displaygrid {
            position: relative;
            width: 100%;
            min-height: 300px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            font-weight: bold;
            color: rgba(128, 128, 128, 0.3);
            white-space: nowrap;
            pointer-events: none;
            z-index: 9999;
        }
        .table {
            position: relative;
            z-index: 1;
            background: transparent !important;
        }
        .table thead th {
            background: rgba(255, 255, 255, 0.9);
        }
        .table tbody tr {
            background: rgba(255, 255, 255, 0.9);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(249, 249, 249, 0.9);
        }
    </style>
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


                    $query = mysqli_query($con, "SELECT * FROM newemp WHERE name='$_SESSION[username]'") or die(mysqli_error());
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
    </div>
    <div class="cont my-1 ">

        <div class="row">
            <div class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                <div class="list-group m-3">
                    <a href="rms.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="rmsbusinesssummary.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line"></i> Business Summary
                    </a>
                    <a href="rmspolicytransaction.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-invoice"></i> Policy Transaction
                    </a>
                    <a href="mtdrmspolicytransaction.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-invoice"></i> MTD Policy Transaction
                    </a>
                    <a href="rmsentryreport.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Entry Report
                    </a>
                    <a href="rmsbusinessentry.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-edit"></i> Business Entry
                    </a>
                    <a href="rmssearch.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-search"></i> Search
                    </a>
                    <a href="https://app.certigoinsurance.com/login" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt"></i> Policy Issuance
                        <span class="badge badge-new">New</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-invoice"></i> Grid
                    </a>
                </div>

            </div>


            <div class="col-sm-8 my-1 ">
                <form action="showgrid.php" method="post">
                    <div class="row border border-success">
                    <div class="col-sm-2 m-1">
                            <label for="product" class="form-label">Product</label>
                            <select class="form-select" name="product" id="product"
                                aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">GCV</option>
                                <option value="2">MISC-D</option>
                            </select>
                    </div>
                        <div class="col-sm-2 m-1">
                            <label for="state-name" class="form-label">State Name</label>
                            <select class="form-select" name="state-name" id="state-name"
                                aria-label="Default select example">
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT state_name FROM gcv_dec ORDER BY state_name ASC;") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-2 m-1">
                            <label for="policy-type" class="form-label">Policy Type</label>
                            <select class="form-select" name="policy-type" id="policy-type"
                                aria-label="Default select example">
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT Policy_type FROM gcv_dec order by Policy_type ASC") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['Policy_type'] . "'>" . $fetch['Policy_type'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1">
                            <label for="gvw" class="form-label">GVW</label>
                            <input type="text" class="form-control" name="gvw" id="gvw" onchange="selectinsurer()"
                                required>

                        </div>
                        <div class="col-sm-2 m-1">
                            <label for="mfg" class="form-label">MFG Year</label>
                            <input type="text" class="form-control" name="mfg" id="mfg" onchange="Calculateage()"
                                onblur="displaygrid()" required>
                            <input type="text" class="form-control" id="age" hidden></label>
                        </div>

                        <div class="col-sm-2 m-1">
                            <label for="insurance-company" class="form-label">Insurance Company</label>
                            <select class="form-select" name="insurance-company" id="insurance-company"
                                aria-label="Default select example" required onchange="displaygrid()">
                                <option value="">Select</option>
                                <option value="All" selected>All</option>



                            </select>

                        </div>
                    </div>
                </form>
                <div class="row my-1 border border-primary">
                    <div id="displaygrid">
                        <div class="watermark"><?php echo date('d-m-Y'); ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function Calculateage() {
            var mfg = document.getElementById("mfg").value;
            var currentYear = new Date().getFullYear();
            var age = currentYear - mfg;
            document.getElementById("age").value = age;

        }

    </script>
    <script>
        function selectinsurer() {
            var state = $("#state-name").val();
            var policy = $("#policy-type").val();
            var gvw = $("#gvw").val();
            //alert(state);
            console.log("State: " + state + ", Policy: " + policy + ", GVW: " + gvw);
            
            $.ajax({
                url: "showinsurer.php",
                type: "POST",
                data: {
                    state: state,
                    policy: policy,
                    gvw: gvw
                },
                success: function (data) {
                    $("#insurance-company").html(data);

                }
            });
        }

    </script>


    <script>

        function displaygrid() {
            var vehicle = document.getElementById("product").value;
            var state = document.getElementById("state-name").value;
            var policy = document.getElementById("policy-type").value;
            var gvw = document.getElementById("gvw").value;
            var insurer = document.getElementById("insurance-company").value;
            var age = document.getElementById("age").value;


             //alert(vehicle + " " + state + " " +  policy + " " + gvw + " " + insurer + " " + age);

            //alert(insurer);

            $.ajax({
                type: "POST",
                url: "showgrid.php",
                data: {
                    vehicle: vehicle,
                    state: state,
                    policy: policy,
                    gvw: gvw,
                    insurer: insurer,
                    age: age
                },
                success: function (data) {
                    console.log("Response from server:", data); // Log the response
                    $("#displaygrid").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    </script>
    

</body>

</html>