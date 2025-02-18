<?php

require_once 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Check if the PDF file was uploaded
if (isset($_FILES['pdf_file'])) {
    $pdfFile = $_FILES['pdf_file']['tmp_name'];
    // Parse the PDF file
    $parser = new Parser();
    $pdf = $parser->parseFile($pdfFile);
    $text = $pdf->getText();
    // Use regular expressions to extract specific data fields
    preg_match('/Name & Address of Insured (.*)/', $text, $insuredNameMatches);
    preg_match('/Address: (.*)/', $text, $insuredAddressMatches);
    preg_match('/Policy Number: (.*)/', $text, $premiumMatches);
    preg_match('/Premium Paid: (.*)/', $text, $vehicleDetailsMatches);
    // Return the extracted data as JSON
    $data = array(
        'Name' => $insuredNameMatches[1] ?? null,
        'Address' => $insuredAddressMatches[1] ?? null,
        'Policy_Number' => $premiumMatches[1] ?? null,
        'Premium_Paid' => $vehicleDetailsMatches[1] ?? null
    );
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'No PDF file uploaded'));
    exit;
}

?>