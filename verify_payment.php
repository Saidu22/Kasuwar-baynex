<?php
session_start();
include "../config/database.php";

if(!isset($_GET['reference'])){
    die("No reference");
}

$reference = $_GET['reference'];
$secret_key = "sk_test_86b0948e595c384e88e1cad7a89d800893638c80";

/* Verify Payment */
$url = "https://api.paystack.co/transaction/verify/" . $reference;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key"
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if($result['data']['status'] == "success") {

    if(!isset($_SESSION['user_id'])){
        die("User not logged in");
    }

    $user_id = $_SESSION['user_id'];

    /* GET CART ITEMS FIRST */
    $cart = $conn->query("
    SELECT cart.*, products.price 
    FROM cart 
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id='$user_id'
    ");

    if($cart->num_rows == 0){
        die("❌ Cart is empty. Nothing to save.");
    }

    /* CREATE ORDER */
    $conn->query("
    INSERT INTO orders (user_id, reference, status)
    VALUES ('$user_id','$reference','paid')
    ");

    $order_id = $conn->insert_id;

    /* SAVE EACH ITEM */
    while($item = $cart->fetch_assoc()){

        $product_id = $item['product_id'];
        $qty = $item['quantity'];
        $price = $item['price'];

        // Insert into order_items
        $conn->query("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES ('$order_id','$product_id','$qty','$price')
        ");

        // Reduce stock
        $conn->query("
        UPDATE products 
        SET stock = stock - $qty 
        WHERE id='$product_id'
        ");
    }

    /* CLEAR CART */
    $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

    echo "<h2>✅ Payment Successful</h2>";
    echo "<a href='../index.php'>Go Home</a>";

} else {
    echo "<h2>❌ Payment Failed</h2>";
}
?>
