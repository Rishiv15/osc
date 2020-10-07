<?php
    session_start();
    session_unset();
    session_destroy();
    setcookie('loggedin', false, time()+86400);
    setcookie('email', '', time()+86400);
    setcookie('firstname', '', time()+86400);
    setcookie('password', '', time()+86400);
    header("location: login.php");
?>