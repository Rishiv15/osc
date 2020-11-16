<?php
    $connection = mysqli_connect("localhost", "root", "", "mydb");

    session_start();
    $name = $_GET['name'];
    $address = $_GET['address'];
    $card_number = $_GET['card_number'];
    $cart_items = $_SESSION['cart_item'];
    
    foreach($cart_items as $item){
        $id =  $item["id"];
        $quantity = $item["quantity"];
        //if(!mysqli_query($connection, "CALL updateQuantity($id, $quantity)")){
        //    echo "Failed: " . mysqli_error($connection);
        //}
    }
    
    $sum = 0;
    foreach($cart_items as $item){
        $sum += ($item["quantity"]*$item["price"]);
    }

    $cart = serialize($cart_items);
    if(!mysqli_query($connection, "CALL addOrder('$cart', '$name', '$address', '$card_number', $sum)")){
        echo "Failed: " . mysqli_error($connection);
    }
    


    echo "Payment Successful!";
?>