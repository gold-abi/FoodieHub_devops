<?php
include('../includes/config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
foreach ($_SESSION['cart'] as $item) {
    $food_id = $item['food_id'];
    mysqli_query($conn, "INSERT INTO user_orders (user_id, food_id) VALUES ($user_id, $food_id)");
}



// Calculate total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['price']; // You can multiply by quantity if you add quantity
}

// Insert order into orders table
$order_query = "INSERT INTO orders (user_id, total_amount, status) 
                VALUES ($user_id, $total_amount, 'Pending')";
$result = mysqli_query($conn, $order_query);

if ($result) {
    $order_id = mysqli_insert_id($conn); // get the last inserted order_id

    // Optionally: insert each item into an order_items table if you have one

    // Clear the cart
    $_SESSION['cart'] = [];

    // Redirect to order success page
    header("Location: order_success.php?order_id=$order_id");
    exit;
} else {
    die("Order failed: " . mysqli_error($conn));
}
