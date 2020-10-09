<?php
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        header("location: dashboard.php");
        exit;
    }

    if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"] == true){
        header("location: dashboard.php");
        exit;
    }

    include('connection.php');
    $email = $password = $err = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Check if email field is  empty
        if(empty(trim($_POST['email'])) || empty(trim($_POST['pass']))){
            $err = "Please fill all the fields.";
        } 

        // Check if entered email is valid
        else if(!(filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL))){
            $err = "Please enter a valid email";
        } 
        else {
            $email = $_POST['email'];  
            $password = $_POST['pass'];

            $sql = "SELECT * FROM users where email='$email'";
            $result = $conn->query($sql);

            // Check if a user exists with the given mail
            if (isset($result->num_rows) && $result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if(password_verify($password, $row['password'])){ 

                        // Set cookies if remember me is ticked
                        // otherwise set session variable so that user can still login
                        // one time
                        if(!empty($_POST["remember"])){
                            setcookie('loggedin', true, time()+86400);
                            setcookie('email', $email, time()+86400);
                            setcookie('firstname', $row['firstname'], time()+86400);
                            setcookie('password', $password, time()+86400);
                        }else{
                            $_SESSION['loggedin'] = true;
                            $_SESSION['firstname'] = $row['firstname'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['roleid'] = $row['roleid'];
                        }
                        
                        // after setting cookie/session variable, redirect user to dashboard
                        header("location: dashboard.php");
                        $conn->close();
                        exit;
                    }else{
                        // If password is incorrect
                        $err = "Incorrect password";
                    }
                }
            } else {
                // If no account exists with the given email
                $err = "No account exists with the entered email.";
            }
        }
        
        $conn->close();
    }
?>

<?php  
    require "header.php";
?>
    <main>
        <div class="container mt-5">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php echo $email?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="pass" class="form-control" id="pass" value="<?php echo $password?>">
                </div>
                <br/>
                <div class="input-group mb-3">
                    <input type="checkbox" id="remember" name="remember">Remember Me
                </div>

                <span style="color: red;"><?php echo $err; ?></span>
                <br/><br/>
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary" name="login-submit">Log In</button>
                </div>
            </form>
        </div>
        
    </main>

<?php  
    require "footer.php";
    if(isset($_COOKIE['email']) and isset($_COOKIE['password'])){

        $email    = $_COOKIE['email'];
        $password = $_COOKIE['password'];
        
        echo "<script>
        console.log('hi');
        document.getElementById('email').value = '$email';
        document.getElementById('pass').value = '$password';
        
        </script>";

    }

?>