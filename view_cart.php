<?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch cart items */
$result = $conn->query("
    SELECT cart.id AS cart_id, cart.quantity, products.*
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id='$user_id'
");

$total = 0;
?>

<!DOCTYPE html>

<html>
<head>
<title>Your Cart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f5f5;">

<div class="container mt-5">

<h3>🛒 Your Cart</h3>

<table class="table table-bordered bg-white">
<tr>
<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): 
$item_total = $row['price'] * $row['quantity'];
$total += $item_total;
?>

<tr>
<td><img src="<?php echo $row['image']; ?>" width="80"></td>
<td><?php echo $row['title']; ?></td>
<td>₦<?php echo number_format($row['price']); ?></td>

<td>
<form method="POST" action="update_quantity.php" style="display:inline-block;">
<input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
<input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" style="width:60px;">
<button class="btn btn-primary btn-sm">Update</button>
</form>
</td>

<td>₦<?php echo number_format($item_total); ?></td>
<td>
<a href="remove.php?id=<?php echo $row['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
</td>
</tr>

<?php endwhile; ?>

</table>

<h4>Total: ₦<?php echo number_format($total); ?></h4>
<a href="../checkout/pay.php" class="btn btn-success">
    Pay Now
</a>

</div>
</body>
</html>
