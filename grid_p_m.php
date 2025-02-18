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

        
            <div class="col-sm-8 my-1 m-auto ">
                <form action="show_g_p_m.php" method="post">
                    <div class="row border border-success">
                        <div class="col-sm-2 m-1 ">
                            <label for="product-type" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product-type" id="product-type" required readonly>
                        </div>
                        <div class="col-sm-2 m-1 ">
                                <label for="state-name" class="form-label">State Name</label>
                                <select class="form-select" name="state-name" id="state-name"
                                    aria-label="Default select example">
                                    <option value="">Select</option>
                                    <?php
                                    $query = mysqli_query($con, "SELECT DISTINCT state_name FROM grid_pcv ORDER BY state_name ASC;") or die(mysqli_error());
                                    while ($fetch = mysqli_fetch_array($query)) {
                                        echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                    }
                                    ?>  
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="policy-type" class="form-label">Policy Type</label>
                            <select class="form-select" name="policy-type" id="policy-type"
                                aria-label="Default select example">
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT Policy_type FROM grid_pcv order by Policy_type ASC") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['Policy_type'] . "'>" . $fetch['Policy_type'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="vehicle-type" class="form-label">Vehicle Type</label>
                            <select class="form-select" name="vehicle-type" id="vehicle-type"
                                aria-label="Default select example">
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT Our_Segment FROM grid_pcv order by Our_Segment ASC") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['Our_Segment'] . "'>" . $fetch['Our_Segment'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="seating" class="form-label">STR Capacity</label>
                            <input type="text" class="form-control" name="seating" id="seating" onchange="selectinsurer()"
                                required>

                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="mfg" class="form-label">MFG Year</label>
                            <input type="text" class="form-control" name="mfg" id="mfg" onchange="Calculateage()"
                             required>
                            <input type="text" class="form-control" id="age" hidden></label>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="insurance-company" class="form-label">Insurance Company</label>
                            <select class="form-select" name="insurance-company" id="insurance-company"
                                aria-label="Default select example" required >
                                <option value="">Select</option>
                                <option value="All" selected>All</option>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="gridmonth" class="form-label">Month</label>
                            <select class="form-select" name="gridmonth" id="gridmonth"
                                aria-label="Default select example" required>
                                <option value="">Select</option>
                                <?php
                                $mquery = mysqli_query($con, "SELECT DISTINCT Month FROM grid_gcv ORDER BY Month ASC;") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($mquery)) {
                                    echo "<option value='" . $fetch['Month'] . "'>" . $fetch['Month'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-4 ">
                        	<input type="button" class="btn btn-success" name="submit" id="submit" value="Search"
                        	onclick="displaygrid()">
                        </div>
                        <div class="col-sm-2 m-4 ">
                        <input type="button" class="btn btn-primary" name="submit" id="submit" value="Back"
                        onclick="back()">
                        <button type="button" class="btn btn-warning" onclick="refreshPage()">Refresh</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
            var str = $("#seating").val();
            var vehicle = $("#vehicle-type").val();
            //alert(state);
            console.log("State: " + state + ", Policy: " + policy + ", STR: " + str + ", Vehicle Type: " + vehicle);

            $.ajax({
                url: "show_i_p_m.php",
                type: "POST",
                data: {
                    state: state,
                    policy: policy,
                    str: str,
                    vehicle: vehicle
                },
                success: function(data) {
                    $("#insurance-company").html(data);

                }
            });
        }
    </script>


    <script>
        function displaygrid() {
            var vehicle = document.getElementById("vehicle-type").value;
            var state = document.getElementById("state-name").value;
            var policy = document.getElementById("policy-type").value;
            var str = document.getElementById("seating").value;
            var insurer = document.getElementById("insurance-company").value;
            var age = document.getElementById("age").value;
            var month = document.getElementById("gridmonth").value;


            //alert(vehicle + " " + state + " " +  policy + " " + gvw + " " + insurer + " " + age);

            //alert(insurer);

            $.ajax({
                type: "POST",
                url: "show_g_p_m.php",
                data: {
                    vehicle: vehicle,
                    state: state,
                    policy: policy,
                    str: str,
                    insurer: insurer,
                    age: age,
                    month: month
                },
                success: function(data) {
                    console.log("Response from server:", data); // Log the response
                    $("#displaygrid").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    </script>
    <script>
        function redirectToPage() {
            const dropdown = document.getElementById('product');
            const selectedValue = dropdown.value;

            // Redirect based on selection
            if (selectedValue === '1') {
                window.location.href = 'gridgcv.php';
            } else if (selectedValue === 'miscd') {
                window.location.href = 'gridmiscd.php';
            }else if (selectedValue === 'pcv') {
                window.location.href = 'gridpcv.php';
            }
        }
    </script>

<script>
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const productText = urlParams.get('productText');
    if(productText) {
        document.getElementById("product-type").value = productText;
    }
}
</script>
<script>
function back() {
    window.location.href = "gridtrialmanagement.php";
}
</script>
<script>
    function refreshPage() {
        location.reload();
    }
</script>

</body>

</html>