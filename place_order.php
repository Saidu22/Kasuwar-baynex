 <?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$cart = $conn->query("
SELECT cart.*, products.price, products.vendor_id
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;

while($row = $cart->fetch_assoc()){
$total += $row['price'] * $row['quantity'];
}

$conn->query("INSERT INTO orders (user_id,total_amount) VALUES ('$user_id','$total')");
$order_id = $conn->insert_id;

$cart = $conn->query("
SELECT cart.*, products.price, products.vendor_id
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

while($row = $cart->fetch_assoc()){

$product_id = $row['product_id'];
$vendor_id = $row['vendor_id'];
$price = $row['price'];
$qty = $row['quantity'];

$conn->query("
INSERT INTO order_items (order_id,product_id,vendor_id,price,quantity)
VALUES ('$order_id','$product_id','$vendor_id','$price','$qty')
");

}

$conn->query("DELETE FROM cart WHERE user_id='$user_id'");

echo "Order placed successfully!";
?>