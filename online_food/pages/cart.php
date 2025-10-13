<?php
include('../includes/config.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];
    $food_name = $_POST['food_name'];
    $price = $_POST['price'];

    $_SESSION['cart'][] = [
        'food_id' => $food_id,
        'food_name' => $food_name,
        'price' => $price
    ];
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart | FoodieHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
  <h3 class="text-center mb-4">🛒 Your Cart</h3>

  <?php if (!empty($_SESSION['cart'])) { ?>
    <table class="table table-bordered text-center">
      <thead class="table-dark">
        <tr>
          <th>Food Name</th>
          <th>Price (₹)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'];
            echo "<tr><td>{$item['food_name']}</td><td>₹{$item['price']}</td></tr>";
        } ?>
      </tbody>
    </table>

    <h5 class="text-end">Subtotal: ₹<?php echo $total; ?></h5>

    <div class="alert alert-info mt-3">
      💸 <strong>Available Coupons:</strong><br>
      FOODIE10 – Get 10% off on orders above ₹500<br>
      FREEDEL – Free Delivery on orders above ₹299
    </div>

    <div class="text-end">
      <form method="POST" style="display:inline;">
        <button type="submit" name="clear_cart" class="btn btn-danger">Clear Cart</button>
      </form>
      <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>

  <?php } else { ?>
    <p class="text-center">Your cart is empty 🛍️</p>
  <?php } ?>
</div>

</body>
</html>
