<?php
session_start();
session_unset();
session_destroy();
echo "<script>alert('User successfully logedout')</script>";
echo "<script>window.location='index.php'</script>";
?>