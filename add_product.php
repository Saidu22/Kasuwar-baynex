 <?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $vendor_id = $_SESSION['user_id'];

    /* Upload Image */
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $folder = "../uploads/" . $image;

    move_uploaded_file($tmp, $folder);

    /* Insert into DB */
    $conn->query("
    INSERT INTO products (title, price, category_id, stock, image, vendor_id, status)
    VALUES ('$title','$price','$category','$stock','uploads/$image','$vendor_id','pending')
    ");

    echo "<script>alert('Product submitted for approval');</script>";
}
?>

<!DOCTYPE html>

<html>
<head>
<title>Add Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h3>Add Product</h3>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" class="form-control mb-3" placeholder="Product Title" required>

<input type="number" name="price" class="form-control mb-3" placeholder="Price" required>

<select name="category" class="form-control mb-3">
<?php
$cats = $conn->query("SELECT * FROM categories");
while($c = $cats->fetch_assoc()){
    echo "<option value='".$c['id']."'>".$c['name']."</option>";
}
?>
</select>

<input type="number" name="stock" class="form-control mb-3" placeholder="Stock Quantity" required>

<input type="file" name="image" class="form-control mb-3" required>

<button name="submit" class="btn btn-success">Upload Product</button>

</form>

</div>

</body>
</html>
