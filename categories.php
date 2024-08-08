<?php
session_start();
include 'db_connect.php';

// Retrieve categories from the database
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header>
        <h1>Product Categories</h1>
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
        <div id="categories">
            <?php
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    echo "<div class='category'>
                            <h3>{$category['name']}</h3>
                            <a href='categories_products.php?category_id={$category['id']}'>View Products</a>
                          </div>";
                }
            } else {
                echo "<p>No categories available</p>";
            }
            ?>
        </div>
    </main>
</body>

</html>