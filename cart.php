<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_POST['add_to_cart'])) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    if (isset($_POST['remove_from_cart'])) {
        unset($_SESSION['cart'][$productId]);
    }

    if (isset($_POST['update_quantity'])) {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yourfurniture";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productIds = array_keys($_SESSION['cart']);
$products = [];

if (!empty($productIds)) {
    $ids = implode(',', $productIds);
    $productsResult = $conn->query("SELECT * FROM items WHERE id IN ($ids)");

    while ($row = $productsResult->fetch_assoc()) {
        $products[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <h1>Shopping Cart</h1>
    <?php if (empty($products)): ?>
    <p>Your cart is empty.</p>
    <?php else: ?>
    <ul>
        <?php foreach ($products as $product): ?>
        <li>
            <?php echo $product['name']; ?> - $<?php echo $product['price']; ?>
            <form action="cart.php" method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="<?php echo $_SESSION['cart'][$product['id']]; ?>">
                <button type="submit" name="update_quantity" class="btn"><i class="fas fa-sync icon"></i>Update</button>
                <button type="submit" name="remove_from_cart" class="btn"><i
                        class="fas fa-trash icon"></i>Remove</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <a href="checkout.php" class="btn"><i class="fas fa-credit-card icon"></i>Proceed to Checkout</a>
    <?php endif; ?>

    <a href="index.php" class="btn"><i class="fas fa-arrow-left icon"></i>Back to Products</a>
</body>

</html>

<?php
$conn->close();
?>