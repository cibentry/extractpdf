<?php
include('db.php');
session_start();
// Check if the data was saved successfully
if (isset($_SESSION['last_ecode'])) {
    // Output the last entry number
    echo "<script>alert('Employee data saved successfully. ');</script>";
    unset($_SESSION['last_ecode']); // Clear the session variable after use
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Creation</title>

<!-- Load jQuery (Only Once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load Select2 (CSS & JS) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- Load Bootstrap (CSS & JS) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Load Toastr (If Needed) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>Employee Creation</h3>
                    </div>
                    <div class="card-body">

                        <form action="emp_save.php" method="POST" id='myForm'>
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="e_code" class="form-label">E Code</label>
                                    <input type="text" class="form-control" name="e_code" id='e_code' placeholder="E Code" onchange="check_e_code(this.value);" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" d='name' placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" name="phone" id='phone' placeholder="Phone Number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email ID</label>
                                    <input type="email" class="form-control" name="email" id='email' placeholder="Enter Email ID" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id='password' placeholder="Enter Password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <select class="form-control" name="designation" id='designation' required onchange="selectfunction();">
                                        <option value="">Select Designation</option>
                                        <?php
                                        $query = mysqli_query($con, "SELECT DISTINCT designation FROM functionality_master ORDER BY designation ASC;") or die(mysqli_error());
                                        while ($fetch = mysqli_fetch_array($query)) {
                                            echo "<option value='" . $fetch['designation'] . "'>" . $fetch['designation'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="funcationality" class="form-label">Funcationality</label>
                                    <select class="form-control" name="functionality" id='functionality' onchange="selectdepartment();" required>
                                        <option value="" selected>Select Funcationality</option>



                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-control" name="department" id='department' required>
                                        <option value="">Select Department</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="mapped_zone" class="form-label">Mapped Zone</label>
                                    <select class="form-control" name="mapped_zone" id='mapped_zone' onchange="selectmappedzoneid();" required">
                                        <option value="">Select Mapped Zone</option>
                                        <?php
                                        $query = mysqli_query($con, "SELECT DISTINCT state_name FROM zone_master ORDER BY state_name ASC;") or die(mysqli_error());
                                        while ($fetch = mysqli_fetch_array($query)) {
                                            echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="mapped_zone_id" class="form-label">Mapped Zone ID</label>
                                    <input type="text" class="form-control" name="mapped_zone_id" id='mapped_zone_id' placeholder="Mapped Zone ID" required readonly>

                                </div>
                                <div class="col-md-6">
                                    <label for="reporting_name" class="form-label">Reporting Name</label>
                                    <select class="form-control select2" name="reporting_name" id='reporting_name' onchange="selectecode();" required>
                                        <option value="">Select Reporting Name</option>
                                        <?php
                                        $insq = "SELECT DISTINCT name FROM employee_master";

                                        $resins = mysqli_query($con, $insq) or die("Error in query: " . mysqli_error($con));
                                        
                                        if (mysqli_num_rows($resins) > 0) {
                                            while ($insrow = mysqli_fetch_array($resins)) {
                                                echo "<option value='" . $insrow['name'] . "'>" . $insrow['name'] . "</option>";;   
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="reporting_ecode" class="form-label">Reporting Ecode</label>
                                    <input type="text" class="form-control" name="reporting_ecode" id='reporting_ecode' placeholder="Reporting Ecode" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="reporting_funcationality" class="form-label">Reporting Funcationality</label>
                                    <input type="text" class="form-control" name="reporting_funcationality" id='reporting_funcationality' placeholder="Reporting Funcationality" value=" - " required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="salary" class="form-label">Monthly CTC</label>
                                    <input type="text" class="form-control" name="salary" id='salary' placeholder="Salary" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="hire_date" class="form-label">Hire Date</label>
                                    <input type="date" class="form-control" name="hire_date" id='hire_date' placeholder="Hire Date" onkeydown="return false" 
                                           min="<?php echo date('Y-m-d', strtotime('-59 days')); ?>" 
                                           max="<?php echo date('Y-m-d'); ?>" required>

                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" name="status" id='status' placeholder="Status" value="Active" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="employee_type" class="form-label">Employee Type</label>
                                    <select class="form-control" name="employee_type" id='employee_type' required>
                                        <option value="Select Employee Type">Select Employee Type</option>
                                        <option value="EF">EF ( Franchaise )</option>
                                        <option value="ES">ES ( Employee )</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" id="location" placeholder="Location" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="zone" class="form-label">Zone</label>
                                    <select class="form-control" name="zone" id="zone" required>
                                        <option value="">Select Zone</option>
                                        <option value="Head Office">Head Office</option>
                                        <option value="Central">Central</option>
                                        <option value="North">North</option>
                                        <option value="East">East</option>
                                        <option value="West">West</option>
                                        <option value="South">South</option>
                                        <option value="West">West</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="access_id" class="form-label">Access ID</label>
                                    <select class="form-control" name="access_id" id="access_id" required>
                                        <option value="">Select Access ID</option>
                                        <option value="1">1 - View(State Head / Zonal Head)</option>
                                        <option value="2">2 - Entry Creation(SM / AM / CH)</option>
                                        <option value="3">3 - Maker-Checker(Operation)</option>
                                    <select>
                                </div>

                            </div>
                            <div class="mt-4">
                                <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                            <div class="mt-4">
                            <a href="it_admin.php" class="btn btn-warning w-100">Home</a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <script>
        function selectfunction() {
            var desg = document.getElementById("designation").value;


            //alert(desg);
            //console.log(desg); 

            $.ajax({
                url: "show_function.php",
                type: "POST",
                data: {
                    desg: desg

                },
                success: function(data) {
                    $("#functionality").html(data);

                }
            });
        }
    </script>

    <script>
        function selectdepartment() {
            var funct = document.getElementById("functionality").value;


            //alert(funct);
            console.log(funct); 

            $.ajax({
                url: "show_department.php",
                type: "POST",
                data: {
                    funct: funct

                },
                success: function(data) {
                    $("#department").html(data);

                }
            });
        }
    </script>

    <script>
        function selectmappedzoneid() {
            var mz = document.getElementById("mapped_zone").value;


            //alert(mz);
            //console.log(mz); 

            $.ajax({
                url: "select_mzid.php",
                type: "POST",
                data: {
                    mz: mz

                },
                success: function(data) {

                    document.getElementById("mapped_zone_id").value = data; // Use document.getElementById instead of $

                }
            });
        }
    </script>
<script>
$(document).ready(function() {
    $("#reporting_name").select2({
        width: '100%',  // Ensures Select2 adjusts properly
        placeholder: "Search Reporting Name",
        allowClear: true
    });
});
</script>
    <script>
        function selectecode() {
            var mz = document.getElementById("reporting_name").value;


            //alert(mz);
            //console.log(mz); 

            $.ajax({
                url: "select_ecode.php",
                type: "POST",
                data: {
                    mz: mz

                },
                success: function(data) {

                    document.getElementById("reporting_ecode").value = data; // Use document.getElementById instead of $

                }
            });
        }
    </script>

    <script>
        function check_e_code(e_code) {
    console.log(e_code);

    $.ajax({
        url: "check_ecode.php",
        type: "POST",
        data: { e_code: e_code },
        success: function(data) {
            console.log("Response:", data); // Debugging output

            if (data.startsWith("exists")) {
                var response = data.split(",");
                if (response.length >= 3) {
                    var eCode = response[1];
                    var name = response[2];
                    alert("E Code: " + eCode + "\nName: " + name + "\nE Code already exists!");
                    document.getElementById("myForm").reset();
                } else {
                    console.error("Invalid response format");
                }
            } else if (data === "not_exists") {
                console.log("E Code does not exist.");
            } else {
                console.error("Unexpected response:", data);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
  </script>



</body>

</html>