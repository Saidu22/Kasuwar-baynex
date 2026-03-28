  <?php
session_start();
include "../config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $business = $_POST['business_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO vendors (user_id,business_name,phone,address) VALUES (?,?,?,?)");
    $stmt->bind_param("isss",$user_id,$business,$phone,$address);
    $stmt->execute();

    $conn->query("UPDATE users SET role='vendor', status='pending' WHERE id=$user_id");

    echo "<div style='padding:20px;font-family:Arial'>
            <h3>Application Submitted</h3>
            <p>Your vendor account is waiting for admin approval.</p>
          </div>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Become Vendor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">
<div class="card-body">

<h3 class="mb-4 text-center">Become a Vendor</h3>

<form method="POST">

<div class="mb-3">
<label>Business Name</label>
<input type="text" name="business_name" class="form-control" required>
</div>

<div class="mb-3">
<label>Phone Number</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="mb-3">
<label>Business Address</label>
<textarea name="address" class="form-control" required></textarea>
</div>

<button class="btn btn-success w-100">
Submit Vendor Application
</button>

</form>

</div>
</div>

</div>

</div>
</div>

</body>
</html>