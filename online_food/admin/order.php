<?php
include('../includes/config.php');
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

// Update order status
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE order_id=$order_id");
    echo "<script>alert('Order status updated!'); window.location='orders.php';</script>";
}

$orders = $conn->query("
    SELECT o.*, u.name, u.email, u.phone
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">📦 Manage Orders</span>
    <a href="dashboard.php" class="btn btn-outline-light">Back</a>
  </div>
</nav>

<div class="container mt-4">
    <h3 class="text-center mb-4">All Customer Orders</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while($order = $orders->fetch_assoc()){ ?>
            <tr>
                <td>#<?= $order['order_id'] ?></td>
                <td><?= $order['name'] ?></td>
                <td><?= $order['email'] ?><br><?= $order['phone'] ?></td>
                <td>₹<?= number_format($order['total_amount'], 2) ?></td>
                <td><?= $order['created_at'] ?></td>
                <td><span class="badge bg-info"><?= $order['status'] ?></span></td>
                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <select name="status" class="form-select form-select-sm me-2">
                            <option value="Processing" <?= $order['status']=="Processing"?"selected":"" ?>>Processing</option>
                            <option value="Out for Delivery" <?= $order['status']=="Out for Delivery"?"selected":"" ?>>Out for Delivery</option>
                            <option value="Delivered" <?= $order['status']=="Delivered"?"selected":"" ?>>Delivered</option>
                            <option value="Cancelled" <?= $order['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
                        </select>
                        <button class="btn btn-sm btn-success" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
