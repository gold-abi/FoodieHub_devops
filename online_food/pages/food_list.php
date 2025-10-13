<?php
include('../includes/header.php');
$hotel_id = $_GET['hotel_id'] ?? 0;

if(isset($_POST['add_to_cart'])){
    if(!isset($_SESSION['user_id'])){
        echo "<script>alert('Please login to add items to cart'); window.location='login.php';</script>";
        exit;
    }
    $food_id = $_POST['food_id'];
    $user_id = $_SESSION['user_id'];
    $check = $conn->query("SELECT * FROM cart WHERE food_id=$food_id AND user_id=$user_id");
    if($check->num_rows > 0){
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE food_id=$food_id AND user_id=$user_id");
    } else {
        $conn->query("INSERT INTO cart (user_id, food_id, quantity) VALUES ($user_id, $food_id, 1)");
    }
    echo "<script>alert('Added to Cart!');</script>";
}
?>

<div class="container mt-4">
    <h3 class="text-center mb-4">🍕 Menu Items</h3>
    <div class="row">
        <?php
        $foods = $conn->query("SELECT * FROM foods WHERE hotel_id=$hotel_id");
        while($food = $foods->fetch_assoc()){
            echo "
            <div class='col-md-4 mb-4'>
                <div class='card'>
                    <img src='../assets/images/{$food['image']}' class='card-img-top' height='200'>
                    <div class='card-body text-center'>
                        <h5>{$food['name']}</h5>
                        <p>Price: ₹{$food['price']}</p>
                        <form method='POST'>
                            <input type='hidden' name='food_id' value='{$food['food_id']}'>
                            <button class='btn btn-primary' name='add_to_cart'>Add to Cart 🛒</button>
                        </form>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
