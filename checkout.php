<?php
session_start();

if (isset($_POST['checkout'])) {
    // Handle checkout logic
    session_destroy();
    header('Location: confirmation.php');
}

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
    <title>Checkout</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header>
        <h1>Checkout</h1>
    </header>
    <main>
        <form action="checkout.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <h2>Order Summary</h2>
            <div id="order-summary">
                <?php
                $total = 0;
                foreach ($cart_products as $product) {
                    echo "<div class='product'>
                            <h3>{$product['name']}</h3>
                            <p>\${$product['price']}</p>
                          </div>";
                    $total += $product['price'];
                }
                echo "<h3>Total: \$$total</h3>";
                ?>
            </div>
            <button type="submit" name="checkout">Place Order</button>
        </form>
    </main>
</body>

</html>