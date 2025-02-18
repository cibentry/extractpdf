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
            <div class="col-sm-12">
                <div class="row ">
                    <div class="col-sm-6 ">
                        <form action="get-rm-info.php" method="post"
                            class=" m-auto border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1 needs-validation was-validated">
                            <p3 class="fw-bold">Relationship Manager Edit</p3>
                            <div class="row">
                                <div class="col-sm-2 m-1">
                                    <label for="searchrm" class="form-control my-1">Search</label>
                                </div>
                                <div class="col-sm-4 m-1">
                                    <select id="searchby" name="searchby" class="form-select my-1" required>
                                        <option Value="">Select</option>
                                        <option value="1">Name</option>
                                        <option value="2">Email</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 m-1 p-1">
                                    <input type="text" class="form-control" id="searcrm" name="searcrm"
                                        onblur="selectrm()" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-4 m-1"></div>
                                <div class="col-sm-4 m-1"></div>
                                <div class="col-sm-2 m-1">
                                    <input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary">
                                </div>
                            </div>

                        </form>       
                    </div>
                        
                
                    <div class="col-sm-5">
                        <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">
                                        <!--- content --->
                                    </tbody>
                                </table> 
                        </div>
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
        $(document).ready(function() {
    $("form").on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting normally

        var searchby = $("#searchby").val(); // Get the value from dropdown
        var searcrm = $("#searcrm").val(); // Get the value from text field

        $.ajax({
            url: 'get-rm-info.php', // Backend URL for AJAX
            type: 'POST',
            data: {
                searchby: searchby,
                searcrm: searcrm
            },
            success: function(data) {
                $("#tablebody").html(data); // Insert the returned data into the table
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error); // Show any error encountered
            }
        });
    });
});

    </script>

</body>

</html>