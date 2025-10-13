<?php
include('includes/config.php');
session_start();

// ----------- SMART MEAL RECOMMENDER -----------
$recommendations = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Find user's most ordered category
    $query = "SELECT f.category, COUNT(*) AS cnt 
              FROM user_orders u
              JOIN foods f ON u.food_id = f.food_id
              WHERE u.user_id = $user_id
              GROUP BY f.category
              ORDER BY cnt DESC
              LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fav_category = $row['category'];

        // Fetch 3 random foods from that category
        $rec_query = "SELECT * FROM foods WHERE category='$fav_category' LIMIT 3";
        $rec_result = mysqli_query($conn, $rec_query);

        while ($rec_row = mysqli_fetch_assoc($rec_result)) {
            $recommendations[] = $rec_row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FoodieHub 🍴 | Order Delicious Food Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body {
      background-color: #fff8f8;
      font-family: 'Poppins', sans-serif;
    }
    .hero {
      background: url('assets/images/banner.jpg') center/cover no-repeat;
      height: 65vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      color: white;
      background-blend-mode: darken;
      background-color: rgba(0,0,0,0.5);
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }
    .hero p {
      font-size: 1.3rem;
      margin-bottom: 25px;
    }
    .search-bar {
      width: 60%;
      max-width: 600px;
    }
    .hotel-card {
      transition: 0.3s;
      border: none;
      border-radius: 20px;
    }
    .hotel-card:hover {
      transform: scale(1.03);
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    .hotel-card img {
      border-radius: 20px 20px 0 0;
      height: 200px;
      object-fit: cover;
    }
    .offer-tag {
      background-color: #ff6b6b;
      color: white;
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 0.9rem;
      display: inline-block;
    }
    .recommend-section {
      background-color: #fff0f0;
      padding: 40px;
      border-radius: 15px;
    }
  </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<!-- Hero Section -->
<section class="hero">
  <h1>Order Food from Your Favorite Restaurants 🍕</h1>
  <p>Delicious food delivered to your doorstep — anytime, anywhere!</p>

  <!-- Search bar -->
  <form method="GET" action="" class="search-bar d-flex">
    <input type="text" name="search" class="form-control form-control-lg" placeholder="Search for food or hotel..."
           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button class="btn btn-danger btn-lg ms-2" type="submit">Search</button>
  </form>
</section>

<div class="container mt-5">
  <h2 class="fw-bold mb-4">🍴 Restaurants Near You</h2>
  <div class="row">
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($search) {
        $query = "SELECT * FROM hotels WHERE name LIKE '%$search%' OR offer LIKE '%$search%'";
    } else {
        $query = "SELECT * FROM hotels";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("<div class='alert alert-danger'>Query Failed: " . mysqli_error($conn) . "</div>");
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <div class="col-md-4 mb-4">
              <div class="card hotel-card shadow-sm">
                <img src="assets/images/' . $row['image'] . '" alt="' . $row['name'] . '">
                <div class="card-body">
                  <h5 class="card-title fw-bold">' . $row['name'] . '</h5>
                  <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</p>
                  <span class="offer-tag">' . $row['offer'] . '</span>
                  <div class="text-end mt-3">
                    <a href="pages/menu.php?hotel_id=' . $row['hotel_id'] . '" class="btn btn-success btn-sm">View Menu</a>
                  </div>
                </div>
              </div>
            </div>';
        }
    } else {
        echo "<p class='text-center'>No hotels found.</p>";
    }
    ?>
  </div>
</div>

<!-- Smart Recommender Section -->
<?php if (!empty($recommendations)) { ?>
  <div class="container mt-5 recommend-section">
    <h2 class="fw-bold mb-4 text-center">🍛 Recommended For You</h2>
    <div class="row">
      <?php foreach ($recommendations as $item) { ?>
        <div class="col-md-4 mb-4">
          <div class="card hotel-card shadow-sm">
            <img src="assets/images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
            <div class="card-body text-center">
              <h5 class="fw-bold"><?php echo $item['name']; ?></h5>
              <p class="text-muted">₹<?php echo $item['price']; ?></p>
              <form method="POST" action="pages/cart.php">
                <input type="hidden" name="food_id" value="<?php echo $item['food_id']; ?>">
                <input type="hidden" name="food_name" value="<?php echo $item['name']; ?>">
                <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                <button class="btn btn-success w-100">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } ?>

</body>
</html>
