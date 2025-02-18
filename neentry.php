<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
ini_set('session.gc_maxlifetime', 180);
include('db.php');

if (isset($_SESSION['last_entry_no'])) {
    echo "<script>alert('Last Entry Number: " . $_SESSION['last_entry_no'] . "');</script>";
    unset($_SESSION['last_entry_no']);
}

$zonequery = mysqli_query($con, "SELECT * FROM `login_master` WHERE `name`='$_SESSION[username]'") or die(mysqli_error($con));
$zonefetch = mysqli_fetch_array($zonequery);
$zonename = $zonefetch['mapped_zone'];
$zoneid = $zonefetch['mapped_zone_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2f7;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 1100px;
            margin-top: 40px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
            padding: 10px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        input, select, textarea {
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Business Entry</h2>
        <form id="businessForm" action="process_entry.php" method="post">
            <div class="row">
                <?php
                $fields = [
                    'entrydate' => 'Entry Date', 'rmname' => 'RM Name', 'e_code' => 'Employee Code',
                    'insuredname' => 'Insured Name', 'policyno' => 'Policy No.', 'vehicleno' => 'Vehicle No.',
                    'engineno' => 'Engine No.', 'cheque_no' => 'Cheque No.', 'state' => 'State',
                    'city' => 'City', 'pincode' => 'Pincode', 'premium' => 'Premium Amount'
                ];
                foreach ($fields as $name => $label) {
                    echo "<div class='col-md-6 mb-3'>
                            <label class='form-label'>$label</label>
                            <input type='text' class='form-control' name='$name' required>
                          </div>";
                }
                ?>
            </div>
            <div class="row">
                <?php
                $selects = [
                    'manager' => 'Manager', 'agent' => 'Agent', 'producttype' => 'Product Type',
                    'plan' => 'Plan', 'insuranceco' => 'Insurance Co.', 'businesstype' => 'Business Type',
                    'fueltype' => 'Fuel Type', 'paymentmode' => 'Payment Mode'
                ];
                foreach ($selects as $name => $label) {
                    echo "<div class='col-md-6 mb-3'>
                            <label class='form-label'>$label</label>
                            <select class='form-control' name='$name' required>
                                <option value=''>Select $label</option>
                            </select>
                          </div>";
                }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#businessForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'process_entry.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Form submitted successfully!');
                    }
                });
            });
        });
    </script>
</body>
</html>
