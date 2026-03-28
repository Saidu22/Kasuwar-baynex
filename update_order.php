 <?php

include "../config/database.php";

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query("UPDATE order_items 
SET status='$status' 
WHERE id='$id'");

header("Location: orders.php");

?>