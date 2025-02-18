<?php
include('db.php');
session_start();
if (isset($_GET['emp_id'])) {
    $empid = $_GET['emp_id'];
    // Retrieve the entry details from the database
    $sql = "SELECT * FROM newemp WHERE emp_id = '$empid'";
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
            <div class="col-sm-12">
                <div class="row ">
                    <div class="col-sm-6 ">
                        <form action="rmupdate.php" method="post" enctype="multipart/form-data" 
                            class=" border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1 needs-validation was-validated">                    
                            <p3 class="fw-bold">Relationship Manager Update</p3>
                                <div class="row">
                                    <div class="col-sm-3 m-1">
                                            <label for="employeeid" class="form-label">Employee ID</label>
                                            <input type="text" class="form-control" id="employeeid" name="employeeid"
                                            value="<?php echo htmlspecialchars($data['emp_id']); ?>" required>
                                    </div> 
                                    <div class="col-sm-6 m-1">
                                            <label for="employeeid" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="employeename" name="employeename"
                                            value="<?php echo htmlspecialchars($data['name']); ?>" required>
                                    </div> 
                                </div> 
                                <div class="row">
                                    <div class="col-sm-3 m-1">
                                            <label for="mappedzone" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="employeedesignation" name="employeedesignation"
                                            value="<?php echo htmlspecialchars($data['designation']); ?>" required>
                                    </div>
                                    <div class="col-sm-6 m-1">
                                            <label for="mappedzone" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="mappedzone" name="mappedzone"
                                            value="<?php echo htmlspecialchars($data['zone']); ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 m-1">
                                            <label for="accessid" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="accessid" name="accessid"
                                            value="<?php echo htmlspecialchars($data['access_id']); ?>" required>
                                    </div>
                                    <div class="col-sm-3 m-1">
                                            <label for="zonalid" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="zonalid" name="zonalid"
                                            value="<?php echo htmlspecialchars($data['mapped_zone_id']); ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 m-1">
                                            <label for="empemail" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="empemail" name="empemail"
                                            value="<?php echo htmlspecialchars($data['email_id']); ?>" required>
                                    </div>
                                    <div class="col-sm-3 m-1">
                                            <label for="emppassword" class="form-label">Employee Name</label>
                                            <input type="text" class="form-control" id="emppassword" name="emppassword"
                                            value="<?php echo htmlspecialchars($data['password']); ?>" required>
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
</body>
</html>

