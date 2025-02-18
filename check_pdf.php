<?php
// Include the Composer autoloader
require 'vendor/autoload.php';

// Use the full namespace for the PdfParser
use Smalot\PdfParser\Parser as PdfParser;

// Check if a file has been uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    // Get the uploaded file and save it to a temporary location
    $pdf_file = $_FILES['pdf_file']['tmp_name'];

    // Instantiate the PDF parser
    $pdfParser = new PdfParser();

    // Parse the PDF file
    $pdf = $pdfParser->parseFile($pdf_file);

    // Get the text content from the PDF
    $text = $pdf->getText();

    // Initialize variables to store the extracted data
    $name = $policy_no = $vehicle_no = $engine_no = $chassis_no = $rto = $mfg_year = $gvw_or_cc = $seating_capacity = $own_damage_premium = '';

    // Use regular expressions to extract data from the text
    preg_match('/Insured Name\s*[:\-]?\s*(.*)/', $text, $matches);
    $name = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Updated regex for Policy No to ignore any suffix like "-00"
    preg_match('/Policy No & Certificate No\s*[:\-]?\s*(\d{10,20})/', $text, $matches);
    $policy_no = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Clean the policy number to remove "-00" if present
    $policy_no = preg_replace('/\s*-00$/', '', $policy_no);

    preg_match('/Registration no\s*[:\-]?\s*(.*)/', $text, $matches);
    $vehicle_no = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Updated regex for Engine Number to discard "/NA" if present
    preg_match('/Engine Number\/Battery Number\s*[:\-]?\s*(.*)/', $text, $matches);
    $engine_no = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Clean the engine number to remove "/NA" if present
    $engine_no = preg_replace('/\/NA$/', '', $engine_no);

    preg_match('/Chassis number\s*[:\-]?\s*(.*)/', $text, $matches);
    $chassis_no = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Updated regex to match "Registration Authority" instead of "RTO"
    preg_match('/Registration Authority\s*[:\-]?\s*(.*)/', $text, $matches);
    $rto = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    preg_match('/Mfg Year\s*[:\-]?\s*(.*)/', $text, $matches);
    $mfg_year = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    preg_match('/GVW\s*\/?\s*CC\s*[:\-]?\s*(.*)/', $text, $matches);
    $gvw_or_cc = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    preg_match('/Seating Capacity \(including driver\)\s*[:\-]?\s*(.*)/', $text, $matches);
    $seating_capacity = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    preg_match('/Total Own Damage Premium \(A\)\s*₹\s*(.*)/', $text, $matches);
    $own_damage_premium = isset($matches[1]) ? trim($matches[1]) : 'Not found';

    // Return the extracted data as JSON
    echo json_encode([
        'name' => $name,
        'policy_no' => $policy_no,
        'vehicle_no' => $vehicle_no,
        'engine_no' => $engine_no,
        'chassis_no' => $chassis_no,
        'rto' => $rto,
        'mfg_year' => $mfg_year,
        'gvw_or_cc' => $gvw_or_cc,
        'seating_capacity' => $seating_capacity,
        'own_damage_premium' => $own_damage_premium
    ]);
}
?>
