<?php include('db.php');
session_start();
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    echo '<strong>Congratulation,</strong> ' . $_SESSION['success'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['success']); // Unset the session variable after displaying the message
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
    </div>
    <div class="cont my-1">
        <div class="col-12 col-sm-6 col-md-1 ">
            <a href="superuser.php" class="btn btn-outline-info" role="button" aria-pressed="true">Dashboard</a>
        </div>
    </div>
    <div class="cont my-1 ">
        <div class="row border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1">
            <div class="col-sm-10">
                <div class="row ">
                    <div class="col-sm-6 ">
                        <form action="rmcreationsave.php" method="post"
                            class=" m-auto border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1 needs-validation was-validated">
                            <p3 class="fw-bold">Relationship Manager Creation</p3>
                            <div class="row">
                                <div class="col-sm-4 m-1">
                                    <label for="empname" class="form-control my-1">Employee Name</label>
                                </div>
                                <div class="col-sm-7 m-2">
                                    <input type="text" class="form-control" id="empname" name="empname"
                                        placeholder="Enter Employee Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1">
                                    <label for="designationname" class="form-control my-1">Designation</label>
                                </div>
                                <div class="col-sm-8 m-1">
                                    <select id="designationname" name="designationname" class="form-select my-1"
                                        required onchange="selectaccessid()">
                                        <option Value="">Select Designation</option>
                                        <?php
                                        $selectdesignation = "SELECT designation FROM designation_list ORDER BY designation ASC";
                                        $designationquery = mysqli_query($con, $selectdesignation);
                                        while ($row = mysqli_fetch_array($designationquery)) {
                                            echo "<option Value='" . $row['designation'] . "'>" . $row['designation'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1">
                                    <label for="statename" class="form-control my-1">State Name</label>
                                </div>
                                <div class="col-sm-3 m-1">
                                    <select id="statename" name="statename" class="form-select my-1"
                                        onchange="selectstateid()" required>
                                        <option Value="">Select State</option>
                                        <?php
                                        $stateselect = "SELECT state_name FROM zone_list ORDER BY state_name ASC";
                                        $stateselectquery = mysqli_query($con, $stateselect);
                                        while ($row = mysqli_fetch_array($stateselectquery)) {
                                            echo "<option Value='" . $row['state_name'] . "'>" . $row['state_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1">
                                    <label for="accessid" class="form-control my-1">Access ID</label>
                                </div>
                                <div class="col-sm-3 m-1">
                                    <input type="text" class="form-control" id="accessid" name="accessid" required>
                                </div>
                                <div class="col-sm-2 m-1">
                                    <label for="zonalid" class="form-control my-1">Zonal ID</label>
                                </div>
                                <div class="col-sm-2 m-2">
                                    <input type="text" class="form-control" id="zonalid" name="zonalid" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1">
                                    <label for="emailid" class="form-control my-1">Email</label>
                                </div>
                                <div class="col-sm-8 m-2">
                                    <input type="email" class="form-control" id="zonalid" name="emailid" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1">
                                    <label for="password" class="form-control my-1">Password</label>
                                </div>
                                <div class="col-sm-8 m-2">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 m-1"></div>
                                <div class="col-sm-3 m-1"></div>
                                <div class="col-sm-2 m-1">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function selectstateid() {
            var state = $('#statename').val();
            $.ajax({
                url: 'get_zone_info.php',
                type: 'post',
                data: { state: state },
                success: function (data) {
                    $('#zonalid').val(data);
                    //alert(data);
                }
            })
        }
    </script>
    <script>
        function selectaccessid() {
            var designationn = $('#designationname').val();
            $.ajax({
                url: 'get-access-info.php',
                type: 'post',
                data: { designationn: designationn },
                success: function (data) {
                    $('#accessid').val(data);
                    //alert(data);
                }
            })
        }
    </script>
    

</body>

</html>