 <?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

/* Update quantity */
$conn->query("UPDATE cart SET quantity='$quantity' WHERE id='$cart_id'");

header("Location: view_cart.php");
exit();
?>