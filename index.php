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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <h1>Online Store</h1>
    <h2>Categories</h2>
    <ul class="categories">
        <?php while ($category = $categoriesResult->fetch_assoc()): ?>
        <li><?php echo $category['name']; ?></li>
        <?php endwhile; ?>
    </ul>

    <h2>Products</h2>
    <div class="product-grid">
        <?php while ($product = $productsResult->fetch_assoc()): ?>
        <div class="product-card">
            <h3><?php echo $product['name']; ?></h3>
            <p>$<?php echo $product['price']; ?></p>
            <p><?php echo $product['description']; ?></p>
            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn"><i
                    class="fas fa-info-circle icon"></i>View Details</a>
        </div>
        <?php endwhile; ?>
    </div>

    <a href="cart.php" class="btn"><i class="fas fa-shopping-cart icon"></i>View Cart</a>
</body>

</html>

<?php
$conn->close();
?>