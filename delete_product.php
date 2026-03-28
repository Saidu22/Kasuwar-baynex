 <?php
session_start();
include "../config/database.php";

$id = $_GET['id'];

/* Delete product */
$conn->query("DELETE FROM products WHERE id='$id'");

header("Location: dashboard.php");
exit();
?>
