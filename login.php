<?php
    session_start();
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: dashboard.php");
        exit;
    }

    include('connection.php');
    $email = $password = $err = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(empty(trim($_POST['email'])) || empty(trim($_POST['pass']))){
            $err = "Please fill all the fields.";
        } else {
            $email = $_POST['email'];  
            $password = $_POST['pass'];
            $remember = $_POST['remember'];


            




            $sql = "SELECT * FROM users where email='$email'";
            $result = $conn->query($sql);

            if (isset($result->num_rows) && $result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    if(password_verify($password, $row['password'])){ 
                        $_SESSION['loggedin'] = true;
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['roleid'] = $row['roleid'];

                        //SET COOKIES
                        if(isset($_POST['remember'])){
                            setcookie('email',$email,time()+300);
                            setcookie('password',$password,time()+300);
                        }

                        header("location: dashboard.php");
                        $conn->close();



                        exit;
                    }else{
                        $err = "Incorrect password";
                    }
                    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                }
            } else {
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
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php echo $email?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="pass" class="form-control" id="pass" value="<?php echo $password?>">
                </div>
                <br/>
                <div class="input-group mb-3">
                    
                        
                            <input type="checkbox" aria-label="Checkbox for following text input" name="remember" value="1"><span>Remember Me</span>
                            
                    
                    
                </div>

                <span style="color: red;"><?php echo $err; ?></span>
                <br/><br/>
                <button type="submit" class="btn btn-primary" name="login-submit">Submit</button>
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