 <?php
include "config/database.php";

$keyword = $_GET['keyword'];

$products = $conn->query("
SELECT * FROM products
WHERE title LIKE '%$keyword%'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Search Results</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h3>Search Results for "<?php echo $keyword; ?>"</h3>

<div class="row">

<?php while($p = $products->fetch_assoc()){ ?>

<div class="col-md-3">

<div class="card shadow mb-4">

<img src="public/assets/images/<?php echo $p['image']; ?>" class="card-img-top">

<div class="card-body">

<h6><?php echo $p['title']; ?></h6>

<p class="text-success fw-bold">
₦<?php echo number_format($p['price']); ?>
</p>

<a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-success btn-sm">
View Product
</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

</body>

</html>