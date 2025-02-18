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
                <a href="dash.php" class="list-group-item list-group-item-action">Home</a>
                <a href="businessreport.php" class="list-group-item list-group-item-action">Business Summary</a>
                <a href="policytransaction.php" class="list-group-item list-group-item-action">Policy Transaction</a>
                <a href="mtdpolicytransaction.php" class="list-group-item list-group-item-action">MTD Policy Transaction</a>
                <a href="entryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                <a href="#" class="list-group-item list-group-item-action">Search</a>
            </div>
            <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
            <div class="list-group m-3">
                <a href="mtdbookingreport.php" class="list-group-item list-group-item-action">MTD Booking Report</a>
                <a href="zmrevenue.php" class="list-group-item list-group-item-action">Revenue</a>
                <a href="#" class="list-group-item list-group-item-action">MTD POSP Report</a>
                

            </div>
        </div>
        <div class="col-sm-8">
                <div class="row">
                    <div class="row border border-danger rounded bg-warning bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                        <form method="post" action="headsearchentry.php">
                            <p3 class="text-center fw-semibold">Search Policy Entry</p3>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2 text-end">
                                    <label for="searchby" class="form-label">Search By</label>
                                </div>
                                <div class="col-sm-3">
                                <select class="form-select" name="searchby" id="searchby">
                                        <option value="0">Select</option>
                                        <option value="1">Entry Number</option>
                                        <option value="2">Policy Number</option>
                                        <option value="3">Name</option>
                                        <option value="4">Vehicle Number</option>
                                        <option value="5">Engine Number</option>
                                        <option value="6">Chassis Number</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 text-end">
                                    <label for="searchvalue" class="form-label">Value</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="searchvalue" id="searchvalue" required>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary">
                                </div>
                                
                            </div>
                            <hr>
                        </form>
                        
                    </div>
                </div>
                <div class="row">
                            
                    <div class="row border border-danger rounded bg-info bg-gradient bg-opacity-10 shadow-sm mx-1 my-2 ">
                        <table class="table mt-1 ">
                            <thead class="table-warning">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Vehicle No</th>
                                <th scope="col">Policy No</th>
                                <th scope="col">R S D</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider bg-info bg-gradient bg-opacity-10 shadow-sm" id="tablebody">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#submit").on('click',function(e){
                e.preventDefault(); // Prevent default form submission behaviour

                var searchby = $("#searchby").val(); // get the value from dropdown box
                var searchvalue = $("#searchvalue").val(); // get the value from text field

                $.ajax({
                    url: 'headsearchentry.php', // url for backend operation
                    type: 'POST',
                    data: {
                        searchby: searchby,
                        searchvalue: searchvalue
                    },
                    success: function(data) {
                        $("#tablebody").html(data); // insert data into table
                        alert("Data found");
                    },
                    error : function(xhr, status, error) {
                        alert(error);
                    }
                });
            });
        });
    </script>
    </body> 
    </html>