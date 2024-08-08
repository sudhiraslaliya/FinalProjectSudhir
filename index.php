<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Furniture Store</title>
    <link rel="stylesheet" href="/app.css">
</head>

<body>
    <header>
        <h1>Welcome to Your Furniture Store</h1>
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
        <h2>Our Products</h2>
        <div id="products">
            <?php
            include 'db_connect.php';
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>
                            <img src='path/to/image.jpg' alt='{$row['name']}'>
                            <h3>{$row['name']}</h3>
                            <p>{$row['description']}</p>
                            <p>\${$row['price']}</p>
                            <form action='add_to_cart.php' method='post'>
                                <input type='hidden' name='product_id' value='{$row['id']}'>
                                <button type='submit' name='add_to_cart'>Add to Cart</button>
                            </form>
                          </div>";
                }
            } else {
                echo "<p>No products available</p>";
            }
            $conn->close();
            ?>
        </div>
    </main>
</body>

</html>