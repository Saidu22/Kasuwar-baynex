 <?php
session_start();
include "config/database.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name,email,password) 
              VALUES ('$name','$email','$password')";

    if($conn->query($query)){
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="max-width:500px;">
<h3>Create Account</h3>

<form method="POST">
    <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
    <button name="register" class="btn btn-success w-100">Register</button>
</form>

</div>
</body>
</html>