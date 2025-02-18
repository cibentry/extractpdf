<?php
// Include the database connection
include('db.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Entry</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-1">
        
        <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
            <div class="row">
                <div class="col-10 col-sm-6 col-md-10">
                    <!--<h1>Hello, </h1>-->
                    <h1 class="head text-light">Edit Entry</h1>
                    <?php
                    require 'db.php';


                    $query = mysqli_query($con, "SELECT * FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error());
                    $fetch = mysqli_fetch_array($query);

                    echo "<h5 class='text-light mx-3 fw-bolder'>" . $fetch['name'] . "</h5>";
                    ?>
                    <input type="text" name="zoneid" id="zoneid" class="form-control" value="<?php echo $fetch['mapped_zone_id']; ?>" hidden>
                </div>
                <div class="col-12 col-sm-6 col-md-1 ">
                    <a href="logout.php" class="btn btn-secondary btn-lg active m-3 mx-3" role="button"
                        aria-pressed="true">logout</a>
                </div>
            </div>
            
        </div>
        <div class="row m-2">
        <div class="col-sm-12">
                <div class="row">
                    <div class="row border border-danger rounded bg-warning bg-gradient bg-opacity-10 shadow-sm mx-1 ">
                        <form method="post" action="op_end_search.php">
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
                                <th scope = "col"><th>
                                <th scope = "col"><th>
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
    </div>

    <!-- Include Bootstrap JS -->
    <script src=" https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMarginInput() {

            var commissionablepremium = document.getElementById("commissionablepremium");
            var totalodpremium = document.getElementById("totalodpremium");
            var totaltppremium = document.getElementById("totaltppremium");
            var odinward = document.getElementById("odinward").value;
            var tpinward = document.getElementById("tpinward").value;
            var netinward = document.getElementById("netinward").value;
            var odoutward = document.getElementById("odoutward").value;
            var tpoutward = document.getElementById("tpoutward").value;
            var netoutward = document.getElementById("netoutward").value;
            var totalod = document.getElementById("totalodpremium").value;
            var totaltp = document.getElementById("totaltppremium").value;
            var net = document.getElementById("netpremium").value;
            //var producttype = document.getElementById("producttype");
            //var selectedproduct = producttype.options[producttype.selectedIndex].text;
            //var plan = document.getElementById("plan");
            //var selectedplan = plan.options[plan.selectedIndex].text;
            //alert(selectedproduct);

            if (odinward != 0 && tpinward != 0) {

                var inwardcommission = (totalodpremium.value * (odinward / 100)) + (totaltppremium.value * (tpinward / 100));
                var outwardcommission = (totalodpremium.value * (odoutward / 100)) + (totaltppremium.value * (tpoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);

            } else if (odinward != 0 && tpinward == 0) {
                var inwardcommission = (totalodpremium.value * (odinward / 100));
                var outwardcommission = (totalodpremium.value * (odoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            } else if (odinward == 0 && tpinward != 0) {
                var inwardcommission = (totaltppremium.value * (tpinward / 100));
                var outwardcommission = (totaltppremium.value * (tpoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            } else {
                var inwardcommission = (net * (netinward / 100));
                var outwardcommission = (net * (netoutward / 100));
                //alert(inwardcommission);
                //alert(outwardcommission);
                document.getElementById("incommission").value = inwardcommission.toFixed(2);
                document.getElementById("outcommission").value = outwardcommission.toFixed(2);
                var margin = inwardcommission - outwardcommission;
                document.getElementById("margin").value = margin.toFixed(2);
            }
        }
    </script>
    <script>
        $(document).ready(function(){
            $("#submit").on('click',function(e){
                e.preventDefault(); // Prevent default form submission behaviour

                var searchby = $("#searchby").val(); // get the value from dropdown box
                var searchvalue = $("#searchvalue").val(); // get the value from text field
                var zoneid = $("#zoneid").val(); // get the value from text field

                $.ajax({
                    url: 'op_end_search.php', // url for backend operation
                    type: 'POST',
                    data: {
                        searchby: searchby,
                        searchvalue: searchvalue,
                        zoneid: zoneid
                    },
                    success: function(data) {
                        $("#tablebody").html(data); // insert data into table
                        //alert("Data found");
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