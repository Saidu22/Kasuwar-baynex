<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
header("Location: ../auth/login.php");
exit();
}

$user_id = $_SESSION['user_id'];

/* Stats */
$total_products = $conn->query("SELECT * FROM products WHERE vendor_id='$user_id'")->num_rows;
$approved = $conn->query("SELECT * FROM products WHERE vendor_id='$user_id' AND status='approved'")->num_rows;
$pending = $conn->query("SELECT * FROM products WHERE vendor_id='$user_id' AND status='pending'")->num_rows;

/* Products */
$products = $conn->query("SELECT * FROM products WHERE vendor_id='$user_id' ORDER BY id DESC");
?>

<!DOCTYPE html>

<html>
<head>

<title>Vendor Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f5f5f5;}
.card-box{padding:20px;border-radius:10px;color:white;}
</style>

</head>

<body>

<div class="container mt-5">

<h3 class="mb-4">📊 Vendor Dashboard</h3>

<div class="row mb-4">

<div class="col-md-4">
<div class="card-box bg-primary">
<h5>Total Products</h5>
<h2><?php echo $total_products; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box bg-success">
<h5>Approved</h5>
<h2><?php echo $approved; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box bg-warning">
<h5>Pending</h5>
<h2><?php echo $pending; ?></h2>
</div>
</div>

</div>

<a href="add_product.php" class="btn btn-success mb-3">+ Add Product</a>

<table class="table table-bordered bg-white">

<tr>
<th>Image</th>
<th>Title</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>

<tr>

<td><img src="../<?php echo $p['image']; ?>" width="60"></td>

<td><?php echo $p['title']; ?></td>

<td>₦<?php echo number_format($p['price']); ?></td>

<td>
<?php if($p['status'] == 'approved'): ?>
<span class="badge bg-success">Approved</span>
<?php else: ?>
<span class="badge bg-warning">Pending</span>
<?php endif; ?>
</td>

<td>
<a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
<a href="delete_product.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>
