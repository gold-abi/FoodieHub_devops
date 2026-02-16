<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = getenv("DB_HOST") ?: "mysql";
$username   = getenv("DB_USER") ?: "root";
$password   = getenv("DB_PASS") ?: "root";
$dbname     = getenv("DB_NAME") ?: "food_order_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
