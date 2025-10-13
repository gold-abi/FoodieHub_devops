<?php
include('../includes/config.php');
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$total = 0;
$show_form = true;
$order_confirmed = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['place_order'])) {
        $show_form = true;
    } elseif (isset($_POST['confirm_order'])) {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);

        if (!empty($name) && !empty($phone) && !empty($address)) {
            // Save to database (optional)
            // Example:
            // $user_id = $_SESSION['user_id'];
            // mysqli_query($conn, "INSERT INTO orders (user_id, name, phone, address, total) VALUES ('$user_id', '$name', '$phone', '$address', '$total')");

            $order_confirmed = true;
            $show_form = false;
            unset($_SESSION['cart']); // clear cart after order
        } else {
            $error = "Please fill all the details.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout | FoodieHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
  <h3 class="text-center mb-4">🛒 Checkout</h3>

  <?php if ($order_confirmed): ?>
      <div class="alert alert-success text-center">
        ✅ Your order is confirmed!<br>
        🚴‍♂️ Your delivery will be picked soon.
      </div>
  <?php else: ?>

    <table class="table table-bordered text-center">
      <thead class="table-dark">
        <tr>
          <th>Food Name</th>
          <th>Price (₹)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['cart'] as $item): 
          $total += $item['price']; ?>
          <tr>
            <td><?php echo htmlspecialchars($item['food_name']); ?></td>
            <td>₹<?php echo $item['price']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h5 class="text-end">Total: ₹<?php echo $total; ?></h5>

    <?php if (!isset($_POST['place_order'])): ?>
      <form method="POST" class="text-end mt-3">
        <button type="submit" name="place_order" class="btn btn-success btn-lg">Place Order</button>
      </form>

    <?php else: ?>
      <div class="card p-4 mt-4">
        <h5 class="mb-3 text-center">Enter Your Delivery Details</h5>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Enter your address" required></textarea>
          </div>
          <div class="text-end">
            <button type="submit" name="confirm_order" class="btn btn-primary btn-lg">Confirm Order</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

</body>
</html>
