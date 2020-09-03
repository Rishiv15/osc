<?php
    include('connection.php');
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
     
    
    $sql = "SELECT * FROM users where username='$username' and password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<h1>Welcome " . $row['firstname'] . "</h1>";
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        }
    } else {
    echo "<h1>Invalid username or password.</h1>";
    }
    $conn->close();
?>