<?php
include('db.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if(!$con){
    die("Connection failed: " . mysqli_connect_error());
    
}
if(isset($_POST['submit'])){
    $entryDateLabel = $_POST['entrydate'];

    // Query to retrieve data from the daily_booking table
    $query = "SELECT 
              entry_date, state_name, product_type, sub_product, segment, rto_code, rto_location, policy_no, customer_name, customer_contact_number,
              policy_sold_date, plan_name, business_type, ncb, policy_start_date, policy_end_date, sold_by, vehicle_registration_no, date_of_registration,
              age_of_the_vehicle, engine_number, chassi_number, make, model, fuel_type, gvw_cc, seating_capacity, insurer, total_premium, net_premium, od_premium, tp_premium,
              cpa_premium, terrorism_premium, payment_mode, cheque_number, payout_required, pos_code, pos_name, non_pos_name, location_name, sm_name, od_inward, tp_inward, net_inward,
              od_outward, tp_outward, net_outward, remarks
              FROM daily_booking WHERE entry_date = '$entryDateLabel'";
    $result = mysqli_query($con, $query);

    //create a new Excel file
    $objPHPExcel = new PHPExcel();

    //Set the active sheet
    $objPHPExcel->setActiveSheetIndex(0);

    //set  the header
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Entry Date');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'State Name');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Product Type');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Sub Product');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Segment');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'RTO Code');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'RTO Location');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Policy No');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Customer Name');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Customer Contact Number');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Policy Sold Date');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Plan Name');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Business Type');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'NCB');
    $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Policy Start Date');
    $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Policy End Date');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Sold By');
    $objPHPExcel->getActiveSheet()->setCellValue('R1', 'Vehicle Registration No');
    $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Date of Registration');
    $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Age of the Vehicle');
    $objPHPExcel->getActiveSheet()->setCellValue('U1', 'Engine Number');
    $objPHPExcel->getActiveSheet()->setCellValue('V1', 'Chassi Number');
    $objPHPExcel->getActiveSheet()->setCellValue('W1', 'Make');
    $objPHPExcel->getActiveSheet()->setCellValue('X1', 'Model');
    $objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Fuel Type');
    $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'GVW CC');
    $objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Seating Capacity');
    $objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Insurer');
    $objPHPExcel->getActiveSheet()->setCellValue('AC1', 'Total Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AD1', 'Net Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AE1', 'OD Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AF1', 'TP Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AG1', 'CPA Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AH1', 'Terrorism Premium');
    $objPHPExcel->getActiveSheet()->setCellValue('AI1', 'Payment Mode');
    $objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'Cheque Number');
    $objPHPExcel->getActiveSheet()->setCellValue('AK1', 'Payout Required');
    $objPHPExcel->getActiveSheet()->setCellValue('AL1', 'POS Code');
    $objPHPExcel->getActiveSheet()->setCellValue('AM1', 'POS Name');
    $objPHPExcel->getActiveSheet()->setCellValue('AN1', 'Non-POS Name');
    $objPHPExcel->getActiveSheet()->setCellValue('AO1', 'Location Name');
    $objPHPExcel->getActiveSheet()->setCellValue('AP1', 'OD Inward');
    $objPHPExcel->getActiveSheet()->setCellValue('AQ1', 'TP Inward');
    $objPHPExcel->getActiveSheet()->setCellValue('AR1', 'NET Inward');
    $objPHPExcel->getActiveSheet()->setCellValue('AS1', 'OD Outward');
    $objPHPExcel->getActiveSheet()->setCellValue('AT1', 'TP Outward');
    $objPHPExcel->getActiveSheet()->setCellValue('AU1', 'NET Outward');
    $objPHPExcel->getActiveSheet()->setCellValue('AU1', 'Remarks');

    // Loop through the result
    $rowCount = 2;
    while($fetch = mysqli_fetch_array($result)){
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $fetch['entry_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $fetch['state_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $fetch['product_type']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $fetch['sub_product']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $fetch['segment']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $fetch['rto_code']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $fetch['rto_location']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount,"'".$fetch['policy_no'],PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount, $fetch['customer_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount, $fetch['customer_contact_number']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$rowCount, $fetch['policy_sold_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$rowCount, $fetch['plan_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$rowCount, $fetch['business_type']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$rowCount, $fetch['ncb']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowCount, $fetch['policy_start_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$rowCount, $fetch['policy_end_date']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$rowCount, $fetch['sold_by']);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$rowCount, $fetch['vehicle_registration_no']);
        $objPHPExcel->getActiveSheet()->setCellValue('S'.$rowCount, $fetch['date_of_registration']);
        $objPHPExcel->getActiveSheet()->setCellValue('T'.$rowCount, $fetch['make']);
        $objPHPExcel->getActiveSheet()->setCellValue('U'.$rowCount, $fetch['model']);
        $objPHPExcel->getActiveSheet()->setCellValue('V'.$rowCount, $fetch['fuel_type']);
        $objPHPExcel->getActiveSheet()->setCellValue('W'.$rowCount, $fetch['gvw_cc']);
        $objPHPExcel->getActiveSheet()->setCellValue('X'.$rowCount, $fetch['seating_capacity']);
        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$rowCount, $fetch['insurer']);
        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$rowCount, $fetch['total_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$rowCount, $fetch['net_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$rowCount, $fetch['od_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$rowCount, $fetch['tp_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AD'.$rowCount, $fetch['cpa_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$rowCount, $fetch['terrorism_premium']);
        $objPHPExcel->getActiveSheet()->setCellValue('AF'.$rowCount, $fetch['payment_mode']);
        $objPHPExcel->getActiveSheet()->setCellValue('AG'.$rowCount, $fetch['cheque_number']);
        $objPHPExcel->getActiveSheet()->setCellValue('AH'.$rowCount, $fetch['payout_required']);
        $objPHPExcel->getActiveSheet()->setCellValue('AI'.$rowCount, $fetch['pos_code']);
        $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$rowCount, $fetch['pos_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('AK'.$rowCount, $fetch['non_pos_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('AL'.$rowCount, $fetch['location_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('AM'.$rowCount, $fetch['od_inward']);
        $objPHPExcel->getActiveSheet()->setCellValue('AN'.$rowCount, $fetch['tp_inward']);
        $objPHPExcel->getActiveSheet()->setCellValue('AO'.$rowCount, $fetch['net_inward']);
        $objPHPExcel->getActiveSheet()->setCellValue('AP'.$rowCount, $fetch['od_outward']);
        $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$rowCount, $fetch['tp_outward']);
        $objPHPExcel->getActiveSheet()->setCellValue('AR'.$rowCount, $fetch['net_outward']);
        $objPHPExcel->getActiveSheet()->setCellValue('As'.$rowCount,$fetch['remarks']);
        $rowCount++;
    }

        // Set the file name and headers
        $filename = 'Report_'.$date.'_'.$time.'.xls'; // Set your
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        //Output the Excel File
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    




}
mysqli_close($con);
?>