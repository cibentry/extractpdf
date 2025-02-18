<?php
include('db.php');
session_start();

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
    echo '<strong>Congratulation,</strong> ' . $_SESSION['success'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['success']); // Unset the session variable after displaying the message
}
?>

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Total Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .progress-bar {
            visibility: hidden;
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
        <div class="cont my-1 ">
            <div class="row">
                <div
                    class="col-sm-3 border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mb-5">
                    <h4 class="report bg-primary m-1 p-1 text-light">Reports</h4>
                    <div class="list-group m-3">
                        <a href="operations.php" class="list-group-item list-group-item-action">Home</a>
                        <a href="pendingentry.php" class="list-group-item list-group-item-action">Pending Entries</a>
                        <a href="operationentryreport.php" class="list-group-item list-group-item-action">Entry Report</a>
                        <a href="businessentry.php" class="list-group-item list-group-item-action">Business Entry</a>
                        <a href="#" class="list-group-item list-group-item-action">Business Entry Upload</a>

                    </div>
                    
                </div>
                <div class="col-sm-8 my-1">
                    <h3 class="report bg-primary m-1 p-1 text-light">Business Entry upload</h3>

                    <div class="col-sm-8 my-1">
                        <form action="codingpolicy.php" method="post" enctype="multipart/form-data">
                            <div
                                class="row border border-primary rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 mx-2">
                                <div class="col-sm-8 m-2">
                                    <label for="file">Upload Policy</label>
                                    <input type="file" name="pdf_file" id="pdf_file" class="form-control">
                                </div>
                                <div class="col-sm-2 m-2 ">
                                    <button type="submit" name="submit" class="btn btn-primary m-4">Upload</button>
                                </div>

                            </div>
                            <div class="row mx-3 my-1">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo "<h5 class='text-danger'>" . $_SESSION['message'] . "</h5>";
                                    unset($_SESSION['message']);

                                }

                                ?>

                            </div>
                            <div class="spinner-container d-none">
                                <div class="spinner-border text-info" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>