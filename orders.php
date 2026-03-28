<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT order_items.*, products.title
FROM order_items
JOIN products ON order_items.product_id = products.id
WHERE products.vendor_id='$user_id'
");
?>

<h3>Vendor Orders</h3>

<table class="table table-bordered">
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td>₦<?php echo number_format($row['price']); ?></td>
</tr>
<?php endwhile; ?>

</table>
