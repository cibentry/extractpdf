<?php
$file = $_GET['file'];
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Type: application/pdf');
readfile('uploads/' . $file);
exit;
?>