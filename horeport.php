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
            <div class="cont my-1">
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="hooperations.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">Dashboard</a>
                </div>
            </div>

            <div class="col-sm-12 my-1">
                <form action="horeportdownload.php" method="post" enctype="multipart/form-data">
                    <div class="row border border-primary mx-3 bg-primary bg-gradient bg-opacity-10 shadow-sm p-3">
                        <h5>Report Download</h5>
                        <div class="col-sm-2 m-1 p-2 mx-5">
                          <label for="fromdate" class="form-label">From</label>
                          <input type="date" id="fromdate" name="fromdate"
                                 class="form-control my-1" title="YYYY-MM-DD"
                                 placeholder="dd-mm-yyyy" required
                                 max="<?php echo date('Y-m-d'); ?>">
                        
                        </div>
                        <div class="col-sm-2 m-1 p-2 mx-5">
                          <label for="todate" class="form-label">To</label>
                          <input type="date" id="todate" name="todate"
                                 class="form-control my-1" title="YYYY-MM-DD"
                                 placeholder="dd-mm-yyyy" required
                                 max="<?php echo date('Y-m-d'); ?>">
                        
                        </div>
                        
                    </div>


                    <div class="row">
                        <div class="col-sm-1 m-1 p-2 mx-auto">
                            <button type="submit" name="submit" class="btn btn-primary m-4">Download</button>
                        </div>
                    </div>


                </form>
                <div class="col-sm-10 m-1 p-2 mx-5">
                    <div id="heading" class="text-center text-primary fw-bolder fs-4">

                    </div>
                    <div id="result">

                    </div>
                    <div id="footer" class="text-center text-primary fw-bolder fs-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#fy-year, #entrymonth, #entrydate').on('change', function () {
            var fyYear = $('#fy-year').val();
            var entryMonth = $('#entrymonth').val();
            var entryDate = $('#entrydate').val();
            var headingText = 'Financial Year: ' + fyYear + ', Month: ' + entryMonth + ', Date: ' + entryDate;
            $('#heading').html(headingText);
        });
    });
</script>

<script>
const fromdateInput = document.getElementById('fromdate');
const todateInput = document.getElementById('todate');

fromdateInput.addEventListener('change', validateDateRange);
todateInput.addEventListener('change', validateDateRange);

function validateDateRange() {
  const fromdate = new Date(fromdateInput.value);
  const todate = new Date(todateInput.value);

  if (todate < fromdate) {
    alert('To date cannot be earlier than From date');
    todateInput.setCustomValidity('Invalid date range');
    todateInput.value = ''; // reset the todate field
  } else {
    todateInput.setCustomValidity('');
  }
}
</script>



</html>