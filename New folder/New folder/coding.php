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
                $entrydate = $row['0'];
                $state = $row['1'];
                $producttype = $row['2'];
                $subproducttype = $row['3'];
                $segmenttype = $row['4'];
                $rtocode = $row['5'];
                $rtolocation = $row['6'];
                $policynumber = $row['7'];
                $customername = $row['8'];
                $customernumber = $row['9'];
                $policysolddate = $row['10'];
                $planname = $row['11'];
                $businesstype = $row['12'];
                $ncb = $row['13'];
                $policystartdate = $row['14'];
                $policyenddate = $row['15'];
                $policysoldby = $row['16'];
                $vehicleno = $row['17'];
                $registratondate = $row['18'];
                $age = $row['19'];
                $engine = $row['20'];
                $chassis = $row['21'];
                $make = $row['22'];
                $model = $row['23'];
                $fuel = $row['24'];
                $gvwcc = $row['25'];
                $seating = $row['26'];
                $insurer = $row['27'];
                $totalpremium = $row['28'];
                $netpremium = $row['29'];
                $odpremium = $row['30'];
                $tppremium = $row['31'];
                $commissionablepremium = $row['32'];
                $cpapremium = $row['33'];
                $terrorism = $row['34'];
                $payoutmode = $row['35'];
                $chequeno = $row['36'];
                $payoutrequired = $row['37'];
                $poscode = $row['38'];
                $posname = $row['39'];
                $nonposname = $row['40'];
                $location = $row['41'];
                $smname = $row['42'];
                $odinward = $row['43'];
                $tpinward = $row['44'];
                $netinward = $row['45'];
                $odoutward = $row['46'];
                $tpoutward = $row['47'];
                $netoutward = $row['48'];
                $remarks = $row['49'];
                $llpremium = $row['50'];
                $month = $row['51'];
                $inwardpoint = $row['52'];
                $outwardpoint = $row['53'];
                $margin = $row['54'];
                $ourentryno = $row['55'];
                $fyear = $row['56'];
                $bookingstat = $row['57'];
                $mappedzone = $row['58'];
                $mappedzoneid = $row['59'];

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
                    payout_mode, 
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
                    booing_status,
                    mapped_zone,
                    mapped_zone_id) 
                    VALUES ('$entrydate', '$state', '$producttype',
                    '$subproducttype','$segmenttype', '$rtocode', '$rtolocation', '$policynumber', '$customername', '$customernumber', '$policysolddate', '$planname',
                    '$businesstype', '$ncb', '$policystartdate', '$policyenddate', '$policysoldby', '$vehicleno', '$registratondate', '$age', '$engine',
                    '$chassis', '$make', '$model', '$fuel', '$gvwcc', '$seating', '$insurer', '$totalpremium', '$netpremium', '$odpremium',
                    '$tppremium', '$commissionablepremium', '$cpapremium', '$terrorism', '$payoutmode', '$chequeno', '$payoutrequired', '$poscode', '$posname', '$nonposname',
                    '$location', '$smname', '$odinward', '$tpinward', '$netinward', '$odoutward', '$tpoutward', '$netoutward', '$remarks',
                    '$llpremium', '$month', '$inwardpoint', '$outwardpoint', '$margin','$ourentryno','$fyear','$bookingstat',
                    '$mappedzone','$mappedzoneid')";
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