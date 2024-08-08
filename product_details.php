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

$productId = $_GET['id'];
$productResult = $conn->query("SELECT * FROM items WHERE id=$productId");

if ($productResult->num_rows == 0) {
    echo "Product not found.";
    exit();
}

$product = $productResult->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1><?php echo $product['name']; ?></h1>
    <p>Price: $<?php echo $product['price']; ?></p>
    <p>Description: <?php echo $product['description']; ?></p>

    <form action="cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1">
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>

    <a href="index.php">Back to Products</a>
</body>

</html>

<?php
$conn->close();
?>