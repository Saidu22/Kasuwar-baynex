 <?php
include "../config/database.php";

$id = $_GET['id'];

$conn->query("UPDATE users SET status='approved' WHERE id=$id");

header("Location: vendors.php");
exit();
?>