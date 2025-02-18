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
        <style>
    .button-container {
        display: flex;
        gap: 20px; /* Space between buttons */
        justify-content: center; /* Center align buttons */
        align-items: center;
        flex-wrap: wrap; /* Wraps buttons on smaller screens */
    }
    .image-button {
        width: 150px; /* Square shape */
        height: 150px;
        background-color: #3498db; /* Green button */
        color: white;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 12px; /* Rounded edges */
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); /* Soft shadow */
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        display: flex;
        flex-direction: column; /* Stack image and text */
        justify-content: center;
        align-items: center;
        text-transform: uppercase;
        text-align: center;
        padding: 10px;
    }
    .image-button img {
        width: 50px; /* Adjust image size */
        height: 50px;
        margin-bottom: 8px; /* Space between image and text */
    }
    .image-button:hover {
        background-color: #2980b9; /* Darker green on hover */
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
    }
    .vertical-divider {
        display: inline-block;
        width: 1px; /* Width of the divider */
        height: 50px; /* Height of the divider */
        background-color: #ccc; /* Color of the divider */
        margin: 0 10px; /* Space around the divider */
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
    <div class="row border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1">
        <div class="button-container">
            <a href="employee_creation_it.php">
                <button type="button" class="image-button">
                    <img src="images/employee.jpeg" alt="Employee Icon">
                    Employee
                </button>
            </a>
            <a href="employee_bulk.php">
                <button type="button" class="image-button">
                    <img src="images/emp_bulk.jpeg" alt="Employee Icon">
                    Employee Bulk
                </button>
            </a>
            <div class="vertical-divider"></div> <!-- Vertical Divider -->
            <a href="posp_creation_it.php">
                <button type="button" class="image-button">
                    <img src="images/agent.jpg" alt="Posp Icon">
                    Posp
                </button>
            </a>
            <a href="posp_bulk.php">
                <button type="button" class="image-button">
                    <img src="images/posp_bulk.jpeg" alt="Posp Icon">
                    Posp Bulk
                </button>
            </a>
        </div>
    </div>
</div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>