 <?php
include "../config/database.php";

$result = $conn->query("
SELECT products.*, vendors.business_name
FROM products
JOIN vendors ON products.vendor_id = vendors.id
ORDER BY products.id DESC
");
?>

<h2>All Products</h2>

<table border="1" cellpadding="10">

<tr>
<th>Image</th>
<th>Title</th>
<th>Price</th>
<th>Vendor</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>

<td>
<img src="../uploads/<?php echo $row['image']; ?>" width="80">
</td>

<td><?php echo $row['title']; ?></td>

<td>₦<?php echo $row['price']; ?></td>

<td><?php echo $row['business_name']; ?></td>

</tr>

<?php endwhile; ?>

</table>