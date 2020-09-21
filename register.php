
<?php 
    session_start();
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: dashboard.php");
        exit;
    }
    include('connection.php');
    $email = $password = $confirm_password = "";
    $firstname = $middlename = $lastname = "";
    $email_err = $password_err = $confirm_password_err = "";
    $firstname_err = $middlename_err = $lastname_err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // validate email
        if(empty(trim($_POST['email']))){
            $email_err = "Please enter your email.";
        } else {
            try{
                $sql = "SELECT * FROM users WHERE email = " . trim($_POST['email']);
                $result = $conn->query($sql);

                if(isset($result->num_rows) && $result->num_rows == 1) {
                    $email_err = "An account exists with this email.";
                }else {
                    $email = trim($_POST['email']);
                }
            }catch(Exception $e){
                echo "Oops! Something went wrong. Please try again.";
            }
        }

        // Validate firstname
        if(empty(trim($_POST["first_name"]))){
            $firstname_err = "Please enter your First name.";     
        } else{
            $firstname = trim($_POST["first_name"]);
        }

        // Validate middlename
        if(empty(trim($_POST["middle_name"]))){
            $middlename_err = "Please enter your Middle name.";     
        } else{
            $middlename = trim($_POST["middle_name"]);
        }

        // Validate lastname
        if(empty(trim($_POST["last_name"]))){
            $lastname_err = "Please enter your Last name.";     
        } else{
            $lastname = trim($_POST["last_name"]);
        }

        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }

        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Passwords do not match.";
            }
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // check if no error occured
        if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
            
            $sql = "INSERT INTO users (firstname, middlename, lastname, email, password, roleid)
            VALUES ('$firstname', '$middlename', '$lastname', '$email', '$hashed_password', 1)";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['loggedin'] = true;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['email'] = $email;
                $_SESSION['roleid'] = $roleid;
                header("location: dashboard.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
?>


<!--Navbar Code-->
<?php
    require "header.php";
?>

    <main>
        <div class="container mt-5">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">First name</label>
                        <input type="text" name="first_name" class="form-control" id="validationTooltip01" value="<?php echo $firstname; ?>">
                        <span style="color: red;" class="help-block"><?php echo $firstname_err?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control" id="validationTooltip01" value="<?php echo $middlename; ?>">
                        <span style="color: red;" class="help-block"><?php echo $middlename_err?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Last name</label>
                        <input type="text" name="last_name" class="form-control" id="validationTooltip02" value="<?php echo $lastname; ?>">
                        <span style="color: red;" class="help-block"><?php echo $lastname_err?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Email</label>
                        <input type="email" name="email" class="form-control" id="validationTooltip01" value="<?php echo $email; ?>">
                        <span style="color: red;" class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip02">Password</label>
                        <input type="password" name="password" class="form-control" id="validationTooltip02" value="<?php echo $password; ?>">
                        <span style="color: red;" class="help-block"><?php echo $password_err; ?></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip01">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="validationTooltip01" value="<?php echo $confirm_password; ?>">
                        <span style="color: red;" class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="register-submit">Submit form</button>
            </form>
        </div>
        
    </main>

<!--Footer Code-->
<?php  
    require "footer.php";
?>

<!--

<div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationTooltip03">City</label>
                        <input type="text" class="form-control" id="validationTooltip03">
                        <div class="invalid-tooltip">
                            Please provide a valid city.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationTooltip04">State</label>
                        <select class="custom-select" id="validationTooltip04">
                            <option selected disabled value="">Choose...</option>
                            <option>...</option>
                        </select>
                        <div class="invalid-tooltip">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationTooltip05">Zip</label>
                        <input type="text" class="form-control" id="validationTooltip05">
                        <div class="invalid-tooltip">
                            Please provide a valid zip.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <select class="custom-select">
                        <option value="">Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                </div>

-->