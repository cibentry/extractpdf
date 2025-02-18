<?php
session_start();
require 'db.php'; // Connect to your Hostinger database
require 'includes/PHPMailer/PHPMailer.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Database connection
    //$conn = new mysqli('localhost', 'your_db_username', 'your_db_password', 'your_db_name');
    if ($con->connect_error) {
        die("Database connection failed: " . $con->connect_error);
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // Check if email exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update OTP and expiry
        $update_query = "UPDATE users SET otp = ?, otp_expiry = ? WHERE email = ?";
        $update_stmt = $con->prepare($update_query);
        $update_stmt->bind_param("iss", $otp, $otp_expiry, $email);
        $update_stmt->execute();
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (email, otp, otp_expiry) VALUES (?, ?, ?)";
        $insert_stmt = $con->prepare($insert_query);
        $insert_stmt->bind_param("sis", $email, $otp, $otp_expiry);
        $insert_stmt->execute();
    }

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@cibentry.com';
        $mail->Password = 'Apple.@2025';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('noreply@cibentry.com', 'www.cibentry.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP is <b>$otp</b>. It is valid for 10 minutes.";

        $mail->send();
        echo "OTP sent successfully to $email.";
        $_SESSION['email'] = $email;
        header("Location: verify_otp.php");
    } catch (Exception $e) {
        echo "Email sending failed: " . $mail->ErrorInfo;
    }
}
?>
