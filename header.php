 <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kasuwar Baynex</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/kasuwar-baynex/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/kasuwar-baynex/public/index.php">
            Kasuwar Baynex
        </a>

        <div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/kasuwar-baynex/auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
            <?php else: ?>
                <a href="/kasuwar-baynex/auth/login.php" class="btn btn-success btn-sm">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4">