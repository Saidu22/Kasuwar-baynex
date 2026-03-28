<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT cart.*, products.title, products.price, products.image
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;
?>

<h2>🛒 Your Cart</h2>

<table border="1" cellpadding="10">

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

<td>
<img src="../uploads/<?php echo $row['image']; ?>" width="80">
</td>

<td><?php echo $row['title']; ?></td>

<td>₦<?php echo $row['price']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₦<?php echo $item_total; ?></td>

<td>
<a href="remove.php?id=<?php echo $row['id']; ?>">Remove</a>
</td>

</tr>

<?php endwhile; ?>

</table>

<h3>Total: ₦<?php echo $total; ?></h3>

<a href="../checkout/checkout.php">Proceed to Checkout</a>