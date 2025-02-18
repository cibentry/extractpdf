<?php include('db.php');
session_start();
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
    </div>
    <div class="cont my-1 ">
        <div class="row m-5 p-3 border border-danger">
            <form action="gridaction.php" method="POST">
                    <div class="col-sm-2 m-1 ">
                        <label for="product-type" class="form-label">Product Type</label>
                        <select class="product-type form-select" name="product-type" id="product-type"
                            aria-label="Default select example" required onclick="loadstate()">
                            <option >Select Product</option>
                            <option value="GCV">GCV</option>
                            <option value="MISC-D">MISC-D</option>
                            <option value="PCV">PCV</option>
                            <option value="PVT">PVT</option>
                            <option value="TWH>">TWH</option>
                        </select>
                    </div>
                    <div class="col-sm-2 m-1">
                        <label for="state-name" class="form-label">State Name</label>
                        <select class="state-name form-select" name="state-name" id="state-name"
                            aria-label="Default select example" required>
                            <option value="">Select State</option>
                        </select>
                    </div>
            </form>
        </div>
    </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
