 <?php
session_start();
include "../config/database.php";

$id = $_GET['id'];

$product = $conn->query("SELECT * FROM products WHERE id='$id'")->fetch_assoc();

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $conn->query("
    UPDATE products SET
    title='$title',
    price='$price',
    stock='$stock',
    status='pending'
    WHERE id='$id'
    ");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>

<html>
<head>
<title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h3>Edit Product</h3>

<form method="POST">

<input type="text" name="title" value="<?php echo $product['title']; ?>" class="form-control mb-3">

<input type="number" name="price" value="<?php echo $product['price']; ?>" class="form-control mb-3">

<input type="number" name="stock" value="<?php echo $product['stock']; ?>" class="form-control mb-3">

<button name="update" class="btn btn-primary">Update Product</button>

</form>

</div>

</body>
</html>
