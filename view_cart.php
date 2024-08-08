<?php
session_start();
include 'db_connect.php';

$cart_products = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cart_products[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="view_cart.php">Cart</a></li>
                <li><a href="checkout.php">Checkout</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="cart">
            <?php
            if (!empty($cart_products)) {
                foreach ($cart_products as $product) {
                    echo "<div class='product'>
                            <h3>{$product['name']}</h3>
                            <p>\${$product['price']}</p>
                            <form action='remove_from_cart.php' method='post'>
                                <input type='hidden' name='product_id' value='{$product['id']}'>
                                <button type='submit' name='remove_from_cart'>Remove</button>
                            </form>
                          </div>";
                }
            } else {
                echo "<p>Your cart is empty</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>