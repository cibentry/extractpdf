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
        <div class="row border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-header">
                            Agent Creation
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Agent Creation Module</h5>
                            
                            <a href="agentcreation.php" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-header">
                            RM Creation
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">RM Creation Module</h5>
                            
                            <a href="rmcreation.php" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-header">
                            Entry Deletion
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Entry Deletion Module</h5>
                            
                            <a href="entrydelete.php" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-4">
                <div class="card text-center">
                        <div class="card-header">
                            Agent Updation
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Agent Updation Module</h5>
                            
                            <a href="codingpolicy.php" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            
                        </div>
                    </div>   
                </div>
                <div class="col-sm-4">
                <div class="card text-center">
                        <div class="card-header">
                            RM Updation
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">RM Updation Module</h5>
                            
                            <a href="rmsedit.php" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="card-footer text-body-secondary">
                            
                        </div>
                    </div>
                    </div>  
                </div>
                <div class="col-sm-2">
                    
                </div>
            </div>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>