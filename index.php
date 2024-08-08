<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yourfurniture";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories
$categoriesResult = $conn->query("SELECT * FROM categories");

if (!$categoriesResult) {
    die("Query for categories failed: " . $conn->error);
}

// Fetch products
$productsResult = $conn->query("SELECT * FROM items");

if (!$productsResult) {
    die("Query for products failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <h1>Online Store</h1>
    <h2>Categories</h2>
    <ul>
        <?php while ($category = $categoriesResult->fetch_assoc()): ?>
        <li><?php echo $category['name']; ?></li>
        <?php endwhile; ?>
    </ul>

    <h2>Products</h2>
    <ul>
        <?php while ($product = $productsResult->fetch_assoc()): ?>
        <li>
            <a href="product_details.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
            - $<?php echo $product['price']; ?>
        </li>
        <?php endwhile; ?>
    </ul>

    <a href="cart.php">View Cart</a>
</body>

</html>

<?php
$conn->close();
?>