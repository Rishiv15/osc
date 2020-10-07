<?php  
    session_start();
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: dashboard.php");
        exit;
    }

    if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"] == true){
        header("location: dashboard.php");
        exit;
    }
    
    require "header.php";
?>

    <main class="text-center">
        <h1>Home Page</h1>
    </main>

<?php  
    require "footer.php";
?>