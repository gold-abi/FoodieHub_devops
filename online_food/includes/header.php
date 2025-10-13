<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Online Food Ordering</title>
  <link rel="stylesheet" href="/online_food/assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/online_food/index.php">FoodieHub 🍴</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li><a class="nav-link" href="/online_food/pages/cart.php">🛒 Cart</a></li>
        <li><a class="nav-link" href="/online_food/pages/track_order.php">🚚 Track Order</a></li>
        <?php if(isset($_SESSION['user_id'])) { ?>
          <li class="nav-link text-white">👋 Hi, <?php echo $_SESSION['user_name']; ?></li>
          <li><a class="nav-link" href="/online_food/logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a class="nav-link" href="/online_food/pages/login.php">Login</a></li>
          <li><a class="nav-link" href="/online_food/pages/register.php">Register</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
