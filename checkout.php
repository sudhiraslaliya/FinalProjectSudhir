<?php
session_start();

include 'db_connect.php';

$cart_products = [];

if (isset($_POST['checkout'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    
    // Calculate total price
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

    $total = 0;
    foreach ($cart_products as $product) {
        $total += $product['price'];
    }

    // Insert order into database
    $sql = "INSERT INTO orders (name, address, email, total) VALUES ('$name', '$address', '$email', '$total')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        
        // Insert order items into database
        foreach ($cart_products as $product) {
            $product_id = $product['id'];
            $product_name = $product['name'];
            $price = $product['price'];
            $quantity = 1; // Assuming quantity is always 1 for simplicity

            $sql = "INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES ('$order_id', '$product_id', '$product_name', '$price', '$quantity')";
            $conn->query($sql);
        }

        // Store order_id in session
        $_SESSION['order_id'] = $order_id;
        
        // Redirect to confirmation page
        header('Location: confirmation.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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