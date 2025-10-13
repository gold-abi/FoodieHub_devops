<?php
include('../includes/config.php');
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - FoodieHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">🍔 FoodieHub Admin Panel</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</nav>

<div class="container mt-5 text-center">
  <h2>Welcome, Admin!</h2>
  <p class="lead">Manage orders and track delivery statuses.</p>

  <a href="orders.php" class="btn btn-primary mt-3">📦 View All Orders</a>
</div>

</body>
</html>
