<?php
session_start();
include "../config/database.php";

if(!isset($_GET['id'])){
header("Location: view_cart.php");
exit();
}

$id = $_GET['id'];

/* Delete item */
$conn->query("DELETE FROM cart WHERE id='$id'");

/* Force refresh */
header("Location: view_cart.php");
exit();
?>
