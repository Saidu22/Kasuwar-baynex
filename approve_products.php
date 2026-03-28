<?php
session_start();
include "../config/database.php";

/* Approve product */
if(isset($_GET['approve'])){
$id = $_GET['approve'];

$conn->query("UPDATE products SET status='approved' WHERE id='$id'");

header("Location: approve_products.php");
}

/* Reject product */
if(isset($_GET['reject'])){
$id = $_GET['reject'];

$conn->query("DELETE FROM products WHERE id='$id'");

header("Location: approve_products.php");
}

/* Fetch pending products */

$products = $conn->query("
SELECT products.*, categories.name AS category_name
FROM products
LEFT JOIN categories ON products.category_id = categories.id
WHERE products.status='pending'
ORDER BY products.id DESC
");

?>

<!DOCTYPE html>

<html>

<head>

<title>Approve Products</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f5f5f5;">

<div class="container mt-5">

<h3 class="mb-4">Pending Products for Approval</h3>

<table class="table table-bordered bg-white shadow">

<tr>
<th>ID</th>
<th>Title</th>
<th>Category</th>
<th>Price</th>
<th>Image</th>
<th>Actions</th>
</tr>

<?php while($p = $products->fetch_assoc()){ ?>

<tr>

<td><?php echo $p['id']; ?></td>

<td><?php echo $p['title']; ?></td>

<td><?php echo $p['category_name']; ?></td>

<td>₦<?php echo number_format($p['price']); ?></td>

<td>
<img src="<?php echo $p['image']; ?>" width="80">
</td>

<td>

<a href="approve_products.php?approve=<?php echo $p['id']; ?>" class="btn btn-success btn-sm">
Approve
</a>

<a href="approve_products.php?reject=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm">
Reject
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>
