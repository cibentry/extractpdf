<?php
require_once 'db.php';
require 'vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Create a new PHPMailer instance
$mail = new PHPMailer(true);

require_once __DIR__ . '/vendor/autoload.php';

session_start();
error_reporting(E_ERROR | E_PARSE);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['send_otp'])) {
        $username = $_POST['username'];

        // Check if the email exists in the database
        $sql = mysqli_query($con, "SELECT * FROM newemp WHERE email_id = '$username'") or die(mysqli_error($con));
        $result = mysqli_fetch_array($sql);

        if ($result) {

            $otp = rand(100000, 999999); // Generate a 6-digit OTP
            $_SESSION['otp'] = $otp;
            $_SESSION['username'] = $username;

            if ($username == 'directors@certigoinsurance.com') {
                $directors_emails = [
                    'singh17041@gmail.com',
                    'dhirajsingh@certigoinsurance.com',
                    'mabhishekmondal1985@gmail.com',
                    'abhishek.finmart@gmail.com'
                ];
                // Send OTP to each director's email
                foreach ($directors_emails as $email) {
                    $mail->addAddress($email);  // Add each director's email
                }
            } else {
                // Send OTP to the user email as usual
                $mail->addAddress($username);
            }

            // Send OTP to email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com'; // Use your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply@cibentry.com'; // Replace with your email
                $mail->Password = 'Apple.@2025'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('noreply@cibentry.com', 'CIBEntry');
                $mail->addAddress($username);
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP for login is <b>$otp</b>. It is valid for 5 minutes.";

                $mail->send();
                echo "<script>alert('OTP has been sent to your email.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Failed to send OTP. Please try again. Error: " . $e->getMessage() . "');</script>";
            }
        }
    }

    // Now handle the OTP verification separately
    if (isset($_POST['verify_otp'])) {
        $otp = $_POST['otp'];

        if ($_SESSION['otp'] == $otp) {
            $username = $_SESSION['username'];
            $sql = mysqli_query($con, "SELECT * FROM newemp WHERE email_id = '$username'") or die(mysqli_error($con));
            $res = mysqli_fetch_array($sql);

            $_SESSION['access_id'] = $res['access_id'];
            $_SESSION['username'] = $res['name'];

            // Redirect based on access ID
            switch ($res['access_id']) {
                case 1:
                    header('Location: dash.php');
                    exit();
                case 2:
                    header('Location: rms.php');
                    exit();
                case 3:
                    header('Location: operations.php');
                    exit();
                case 4:
                    header('Location: franchaise.php');
                    exit();
                case 5:
                    header('Location: superuser.php');
                    exit();
                case 6:
                    header('Location: pendingfranchaise.php');
                    exit();
                case 7:
                    header('Location: agent.php');
                    exit();
                case 8:
                    header('Location: directors.php');
                    exit();
                case 9:
                    header('Location: hrm.php');
                    exit();
                case 10:
                    header('Location: hooperations.php');
                    exit();
            }
        } else {
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login with OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('uploads/insurance-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <h1 style="color: white;">Login Page</h1>
    <div class="container-form m-auto my-5 P-5 m-5" style="width:30%; position: relative;">
        <div class="container-heading bg-success bg-gradient fw-bold fs-3 text-center">Login</div>
        <form method="POST">
            <div class="row my-2 m-auto">
                <div class="col sm-3">
                    <input type="text" class="form-control" name="username" placeholder="Enter Official Email ID" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                </div>
                <div class="col sm-3">
                    <button type="submit" name="send_otp" class="form-control bg-primary text-white">Send OTP</button>
                </div>
            </div>
        </form>
        <form method="POST">
            <div class="row my-2 m-auto">
                <div class="col sm-3">
                    <input type="number" class="form-control" name="otp" placeholder="Enter OTP" required>
                </div>
                <div class="col sm-3">
                    <button type="submit" name="verify_otp" class="form-control bg-primary text-white">Verify OTP</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>