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

        <div class="row">
            <div class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                <div class="list-group m-3">
                    <a href="rms.php" class="list-group-item list-group-item-action active">Home</a>
                    <a href="rmsbusinesssummary.php" class="list-group-item list-group-item-action">Business Summary</a>
                    <a href="rmspolicytransaction.php" class="list-group-item list-group-item-action">Policy
                        Transaction</a>
                    <a href="mtdrmspolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy
                        Transaction</a>
                    <a href="rmsentryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                    <a href="rmsbusinessentry.php" class="list-group-item list-group-item-action">Business Entry</a>
                    <a href="rmssearch.php" class="list-group-item list-group-item-action">Search</a>
                    <a href="#" class="list-group-item list-group-item-action">Projection / Reporting</a>
                </div>

            </div>

            <div class="col-sm-8 my-1">
                <h5>Business Projection</h5>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                        <input type="text" id="entrydate" name="entrydate" class="form-control my-1 fw-bold"
                        value="<?php echo date("Y-m-d") ?>" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="rmname" name="rmname" class="form-control my-1 fw-bold" 
                        value="RM - <?php echo $fetch['name'] ?>" readonly required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                            <input type="text" id="pone" name="pone" class="form-control my-1 fw-bold"
                            value="P1" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="pone" name="pone" class="form-control my-1 fw-bold" placeholder="K"
                        required onblur="addK(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                            <input type="text" id="ptwo" name="ptwo" class="form-control my-1 fw-bold"
                            value="P2" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="ptwo" name="ptwo" class="form-control my-1 fw-bold" placeholder="K"
                        required onblur="addK(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                            <input type="text" id="pthree" name="pthree" class="form-control my-1 fw-bold"
                            value="P3" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="pthree" name="pthree" class="form-control my-1 fw-bold" placeholder="K"
                        required onblur="addK(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                            <input type="text" id="drr" name="drr" class="form-control my-1 fw-bold"
                            value="D.R.R" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="drr" name="drr" class="form-control my-1 fw-bold" placeholder="K"
                        required onblur="addK(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 m-1 p-2 ">
                            <input type="text" id="newcoding" name="newcoding" class="form-control my-1 fw-bold"
                            value="New Coding" readonly required>
                    </div>
                    <div class="col-sm-3 m-1 p-2 ">
                        <input type="text" id="newcoding" name="newcoding" class="form-control my-1 fw-bold" placeholder="0"
                        required >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function addK(input) {
        const value = input.value.trim();
        if (!value.endsWith('K') && !value.includes('K')) {
            input.value = value + 'K';
        }
    }
</script>
</body>

</html>