<?php
include "config/database.php";

$category_id = $_GET['id'];

$products = $conn->query("
SELECT * FROM products
WHERE category_id='$category_id'
");
?>

<div class="container mt-5">

<h3>Category Products</h3>

<div class="row">

<?php while($p = $products->fetch_assoc()){ ?>

<div class="col-md-3">

<div class="card shadow mb-4">

<img src="<?php echo $p['image']; ?>" class="card-img-top">

<div class="card-body">

<h6><?php echo $p['title']; ?></h6>

<p class="text-success">
₦<?php echo number_format($p['price']); ?>
</p>

<a href="product.php?id=<?php echo $p['id']; ?>" 
class="btn btn-success btn-sm">

View Product

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>