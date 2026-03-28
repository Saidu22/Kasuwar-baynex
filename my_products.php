 <?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$vendor = $conn->query("SELECT id FROM vendors WHERE user_id=$user_id")->fetch_assoc();
$vendor_id = $vendor['id'];

$products = $conn->query("SELECT * FROM products WHERE vendor_id=$vendor_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<h3>My Products</h3>

<table class="table table-bordered mt-4">

<tr>
<th>Image</th>
<th>Title</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row = $products->fetch_assoc()){ ?>

<tr>

<td>
<img src="../uploads/<?php echo $row['image']; ?>" width="60">
</td>

<td><?php echo $row['title']; ?></td>

<td>₦<?php echo $row['price']; ?></td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>" 
class="btn btn-primary btn-sm">Edit</a>

<a href="delete_product.php?id=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>