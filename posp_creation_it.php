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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h3>POSP Creation</h3>
                    </div>
                    <div class="card-body">
                        <form action="rm_save.php" method="POST" id="myForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="posp_id" class="form-label">POSP ID</label>
                                    <input type="text" class="form-control" id="posp_id" name="posp_id" placeholder="Enter POSP ID" onchange="check_e_code(this.value);" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="organisation_role" class="form-label">Organisation Role</label>
                                    <input type="text" class="form-control" id="organisation_role" name="organisation_role" readonly required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter your Name" required
                                        >
                                    
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email_id" class="form-label">Email ID</label>
                                    <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_no" class="form-label">Contact No</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Enter Contact No" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="Enter District" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state_name" class="form-label">State Name</label>
                                    <select class="form-select" name="state_name" id="state_name" aria-label="Default select example" required>
                                        <option value="">Select</option>
                                        <?php
                                                $query = mysqli_query($con, "SELECT DISTINCT state_name FROM `zone_list` ORDER BY state_name ASC;") or die(mysqli_error());
                                                while ($fetch = mysqli_fetch_array($query)) {
                                                    echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                                }   
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                        <label for="mapped_zone" class="form-label">Mapped Zone</label>
                                        <select class = "form-select" name="mapped_zone" id="mapped_zone" aria-label="Default select example" onclick="selectzone();" onblur="selectrm();" required> 
                                            <?php
                                                $query = mysqli_query($con, "SELECT DISTINCT state_name FROM `zone_list` ORDER BY state_name ASC;") or die(mysqli_error());
                                                while ($fetch = mysqli_fetch_array($query)) {
                                                    echo "<option value='" . $fetch['state_name'] . "'>" . $fetch['state_name'] . "</option>";
                                                }   
                                            ?>
                                        </select>
                                    </div>
                                <div class="col-md-6 mb-3">
                                    <label for="mapped_zone_id" class="form-label">Mapped Zone ID</label>
                                    <input type="text" class="form-control" id="mapped_zone_id" name="mapped_zone_id" placeholder="Enter Mapped Zone ID" required>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rm_name" class="form-label">RM Name</label>
                                    <select class="form-select" name="rm_name" id="rm_name" aria-label="Default select example" onchange="setdetails();" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rm_number" class="form-label">RM Number</label>
                                    <input type="text" class="form-control" id="rm_number" name="rm_number" placeholder="Enter RM Number" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="e_code" class="form-label">E Code</label>
                                    <input type="text" class="form-control" id="e_code" name="e_code" placeholder="Enter E Code" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pincode" class="form-label">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="zone" class="form-label">Zone</label>
                                    <input type="text" class="form-control" id="zone" name="zone" placeholder="Enter Zone" required>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="retention" class="form-label">Retention</label>
                                    <input type="text" class="form-control" id="retention" name="retention" placeholder="Enter Retention" required>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="portal_access" class="form-label">Portal Access</label>
                                <input type="text" class="form-control" id="portal_access" name="portal_access" readonly required>
                            </div>  
                                
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary w-50">Submit</button>
                            </div>
                            <div class="mt-4">
                            <a href="it_admin.php" class="btn btn-warning w-100">Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        <script>
            $('#mapped_zone').on('change', function() {
                var zone = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'fetch_zone_id.php',
                    data: {
                        zone: zone
                    },
                    success: function(data) {
                        $('#mapped_zone_id').val(data);
                    }
                });
            });
        </script>
        
        <script>
            $('#mapped_zone').on('blur', function() {
                var mappedzone = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'fetch_rm.php',
                    data: {
                        mappedzone: mappedzone
                    },
                    success: function(data) {
                        $('#rm_name').html(data);
                    }
                });
            });
        </script>
        <script>
            $('#rm_name').on('change', function() {
                var rm_name = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'fetch_rm_d.php',
                    data: {
                        rm_name: rm_name
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $('#e_code').val(response.ecode);
                        $('#rm_number').val(response.contact_no);
                    }
                });
            });
        </script>
        <script>
        function check_e_code(e_code) {
    console.log(e_code);

    $.ajax({
        url: "check_posp.php",
        type: "POST",
        data: { e_code: e_code },
        success: function(data) {
            console.log("Response:", data); // Debugging output

            if (data.startsWith("exists")) {
                var response = data.split(",");
                if (response.length >= 3) {
                    var eCode = response[1];
                    var name = response[2];
                    alert("POSP ID: " + eCode + "\nName: " + name + "\nPOSP ID already exists!");
                    document.getElementById("myForm").reset();
                } else {
                    console.error("Invalid response format");
                }
            } else if (data === "not_exists") {
                console.log("E Code does not exist.");
                var trimmedCode = e_code.slice(0,3);
                
                if(trimmedCode === 'CIB'){
                    document.getElementById("organisation_role").value = "POSP";
                    document.getElementById("portal_access").value = "1";
                }else if(trimmedCode === 'CER')
                {
                    document.getElementById("organisation_role").value = "Non Posp";
                    document.getElementById("portal_access").value = "0";
                }else{
                    alert("Invalid POSP ID!");
                    document.getElementById("myForm").reset();
                }


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