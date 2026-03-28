 <?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
header("Location: ../auth/login.php");
exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

/* Insert review */
$conn->query("
INSERT INTO reviews (product_id, user_id, rating, comment)
VALUES ('$product_id','$user_id','$rating','$comment')
");

/* Redirect back */
header("Location: ../product.php?id=$product_id");
?>
