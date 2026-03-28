<?php
session_start();
include "config/database.php";
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<title>Kasuwar Baynex Marketplace</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#f5f5f5;font-family:Arial;}
.hero-slide{height:500px;background-size:cover;background-position:center;position:relative;}
.hero-overlay{background:rgba(0,0,0,0.6);height:100%;display:flex;align-items:center;}
.category-card{background:white;padding:15px;border-radius:10px;transition:.3s;}
.category-card:hover{transform:translateY(-5px);box-shadow:0 5px 20px rgba(0,0,0,0.1);}
.product-card{background:white;padding:15px;border-radius:10px;}
.product-card img{height:200px;object-fit:cover;border-radius:6px;}
</style>

</head>

<body>

<!-- TOP BAR -->

<div class="container mt-3 text-end">
<?php if(isset($_SESSION['user_id'])): ?>
<span class="me-3">Welcome, <?php echo $_SESSION['user_name']; ?></span>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
<?php else: ?>
<a href="auth/login.php" class="btn btn-outline-success btn-sm me-2">Login</a>
<a href="auth/register.php" class="btn btn-success btn-sm">Register</a>
<?php endif; ?>
</div>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<a class="navbar-brand fw-bold" href="index.php">Kasuwar Baynex</a>
<form class="d-flex" action="search.php" method="GET">
<input class="form-control me-2" type="search" name="keyword" placeholder="Search products">
<button class="btn btn-success">Search</button>
</form>
<ul class="navbar-nav">
<li class="nav-item"><a class="nav-link" href="cart/cart.php">Cart</a></li>
<li class="nav-item"><a class="nav-link" href="vendor/dashboard.php">Vendor</a></li>
<li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Admin</a></li>
</ul>
</div>
</nav>

<!-- HERO -->

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<div class="carousel-item active">
<div class="hero-slide" style="background-image:url('https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg');">
<div class="hero-overlay">
<div class="container text-white">
<h1 class="display-4 fw-bold">Welcome to Kasuwar Baynex</h1>
<p class="lead">Buy Electronics, Fashion, Phones and more</p>
<a href="#categories" class="btn btn-success btn-lg">Shop Now</a>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- CATEGORIES -->

<section id="categories" class="container my-5">
<h3 class="fw-bold mb-4 text-center">Popular Categories</h3>
<div class="row g-4">
<?php
$categories = $conn->query("SELECT * FROM categories");
while($c = $categories->fetch_assoc()){
?>
<div class="col-md-3">
<a href="category.php?id=<?php echo $c['id']; ?>" style="text-decoration:none;color:black">
<div class="category-card text-center">
<img src="<?php echo $c['image']; ?>" class="img-fluid">
<h6 class="mt-3"><?php echo $c['name']; ?></h6>
</div>
</a>
</div>
<?php } ?>
</div>
</section>

<!-- TRENDING PRODUCTS -->

<section id="products" class="container my-5">
<h3 class="fw-bold mb-4 text-center">Trending Products</h3>
<div class="row g-4">
<?php
$products = $conn->query("SELECT * FROM products WHERE status='approved' ORDER BY id DESC LIMIT 8");
while($p = $products->fetch_assoc()){
?>
<div class="col-md-3">
<div class="product-card shadow">
<img src="<?php echo $p['image']; ?>" class="img-fluid">
<h6 class="mt-3"><?php echo $p['title']; ?></h6>
<p class="text-success fw-bold">₦<?php echo number_format($p['price']); ?></p>
<a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-success btn-sm">View Product</a>
</div>
</div>
<?php } ?>
</div>
</section>

<!-- FOOTER -->

<footer class="bg-dark text-white text-center p-4 mt-5">
<p>© <?php echo date("Y"); ?> Kasuwar Baynex Marketplace</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
