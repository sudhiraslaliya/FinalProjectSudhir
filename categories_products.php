<?php
session_start();
include 'db_connect.php';

// Check if category_id is set in the query string
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);

    // Retrieve products by category from the database
    $sql = "SELECT * FROM products WHERE category_id = $category_id";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === false) {
        die("Error: " . $conn->error);
    }

    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
} else {
    die("Error: category_id not specified.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products by Category</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header>
        <h1>Products by Category</h1>
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
        <div id="products">
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo "<div class='product'>
                            <h3>{$product['name']}</h3>
                            <p>{$product['description']}</p>
                            <p>\${$product['price']}</p>
                            <form action='add_to_cart.php' method='post'>
                                <input type='hidden' name='product_id' value='{$product['id']}'>
                                <button type='submit' name='add_to_cart'>Add to Cart</button>
                            </form>
                          </div>";
                }
            } else {
                echo "<p>No products available in this category</p>";
            }
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Your Furniture Store. All rights reserved.</p>
    </footer>
</body>

</html>