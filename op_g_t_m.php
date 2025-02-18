<?php include('db.php');
session_start();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <div class="container-fluid m-auto mx-1 ">
        <div class="container-fluid border border-primary rounded bg-primary bg-gradient ">
            <div class="row">
                

            </div>
        </div>
    </div>
    <div class="cont my-1 ">

        <div class="row m-auto">
            
            <div class="col-sm-8 my-1 m-auto ">
                <form action="showgrid.php" method="post">
                    <div class="row border border-success">
                        <div class="col-sm-2 m-1 ">
                            <label for="product" class="form-label">Product</label>
                            <select class="form-select" name="product" onchange="redirectToGrid()" id="product"
                                        aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">GCV</option>
                                        <option value="2">MISC-D</option>
                                        <option value="3">PCV</option>
                                        <option value="4">PVT</option>
                                        <option value="5">TWH</option>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                                <label for="state-name" class="form-label">State Name</label>
                                <select class="form-select" name="state-name" id="state-name"
                                    aria-label="Default select example">
                                    <?php
                                    $query = mysqli_query($con, "SELECT DISTINCT state_name FROM grid_gcv ORDER BY state_name ASC;") or die(mysqli_error());
                                    while ($fetch = mysqli_fetch_array($query)) {
                                        echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                    }
                                    ?>  
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="policy-type" class="form-label">Policy Type</label>
                            <select class="form-select" name="policy-type" id="policy-type"
                                aria-label="Default select example">
                                <?php
                                $query = mysqli_query($con, "SELECT DISTINCT Policy_type FROM grid_gcv order by Policy_type ASC") or die(mysqli_error());
                                while ($fetch = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $fetch['Policy_type'] . "'>" . $fetch['Policy_type'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="gvw" class="form-label">GVW</label>
                            <input type="text" class="form-control" name="gvw" id="gvw" onchange="selectinsurer()"
                                required>
                        </div>
                        <div class="col-sm-2 m-1 ">
                            <label for="mfg" class="form-label">MFG Year</label>
                            <input type="text" class="form-control" name="mfg" id="mfg" onchange="Calculateage()"
                                onblur="displaygrid()" required>
                            <input type="text" class="form-control" id="age" hidden></label>
                        </div>
                        <div class="col-sm-2 m-1 ">
                        <label for="insurance-company" class="form-label">Insurance Company</label>
                            <select class="form-select" name="insurance-company" id="insurance-company"
                                aria-label="Default select example" required onchange="displaygrid()">
                                <option value="">Select</option>
                                <option value="All" selected>All</option>
                            </select>
                        </div>
                        <div class="col-sm-2 m-1 ">
                                <label for="monthname" class="form-label">Month</label>
                                <select class="form-select" name="monthname" id="monthname" aria-label="Default select example" required>
                                    <option value="">Select</option>    
                                </select>
                        </div>
                        <div class="col-sm-2 m-4 ">
                            <input type="button" class="btn btn-primary" name="submit" id="submit" value="Back"
                            onclick="back()">
                            <button type="button" class="btn btn-warning" onclick="refreshPage()">Refresh</button>
                        </div>
                        <div class="col-sm-2 m-4 ">
                                <?php
                                  $query = mysqli_query($con, "SELECT * FROM newemp WHERE name='$_SESSION[username]'") or die(mysqli_error()); 
                                  $fetch = mysqli_fetch_array($query); 
                                  $aciid=$fetch['access_id'];
                                    
                                ?>
                            <input type="text" class="form-control" id="acid" value = "<?php echo $aciid; ?>"></label>
                        </div>
                    </div>
                </form>
                <div class="row my-1 border border-primary">
                    <div id="displaygrid">
                        <div class="watermark"><?php echo date('d-m-Y'); ?></div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function Calculateage() {
            var mfg = document.getElementById("mfg").value;
            var currentYear = new Date().getFullYear();
            var age = currentYear - mfg;
            document.getElementById("age").value = age;

        }
    </script>
    <script>
        function selectinsurer() {
            var state = $("#state-name").val();
            var policy = $("#policy-type").val();
            var gvw = $("#gvw").val();
            //alert(state);
            console.log("State: " + state + ", Policy: " + policy + ", GVW: " + gvw);

            $.ajax({
                url: "showinsurer.php",
                type: "POST",
                data: {
                    state: state,
                    policy: policy,
                    gvw: gvw
                },
                success: function(data) {
                    $("#insurance-company").html(data);

                }
            });
        }
    </script>


    <script>
        function displaygrid() {
            var vehicle = document.getElementById("product").value;
            var state = document.getElementById("state-name").value;
            var policy = document.getElementById("policy-type").value;
            var gvw = document.getElementById("gvw").value;
            var insurer = document.getElementById("insurance-company").value;
            var age = document.getElementById("age").value;


            //alert(vehicle + " " + state + " " +  policy + " " + gvw + " " + insurer + " " + age);

            //alert(insurer);

            $.ajax({
                type: "POST",
                url: "showgrid.php",
                data: {
                    vehicle: vehicle,
                    state: state,
                    policy: policy,
                    gvw: gvw,
                    insurer: insurer,
                    age: age
                },
                success: function(data) {
                    console.log("Response from server:", data); // Log the response
                    $("#displaygrid").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    </script>
    

<script>
function redirectToGrid() {
    var selectElement = document.getElementById("product");
    var selectedValue = selectElement.value;
    var selectedText = selectElement.options[selectElement.selectedIndex].text;
    
    if(selectedValue == "1") {
        window.location.href = "gridgcvmanagement.php?productText=" + encodeURIComponent(selectedText);
    } else if(selectedValue == "2") {
        window.location.href = "grid_m_m.php?productText=" + encodeURIComponent(selectedText);
    }else if(selectedValue == "3") {
        window.location.href = "grid_p_m.php?productText=" + encodeURIComponent(selectedText);
    }else if(selectedValue == "4") {
        window.location.href = "grid_pvt_m.php?productText=" + encodeURIComponent(selectedText);
    }else if(selectedValue == "5") {
        window.location.href = "grid_t_m.php?productText=" + encodeURIComponent(selectedText);
    }
}
</script>
<script>
function back() {
    var ac_id = document.getElementById("acid").value;
    //window.location.href = "gridtrialmanagement.php";
    if(ac_id == "1") {
        window.location.href = "dash.php";
    }else if(ac_id == "3") {
        window.location.href = "operations.php";
    }else if(ac_id == "5") {
        window.location.href = "superuser.php";
    }else if(ac_id == "8") {
        window.location.href = "directors.php";
    }else if(ac_id == "10") {
        window.location.href = "hooperations.php";
    }


}
</script>

</body>

</html>