<?php
require_once 'db.php';



error_reporting(E_ERROR|E_PARSE);
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($con,"select * from newemp where email_id = '$username' and password ='$password'")or die(mysqli_error());
    
    $res = mysqli_fetch_array($sql);
    
    $count = mysqli_num_rows($sql);
    
    if($count > 0){
        $_SESSION['access_id']=$res['access_id'];
        $_SESSION['username']=$res['name'];
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
                header('Location: superuser.php');
                exit(); // Make sure to exit after redirecting

            case 5:
                echo "<script>alert('Login Successfully!')</script>";
                header('Location: superuser.php');
                exit(); // Make sure to exit after redirecting

        }
    }
    else{
        echo "<script>alert('Invalid username or password')</script>";
			echo "<script>window.location.href='login.php'</script>";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>Login Page</h1>
    <div class="container-form border border-primary m-auto my-5 P-5 m-5" style="width:40%; height=50%;">
        <div class="container-heading bg-warning bg-gradient  fw-bold fs-3 text-center">Login</div>
        <form method="POST">
            <div class="row my-2 m-auto">
                <input type="text" class="form-control " name="username" placeholder="Enter Officail Email id">
            </div>
            <div class="row my-2 m-auto">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <div class="row my-2 m-auto">
                <input type="submit" class="form-control bg-primary text-white" name="submit">
            </div>
            <div class="row my-2 m-auto">
            
            </div>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>