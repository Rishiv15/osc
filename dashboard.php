<?php
    session_start();
    // if user is not logged in, redirect to login page
    if( !(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) ){
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php echo "Welcome " . $_SESSION['firstname'] ?>
    <form action="logout.php" method="POST">
        <input type="submit" value="Logout" >
    </form>
</body>
</html>