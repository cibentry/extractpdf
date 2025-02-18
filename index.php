<?php
require_once 'db.php';



error_reporting(E_ERROR | E_PARSE);
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($con, "select * from login_master where email_id = '$username' and password ='$password'") or die(mysqli_error());

    $res = mysqli_fetch_array($sql);

    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        $_SESSION['access_id'] = $res['access_id'];
        $_SESSION['username'] = $res['name'];
        switch ($res['access_id']) {
            case 1:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: dash.php');
                exit(); // Make sure to exit after redirecting

            case 2:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: rms.php');
                exit(); // Make sure to exit after redirecting

            case 3:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: operations.php');
                exit(); // Make sure to exit after redirecting

            case 4:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: franchaise.php');
                exit(); // Make sure to exit after redirecting

            case 5:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: superuser.php');
                exit(); // Make sure to exit after redirecting
            case 6:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: pendingfranchaise.php');
                exit(); // Make sure to exit after redirecting
            case 7:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: agent.php');
                exit(); // Make sure to exit after redirecting
            case 8:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: directors.php');
                exit(); // Make sure to exit after redirecting
            case 10:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: hooperations.php');
                exit(); // Make sure to exit after redirecting
            case 11:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: it_admin.php');
                exit(); // Make sure to exit after redirecting

        }
    } else {
        echo "<script>alert('Invalid username or password')</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CIB Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Fullscreen Background */
body {
    background: url('assets/insback.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: Arial, sans-serif;
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Centering the Login Box */
.container {
    width: 100%;
    max-width: 1000px; /* Adjust as needed */
}

/* Login Card Styling */
.card {
    backdrop-filter: blur(8px);
    background: rgba(255, 255, 255, 0.85); /* Semi-transparent white */
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: 100%;
}

/* Role Selection Buttons */
.btn-group .btn {
    width: 33%;
}


    </style>
</head>

<body>
   
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <img src="assets/cibentrylogo.png" alt="Logo" class="mb-3" width="150">
                        <h4 class="mb-4">Welcome to CIB Entry</h4>
                        <form method="POST">
                            <div class="row my-2 m-auto">
                                <input type="text" class="form-control " name="username" placeholder="Enter Officail Email id">
                            </div>
                            <div class="input-group my-2 m-auto w-100">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                                    <i id="eye-icon" class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="row my-2 m-auto">
                                <input type="submit" class="form-control bg-primary text-white" name="submit">
                            </div>
                            <div class="row my-2 m-auto">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>