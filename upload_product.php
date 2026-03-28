<?php
session_start();
include "../config/database.php";

/* Make sure vendor is logged in */
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

/* Handle product upload */
if(isset($_POST['upload'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $image = $_POST['image'];

    $vendor_id = $_SESSION['user_id'];

    $conn->query("INSERT INTO products (title, description, price, vendor_id, category_id, image, status) 
    VALUES ('$title','$description','$price','$vendor_id','$category_id','$image','pending')");

    echo "<script>alert('Product uploaded successfully! Waiting for admin approval.');</script>";
}

$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>

<html>
<head>
<title>Upload Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f5f5;">

<div class="container mt-5">

<h3 class="mb-4">Upload New Product</h3>

<div class="card shadow p-4">

<form method="POST">

<div class="mb-3">
<label>Product Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Price (₦)</label>
<input type="number" name="price" class="form-control" required>
</div>

<div class="mb-3">
<label>Category</label>
<select name="category" class="form-control" required>
<option value="">-- Select Category --</option>
<?php while($c = $categories->fetch_assoc()){ ?>
<option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>Product Image URL</label>
<input type="text" name="image" class="form-control" placeholder="Paste online image link" required>
</div>

<button class="btn btn-success" name="upload">Upload Product</button>

</form>

</div>

</div>

</body>
</html>
