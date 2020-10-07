<?php
    session_start();
    // if user is not logged in, redirect to login page
    /*if( !(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) ){
        header("location: login.php");
        exit;
    }*/

    // check if cookie variable is set. If it is not, then check for
    // session variable. If that is not set too, then redirect to login page
    if( !isset($_COOKIE["loggedin"]) || $_COOKIE["loggedin"] == false ){
        if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false ){
            header("location: login.php");
            exit;
        }
    }
?>

<?php  
    require "header.php";
?>
    <main>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <h1>
                <?php 
                    if(isset($_COOKIE['firstname'])){
                        echo "Welcome " . $_COOKIE['firstname'];
                    }
                    else {
                        echo "Welcome " . $_SESSION['firstname'];
                    }
                ?>
                </h1>
                <form action="logout.php" method="POST">
                    <input type="submit" value="Logout" class="btn btn-secondary">
                </form>
            </div>
        </div>
    </main>
    

<?php  
    require "footer.php";
?>