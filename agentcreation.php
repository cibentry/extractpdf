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
        <link rel="icon" href="fav.png" type="image/x-icon">
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
                <a href="superuser.php" class="btn btn-outline-info" role="button"
                    aria-pressed="true">Dashboard</a>
            </div>
        </div>
    <div class="cont my-1 ">
        <div class="row border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1">

            <form action="agentcreationsave.php" method="post"
                class="row g-3 m-auto border border-success rounded bg-primary bg-gradient bg-opacity-10 shadow-sm p-3 m-1">
                <div class="row">
                    <div class="col-sm-6 border border-primary rounded">
                        <div class="row">
                            <!---- Agent Name ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="agentname" class="form-label">Agent Name</label>
                            </div>
                            <div class="col-sm-8 m-1">
                                <input type="text" class="form-control" name="agentname" id="agentname"
                                    placeholder="Agent Name" required>
                            </div>
                        </div>
                        <div class="row">
                            <!---- Agent Code ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="agentcode" class="form-label">Agent code</label>
                            </div>
                            <div class="col-sm-4 m-1">
                                <input type="text" class="form-control" name="agentcode" id="agentcode"
                                    onblur="checkduplicate()" placeholder="Agent Code" required>
                            </div>
                        </div>
                        <div class="row">
                            <!---- Email Id ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="emailid" class="form-label">Email ID</label>
                            </div>
                            <div class="col-sm-4 m-1">
                                <input type="email" class="form-control" name="emailid" id="emailid"
                                    placeholder="@emailid" required>
                            </div>
                        </div>
                        <div class="row">
                            <!---- RM Name ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="rmname" class="form-label">RM Name</label>
                            </div>
                            <div class="col-sm-4 m-1">
                                <select class="form-select" name="rmname" id="rmname" onchange="selectnumber()"
                                    required>
                                    <option selected>RM Name</option>
                                    <?php
                                    $sql = "SELECT RM_Name FROM rm_list ORDER BY RM_Name";
                                    $result = mysqli_query($con, $sql);
                                    while ($fetch = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $fetch['RM_Name'] . "'>" . $fetch['RM_Name'] . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!---- RM Number ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="rmnumber" class="form-label">RM Number</label>
                            </div>
                            <div class="col-sm-4 m-1">
                                <input type="text" class="form-control" name="rmnumber" id="rmnumber"
                                    placeholder="RM Number" required>
                            </div>
                        </div>
                        <div class="row">
                            <!---- Organization Roll ---->
                            <div class="col-sm-2 float-end m-1">
                                <label for="orgroll" class="form-label">Organization Roll</label>
                            </div>
                            <div class="col-sm-4 m-1">
                                <select class="form-select" name="orgroll" id="orgroll" required>
                                    <option selected>Organization Roll</option>
                                    <option value="POSP">POSP</option>
                                    <option value="NON POSP">NON POSP</option>

                                </select>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-2">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6 border border-primary rounded">
                        <div class="table-responsive bg-transparent">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Roll</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">RM Name</th>
                                        <th scope="col">Contact no</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-transparent">
                                    <?php

                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $records_per_page = 10;
                                    $offset = ($page - 1) * $records_per_page;

                                    $agentquery = "SELECT * FROM agent_table LIMIT $offset, $records_per_page";

                                    $agentresult = mysqli_query($con, $agentquery);
                                    while ($fetch = mysqli_fetch_assoc($agentresult)) {
                                        echo "<tr>";
                                        echo "<td>" . $fetch['POSP_ID'] . "</td>";
                                        echo "<td>" . $fetch['Username'] . "</td>";
                                        echo "<td>" . $fetch['Organisation_Role'] . "</td>";
                                        echo "<td>" . $fetch['Email_ID'] . "</td>";
                                        echo "<td>" . $fetch['RM_Name'] . "</td>";
                                        echo "<td>" . $fetch['Contact'] . "</td>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination-code-start-->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if ($page == 1)
                                    echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1"
                                        aria-disabled="true">Previous</a>
                                </li>
                                <?php
                                $agentquery = "SELECT COUNT(*) as total FROM agent_table";
                                $agentresult = mysqli_query($con, $agentquery);
                                $total_records = mysqli_fetch_assoc($agentresult)['total'];
                                $total_pages = ceil($total_records / $records_per_page);

                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                                ?>
                                <li class="page-item <?php if ($page == $total_pages)
                                    echo 'disabled'; ?>">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>

                        <!-- pagination-code-end-->
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function selectnumber() {
            var rmname = $("#rmname").val();
            $.ajax({
                url: 'getrmnumber.php',
                type: 'POST',
                data: {
                    rmname: rmname
                },
                success: function (data) {
                    $('#rmnumber').val(data);
                }
            });
        }
    </script>
    <script>
        function checkduplicate() {
            var agentname = $("#agentname").val();
            var agentcode = $("#agentcode").val();
            $.ajax({
                url: 'checkduplicate.php',
                type: 'POST',
                data: {
                    agentname: agentname,
                    agentcode: agentcode
                },
                success: function (data) {
                    if (data == 1) {
                        alert("Agent Name or Agent Code Already Exist");
                    }
                }
            });
        }
    </script>

</body>

</html>