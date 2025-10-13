<?php include('../includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menu | FoodieHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="container mt-4">
  <?php
  if (isset($_GET['hotel_id'])) {
      $hotel_id = (int)$_GET['hotel_id']; // Cast to int for safety

      // Fetch hotel details
      $hotel_query = mysqli_query($conn, "SELECT * FROM hotels WHERE hotel_id=$hotel_id");
      if (!$hotel_query) {
          die("Query Failed: " . mysqli_error($conn));
      }
      $hotel = mysqli_fetch_assoc($hotel_query);

      if ($hotel) {
          echo "<h3 class='text-center mb-4'>🍴 " . htmlspecialchars($hotel['name']) . " - Menu</h3>";

          // Fetch foods for this hotel
          $query = "SELECT * FROM foods WHERE hotel_id=$hotel_id";
          $result = mysqli_query($conn, $query);
          if (!$result) {
              die("Query Failed: " . mysqli_error($conn));
          }

          echo "<div class='row'>";
          while ($row = mysqli_fetch_assoc($result)) {
              echo '
              <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                  <img src="../assets/images/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                  <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <p class="card-text">₹' . $row['price'] . '</p>
                    <form method="POST" action="cart.php">
                      <input type="hidden" name="food_id" value="' . $row['food_id'] . '">
                      <input type="hidden" name="food_name" value="' . htmlspecialchars($row['name']) . '">
                      <input type="hidden" name="price" value="' . $row['price'] . '">
                      <button type="submit" name="add_to_cart" class="btn btn-success w-100">Add to Cart</button>
                    </form>
                  </div>
                </div>
              </div>';
          }
          echo "</div>";
      } else {
          echo "<p class='text-center'>Hotel not found.</p>";
      }
  } else {
      echo "<p class='text-center'>Invalid Hotel.</p>";
  }
  ?>
</div>

</body>
</html>
