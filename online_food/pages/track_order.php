<?php
include('../includes/config.php');
session_start();

// If user is not logged in, redirect to login and send them back here
if (!isset($_SESSION['user_id'])) {
    $current_page = basename($_SERVER['PHP_SELF']); // "track_order.php"
    header("Location: login.php?redirect=pages/$current_page");
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Track Order | FoodieHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>
<!-- Rest of your HTML and PHP code -->
<div class="container mt-5">
  <h3 class="text-center mb-4">🚚 Track Your Orders</h3>

  <?php
  // Fetch orders for the logged-in user
  $orders_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC");
  
  if (mysqli_num_rows($orders_query) > 0) {
      echo '<table class="table table-bordered text-center">
              <thead class="table-dark">
                <tr>
                  <th>Order ID</th>
                  <th>Total Amount (₹)</th>
                  <th>Status</th>
                  <th>Placed On</th>
                </tr>
              </thead>
              <tbody>';
      
      while ($order = mysqli_fetch_assoc($orders_query)) {
          echo '<tr>
                  <td>' . $order['order_id'] . '</td>
                  <td>₹' . $order['total_amount'] . '</td>
                  <td>' . $order['status'] . '</td>
                  <td>' . date('d M Y, H:i', strtotime($order['created_at'])) . '</td>
                </tr>';
      }
      
      echo '  </tbody>
            </table>';
  } else {
      echo '<p class="text-center">You have no orders yet. <a href="index.php">Start ordering now!</a></p>';
  }
  ?>    