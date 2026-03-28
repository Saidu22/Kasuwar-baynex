 <?php
include "config/database.php";

$vendor_id = $_GET['vendor'];

$vendor = $conn->query("SELECT * FROM vendors WHERE id='$vendor_id'");
$v = $vendor->fetch_assoc();

$products = $conn->query("SELECT * FROM products WHERE vendor_id='$vendor_id'");
?>

<h2><?php echo $v['business_name']; ?> Store</h2>

<hr>

<h3>Products</h3>

<?php while($p = $products->fetch_assoc()){ ?>

<div style="border:1px solid #ccc; padding:10px; margin:10px; width:200px; display:inline-block;">

<img src="public/assets/images/<?php echo $p['image']; ?>" width="150">

<h4><?php echo $p['title']; ?></h4>

<p>₦<?php echo $p['price']; ?></p>

</div>

<?php } ?>