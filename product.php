<?php
session_start();
include "config/database.php";

/* Check product ID */
if(!isset($_GET['id'])){
echo "Product not found";
exit();
}

$id = $_GET['id'];

/* Fetch product */
$product = $conn->query("
SELECT products.*, categories.name AS category_name
FROM products
LEFT JOIN categories ON products.category_id = categories.id
WHERE products.id='$id' AND products.status='approved'
");

$product = $product->fetch_assoc();

if(!$product){
echo "Product not found";
exit();
}

/* Related products */
$related = $conn->query("
SELECT * FROM products
WHERE category_id='".$product['category_id']."' 
AND id != '$id'
AND status='approved'
LIMIT 4
");
?>

<!DOCTYPE html>

<html>

<head>

<title><?php echo $product['title']; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f5f5;
font-family:Arial;
}

.product-box{
background:#fff;
padding:25px;
border-radius:10px;
}

.product-img{
width:100%;
height:400px;
object-fit:cover;
border-radius:10px;
}

.price{
color:#28a745;
font-size:22px;
font-weight:bold;
}

.btn-cart{
background:#28a745;
color:white;
padding:10px 20px;
border:none;
border-radius:5px;
}

.btn-cart:hover{
background:#218838;
}

.related-card{
background:white;
padding:10px;
border-radius:10px;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="row">

<!-- IMAGE -->

<div class="col-md-6">
<img src="<?php echo $product['image']; ?>" class="product-img">
</div>

<!-- DETAILS -->

<div class="col-md-6">

<div class="product-box shadow">

<h3><?php echo $product['title']; ?></h3>

<p class="text-muted">
Category: <?php echo $product['category_name']; ?>
</p>

<p class="price">
₦<?php echo number_format($product['price']); ?>
</p>

<p>
<?php echo $product['description']; ?>
</p>

<!-- ADD TO CART -->

<form method="POST" action="cart/add_to_cart.php">

<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

<div class="mb-3">
<label>Quantity</label>
<input type="number" name="qty" value="1" min="1" class="form-control">
</div>

<button type="submit" class="btn-cart">
Add to Cart 🛒
</button>

</form>

</div>

</div>

</div>

<!-- RELATED PRODUCTS -->

<div class="mt-5">

<h4>Related Products</h4>

<div class="row">

<?php while($r = $related->fetch_assoc()){ ?>

<div class="col-md-3">

<div class="related-card shadow">

<img src="<?php echo $r['image']; ?>" class="img-fluid">

<h6 class="mt-2"><?php echo $r['title']; ?></h6>

<p class="text-success">
₦<?php echo number_format($r['price']); ?>
</p>

<?php if($product['stock'] > 0): ?>

<form method="POST" action="cart/add_to_cart.php">

<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

<label>Quantity</label>
<input type="number" name="qty" value="1" min="1" max="<?php echo $product['stock']; ?>" class="form-control mb-2">

<button type="submit" class="btn btn-success">
Add to Cart 🛒
</button>

</form>

<p class="text-success mt-2">In Stock: <?php echo $product['stock']; ?></p>

<?php else: ?>

<p class="text-danger fw-bold">Out of Stock</p>

<?php endif; ?>

</div>

</div>

<?php } ?>

</div>

</div>

</div>

</body>

</html>
