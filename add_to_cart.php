<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$qty = $_POST['qty'];

/* Check if product already in cart */
$check = $conn->query("
    SELECT * FROM cart 
    WHERE user_id='$user_id' AND product_id='$product_id'
");

if($check && $check->num_rows > 0){
    $conn->query("
        UPDATE cart 
        SET quantity = quantity + $qty 
        WHERE user_id='$user_id' AND product_id='$product_id'
    ");
} else {
    $conn->query("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES ('$user_id','$product_id','$qty')
    ");
}

/* Redirect to cart view */
header("Location: view_cart.php");
exit();
?>
