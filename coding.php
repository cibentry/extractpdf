<?php
session_start();
include('db.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;




if (isset($_POST['submit'])) {
    $filename = $_FILES['import-file']['name'];
    $allowed_ext = array('xls', 'xlsx', 'csv');

    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    //echo "File extension: " . $file_ext . "<br>";
    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import-file']['tmp_name'];


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
        $count = "0";
        foreach ($data as $row) {
            if ($count > 0) {
                $entrydate = $row['1'];
                $state = $row['2'];
                $producttype = $row['3'];
                $subproducttype = $row['4'];
                $segmenttype = $row['5'];
                $rtocode = $row['6'];
                $rtolocation = $row['7'];
                $policynumber = $row['8'];
                $customername = $row['9'];
                $customernumber = $row['10'];
                $policysolddate = $row['11'];
                $planname = $row['12'];
                $businesstype = $row['13'];
                $ncb = $row['14'];
                $policystartdate = $row['15'];
                $policyenddate = $row['16'];
                $policysoldby = $row['17'];
                $vehicleno = $row['18'];
                $registratondate = $row['19'];
                $age = $row['20'];
                $engine = $row['22'];
                $chassis = $row['22'];
                $make = $row['23'];
                $model = $row['24'];
                $fuel = $row['25'];
                $gvwcc = $row['26'];
                $seating = $row['27'];
                $insurer = $row['28'];
                $totalpremium = $row['29'];
                $netpremium = $row['30'];
                $odpremium = $row['31'];
                $tppremium = $row['32'];
                $commissionablepremium = $row['33'];
                $cpapremium = $row['34'];
                $terrorism = $row['35'];
                $payoutmode = $row['36'];
                $chequeno = $row['37'];
                $payoutrequired = $row['38'];
                $poscode = $row['39'];
                $posname = $row['40'];
                $nonposname = $row['41'];
                $location = $row['42'];
                $smname = $row['43'];
                $odinward = $row['44'];
                $tpinward = $row['45'];
                $netinward = $row['46'];
                $odoutward = $row['47'];
                $tpoutward = $row['48'];
                $netoutward = $row['49'];
                $remarks = $row['50'];
                $llpremium = $row['51'];
                $month = $row['52'];
                $inwardpoint = $row['53'];
                $outwardpoint = $row['54'];
                $margin = $row['55'];
                $ourentryno = $row['56'];
                $fyear = $row['57'];
                $bookingstat = $row['58'];
                $mappedzone = $row['59'];
                $mappedzoneid = $row['60'];
                $filepath = $row['61'];
                $smremarks = $row['62'];

                $uploadquery = "INSERT INTO daily_booking ( 
                    entry_date, 
                    state_name, 
                    product_type, 
                    sub_product,
                    segment, 
                    rto_code, 
                    rto_location,
                    policy_no, 
                    customer_name, 
                    customer_contact_number, 
                    policy_sold_date, 
                    plan_name, 
                    business_type, 
                    ncb, 
                    policy_start_date,
                    policy_end_date, 
                    sold_by, 
                    vehicle_registration_no, 
                    date_of_registration, 
                    age_of_the_vehicle, 
                    engine_number,
                    chassi_number, 
                    make, 
                    model, 
                    fuel_type, 
                    gvw_cc, 
                    seating_capacity, 
                    insurer, 
                    total_premium, 
                    net_premium,
                    commissionable_premium, 
                    od_premium,
                    tp_premium, 
                    cpa_premium, 
                    terrorism_premium, 
                    payment_mode, 
                    cheque_number, 
                    payout_required, 
                    pos_code, 
                    pos_name,
                    non_pos_name, 
                    location_name, 
                    sm_name, 
                    od_inward, 
                    tp_inward, 
                    net_inward, 
                    od_outward, 
                    tp_outward, 
                    net_outward,
                    remarks, 
                    ll_premium, 
                    month_name, 
                    inward_point, 
                    outward_point, 
                    margin,
                    our_entry_no,
                    f_year,
                    booking_status,
                    mapped_zone,
                    mapped_zone_id,
                    file_path,
                    sm_remarks) 
                    VALUES ('$entrydate', '$state', '$producttype',
                    '$subproducttype','$segmenttype', '$rtocode', '$rtolocation', '$policynumber', '$customername', '$customernumber', '$policysolddate', '$planname',
                    '$businesstype', '$ncb', '$policystartdate', '$policyenddate', '$policysoldby', '$vehicleno', '$registratondate', '$age', '$engine',
                    '$chassis', '$make', '$model', '$fuel', '$gvwcc', '$seating', '$insurer', '$totalpremium', '$netpremium', '$odpremium',
                    '$tppremium', '$commissionablepremium', '$cpapremium', '$terrorism', '$payoutmode', '$chequeno', '$payoutrequired', '$poscode', '$posname', '$nonposname',
                    '$location', '$smname', '$odinward', '$tpinward', '$netinward', '$odoutward', '$tpoutward', '$netoutward', '$remarks',
                    '$llpremium', '$month', '$inwardpoint', '$outwardpoint', '$margin','$ourentryno','$fyear','$bookingstat',
                    '$mappedzone','$mappedzoneid','$filepath','$smremarks')";
                $uploadresult = mysqli_query($con, $uploadquery);
                $totalRows = count($data);
                $msg = true;



            } else {
                $count = "1";
            }


        }

        if ($msg == true) {
            $_SESSION['message'] = "Upload Successful";
            header("Location: entryupload.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid file type";
        header(header: "Location: entryupload.php");
        exit(0);
    }
}
?>

<style>
    .spinner-container {
        visibility: hidden;
    }
</style>

<script>
    var progressBar = document.querySelector('.progress-bar');
    var spinnerContainer = document.querySelector('.spinner-container');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(new FormData(document.querySelector('form')));

    xhr.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var progress = event.loaded / event.total;
            progressBar.style.width = (progress * 100) + '%';
            progressBar.textContent = (progress * 100) + '%';
        }
    };

    xhr.onload = function (event) {
        if (xhr.status === 200) {
            spinnerContainer.classList.add('d-none'); // hide the spinner
            window.location.href = 'entryupload.php';
        }
    };

    xhr.onloadstart = function (event) {
        spinnerContainer.classList.remove('d-none'); // show the spinner
    };
</script>