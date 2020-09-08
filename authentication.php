<?php
    include('connection.php');
    $email = $_POST['email'];  
    $password = $_POST['pass'];  
     
    
    $sql = "SELECT * FROM users where email='$email'";
    $result = $conn->query($sql);

    if (isset($result->num_rows) && $result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(password_verify($password, $row['password'])){
                echo "<h1>Welcome " . $row['firstname'] . "</h1>";
            }else{
                echo "<h1 style='color:red'>Incorrect password</h1>";
            }
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        }
    } else {
    echo "<h1>Invalid username or password.</h1>";
    }
    $conn->close();
?>