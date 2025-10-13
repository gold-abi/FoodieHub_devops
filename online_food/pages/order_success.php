<?php
include('../includes/config.php');
session_start();

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = (int)$_GET['order_id'];

// Fetch order details
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_id=$order_id");
$order = mysqli_fetch_assoc($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Placed | FoodieHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('../includes/header.php'); ?>

<div class="container mt-5 text-center">
    <h2>🎉 Your Order Has Been Placed!</h2>
    <p>Order ID: <strong><?php echo $order['order_id']; ?></strong></p>
    <p>Total Amount: <strong>₹<?php echo $order['total_amount']; ?></strong></p>
    <p>Status: <strong><?php echo $order['status']; ?></strong></p>

    <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
</div>

</body>
</html>
