<?php

include('connection.php');
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if (isset($result->num_rows) && $result->num_rows > 0) {
    // output data of each row
    echo '<table border="1" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">ID</font> </td> 
          <td> <font face="Arial">Firstname</font> </td> 
          <td> <font face="Arial">Middlename</font> </td> 
          <td> <font face="Arial">Lastname</font> </td> 
          <td> <font face="Arial">Email</font> </td> 
          <td> <font face="Arial">Password</font> </td> 
          <td> <font face="Arial">Role id</font> </td> 
      </tr>';
    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        echo '<tr> 
                  <td>'.$row["id"].'</td> 
                  <td>'.$row["firstname"].'</td> 
                  <td>'.$row["middlename"].'</td> 
                  <td>'.$row["lastname"].'</td> 
                  <td>'.$row["email"].'</td> 
                  <td>'.$row["password"].'</td> 
                  <td>'.$row["roleid"].'</td> 
              </tr>';
    }
    echo "</table>";
} else {
    echo "Failed to load users!";
}
?>