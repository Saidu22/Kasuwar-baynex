 <?php
session_start();
include "../config/database.php";

$result = $conn->query("
SELECT vendors.*, users.name, users.email, users.status 
FROM vendors
JOIN users ON vendors.user_id = users.id
WHERE users.status='pending'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pending Vendors</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<h2>Pending Vendor Applications</h2>

<table class="table table-bordered mt-4">

<tr>
<th>Name</th>
<th>Email</th>
<th>Business</th>
<th>Phone</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['business_name']; ?></td>
<td><?php echo $row['phone']; ?></td>

<td>
<a href="approve_vendor.php?id=<?php echo $row['user_id']; ?>" class="btn btn-success btn-sm">Approve</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>