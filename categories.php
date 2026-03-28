 <?php
session_start();
include "../config/database.php";

/* ADD CATEGORY */
if(isset($_POST['add_category'])){
$name = $_POST['name'];
$image = $_POST['image'];

$conn->query("INSERT INTO categories (name,image) VALUES ('$name','$image')");
header("Location: categories.php");
}

/* DELETE CATEGORY */
if(isset($_GET['delete'])){
$id = $_GET['delete'];
$conn->query("DELETE FROM categories WHERE id='$id'");
header("Location: categories.php");
}

$categories = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>

<html>

<head>

<title>Manage Categories</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f5f5f5;">

<div class="container mt-5">

<h3 class="mb-4">Category Manager</h3>

<div class="row">

<div class="col-md-4">

<div class="card shadow p-3">

<h5>Add Category</h5>

<form method="POST">

<input type="text" name="name" class="form-control mb-3" placeholder="Category Name" required>

<input type="text" name="image" class="form-control mb-3" placeholder="Image URL">

<button class="btn btn-success w-100" name="add_category">
Add Category
</button>

</form>

</div>

</div>

<div class="col-md-8">

<div class="card shadow p-3">

<h5>All Categories</h5>

<table class="table">

<tr>
<th>ID</th>
<th>Name</th>
<th>Image</th>
<th>Action</th>
</tr>

<?php while($c = $categories->fetch_assoc()){ ?>

<tr>

<td><?php echo $c['id']; ?></td>

<td><?php echo $c['name']; ?></td>

<td>
<img src="<?php echo $c['image']; ?>" width="60">
</td>

<td>

<a href="categories.php?delete=<?php echo $c['id']; ?>" 
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

</body>

</html>
