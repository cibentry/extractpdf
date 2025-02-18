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
                    <a href="dash.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">Dashboard</a>
                </div>
            </div>

            <div class="col-sm-12 my-1">

                <form action="reportdownload-execute.php" method="post" id="report-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-1 m-1 p-2 mx-auto">
                            <select id="entrydate" name="entrydate" class="form-select"
                                aria-label="Default select example">
                                <option selected>Select Date</option>
                                <?php
                                $query = "SELECT distinct entry_date FROM `daily_booking`";
                                $result = mysqli_query($con, $query);
                                while ($fetch = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $fetch['entry_date'] . "'>" . $fetch['entry_date'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 m-1 p-2 mx-auto">
                            <button type="submit" id="download-btn" name="submit"
                                class="btn btn-primary m-4">Download</button>
                        </div>
                    </div>


                </form>
            </div>
            <!-- Add a hidden iframe to handle the file download -->
            <iframe id="download-iframe" style="display: none;"></iframe>
        </div>
    </div>
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    const form = document.getElementById('report-form');
    const downloadBtn = document.getElementById('download-btn');
    const downloadIframe = document.getElementById('download-iframe');

    downloadBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const entryDate = document.getElementById('entrydate').value;
        const formData = new FormData();
        formData.append('entrydate', entryDate);

        // Send an AJAX request to the PHP script to generate the Excel file
        fetch('reportdownload-execute.php', {
            method: 'POST',
            body: formData
        })
            .then((response) => response.blob())
            .then((blob) => {
                // Create a URL for the blob and set it as the iframe's src
                const url = URL.createObjectURL(blob);
                downloadIframe.src = url;

                // Set the iframe's content disposition to force a download
                downloadIframe.contentWindow.document.execCommand('SaveAs', true, 'report_' + new Date().toLocaleDateString() + '.xlsx');
            })
            .catch((error) => console.error('Error:', error));
    });

</script>

</html>