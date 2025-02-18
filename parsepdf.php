<?php
// Check if a file was uploaded


if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
    require 'vendor/autoload.php';  // Ensure Smalot/PdfParser is installed via Composer

    // Initialize the PDF parser
    $parser = new Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($_FILES['pdf_file']['tmp_name']);
    $text = $pdf->getText();  // Extract the raw text from the PDF

    // Initialize variables to store the extracted information
    $name = '';
    $address = '';
    $policy_number = '';
    $policy_period = '';

    // Use regular expressions to extract the required data from the raw text

    // Extract the name (after "Name:")
    if (preg_match('/Name:\s*(.*?)(?=\n)/', $text, $matches)) {
        $name = trim($matches[1]);
    }

    // Extract the address (starts after "Address:" and ends before "Your Policy Details:")
    if (preg_match('/Address:(.*?)(?=Your Policy Details:)/s', $text, $matches)) {
        $address = trim(preg_replace('/\s+/', ' ', $matches[1]));  // Replace excessive spaces and line breaks
    }

    // Extract the policy number (after "Policy Number:")
    if (preg_match('/Policy Number:\s*([\d\s]+)/', $text, $matches)) {
        $policy_number = trim($matches[1]);
    }

    // Extract the policy period (starts after "Policy Period: From" and ends before "Midnight of")
    if (preg_match('/Policy Period:\s*From\s*(.*?)\s*Midnight of\s*(.*?)(?=\s|$)/s', $text, $matches)) {
        $policy_period = 'From ' . trim($matches[1]) . ' to Midnight of ' . trim($matches[2]);
    }

    // Output the extracted data as JSON
    echo json_encode([
        'Name' => $name ?: 'Not found',
        'Address' => $address ?: 'Not found',
        'Policy_Number' => $policy_number ?: 'Not found',
        'Policy_Period' => $policy_period ?: 'Not found'
    ]);
} else {
    echo json_encode(['error' => 'Failed to upload PDF file.']);
}
?>
