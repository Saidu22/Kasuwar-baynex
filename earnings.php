<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT SUM(order_items.price * order_items.quantity) AS total
FROM order_items
JOIN products ON order_items.product_id = products.id
WHERE products.vendor_id='$user_id'
");

$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;
?>

<!DOCTYPE html>

<html>
<head>
<title>Earnings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h3>Your Earnings</h3>

<div class="card p-4 shadow">
<h2 class="text-success">₦<?php echo number_format($total); ?></h2>
</div>

<a href="dashboard.php" class="btn btn-dark mt-3">Back</a>

</div>

</body>
</html>
