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


                    $query = mysqli_query($con, "SELECT * FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                    $fetch = mysqli_fetch_array($query);

                    echo "<h5 class='text-light mx-3 fw-bolder'>" . $fetch['name'] . "</h5>";
                    echo "<p class='text-light mx-3'> <em>" . $fetch['code'] . "</em></p>"; // Changed to italic // Added line to show ID
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
                        <i class="fas fa-table"></i> Grid
                    </a>
                </div>

            </div>


            <div class="col-sm-8 my-1 ">
                <form action="showgrid.php" method="post">
                    <div class="row border border-success">

                        <div class="col-sm-2 m-1 ">
                            <label for="product-type" class="form-label">Product</label>
                            <input type="text" class="form-control" name="product-type" id="product-type" required readonly>
                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="businesstype" class="form-label">Business Type</label>
                            <select class="form-select" name="businesstype" id="businesstype" aria-label="Default select example" required>
                            <option value="">Select</option>
                            <option value="Fresh">Fresh</option>
                            <option value="Renewal">Renewal</option>
                            <option value="Portability">Portability</option>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="insurance-company" class="form-label">Insurance Company</label>
                            <select class="form-select" name="insurance-company" id="insurance-company"
                                aria-label="Default select example" required >
                                <option value="">Select</option>
                                
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
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> 
    <script src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const productText = urlParams.get('productText');
            if (productText) {
                document.getElementById("product-type").value = productText;
            }
        }
    </script>
</body>

</html>