<?php
require 'vendor/autoload.php'; // Load the PDF parser library

use Smalot\PdfParser\Parser;

function extract_policy_details($pdf_path) {
    $parser = new Parser();
    $pdf = $parser->parseFile($pdf_path);
    $text = $pdf->getText(); // Extract text from PDF

    $data = [
        "Name" => extract_value("/Name\s*([A-Z\s]+)\n/", $text),
        "Policy No" => extract_value("/Policy No\.\s([\d\/]+)/", $text),
        "Vehicle No" => extract_value("/Registration No\.?\s*[:]?([\w\d-]+)/i", $text),
        "Engine No" => extract_value("/Engine No\.?\s*\/?\s*Motor No\.?\s*\(for EV\)\s*[:]?([\w\d]+)/i", $text),


        "Chassis No" => extract_value("/Chassis No.\s*([\w\d]+)/", $text),
        "RTO Location" => extract_value("/RTO Location\s*([\w\s]+)/", $text),
        "Manufacturing Year" => extract_value("/Mfg. Year\s*(\d{4})/", $text),
        "GVW or CC" => extract_value("/CC\/KW\s*(\d+)/", $text),
        "Seating Capacity" => extract_value("/Licensed Carrying Capacity Including Driver\s*(\d+)/", $text),
        "Total Own Damage Premium" => extract_value("/Total Own Damage Premium\s*₹?\s*([\d,]+)/", $text),
        "Net Premium" => extract_value("/Net Premium\s*₹?\s*([\d,]+)/", $text),
        "Total Premium" => extract_value("/Total Policy Premium\s*₹?\s*([\d,]+)/", $text),
    ];

    return $data;
}

function extract_value($pattern, $text) {
    preg_match($pattern, $text, $matches);
    return isset($matches[1]) ? trim($matches[1]) : "Not Found";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["policy_pdf"])) {
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . basename($_FILES["policy_pdf"]["name"]);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["policy_pdf"]["tmp_name"], $uploadFile)) {
        $policyDetails = extract_policy_details($uploadFile);
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extract Insurance Policy Details</title>
</head>
<body>

<h2>Upload Insurance Policy PDF</h2>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="policy_pdf" required>
    <button type="submit">Upload and Extract</button>
</form>

<?php if (!empty($policyDetails)): ?>
    <h2>Extracted Policy Details</h2>
    <table border="1">
        <tr><th>Field</th><th>Value</th></tr>
        <?php foreach ($policyDetails as $key => $value): ?>
            <tr><td><?php echo htmlspecialchars($key); ?></td><td><?php echo htmlspecialchars($value); ?></td></tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>