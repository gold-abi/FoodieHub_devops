<?php
include('../includes/config.php');

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You can later replace this with a DB table for admins
    if($username == "admin" && $password == "admin123"){
        $_SESSION['admin'] = $username;
        echo "<script>alert('Login Successful'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - FoodieHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 w-50">
    <h3 class="text-center mb-4">👨‍💼 Admin Login</h3>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" class="form-control mb-3" required>
        <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
        <button class="btn btn-primary w-100" name="login">Login</button>
    </form>
</div>

</body>
</html>
