<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    // If there is no order_id in session, redirect to the home page
    header('Location: index.php');
    exit();
}

// Include database connection file
include 'db_connect.php';

// Retrieve the order details from the database
$order_id = $_SESSION['order_id'];
$sql = "SELECT * FROM orders WHERE id = $order_id";
$order_result = $conn->query($sql);

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    // If no order found, redirect to the home page
    header('Location: index.php');
    exit();
}

// Retrieve the order items
$sql = "SELECT * FROM order_items WHERE order_id = $order_id";
$order_items_result = $conn->query($sql);
$order_items = [];

if ($order_items_result->num_rows > 0) {
    while ($row = $order_items_result->fetch_assoc()) {
        $order_items[] = $row;
    }
}

// Clear the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header>
        <h1>Order Confirmation</h1>
    </header>
    <main>
        <h2>Thank you for your order!</h2>
        <p>Order ID: <?php echo $order['id']; ?></p>
        <p>Name: <?php echo $order['name']; ?></p>
        <p>Address: <?php echo $order['address']; ?></p>
        <p>Email: <?php echo $order['email']; ?></p>

        <h3>Order Summary</h3>
        <ul>
            <?php foreach ($order_items as $item): ?>
            <li>
                <?php echo $item['product_name']; ?> - $<?php echo $item['price']; ?> x <?php echo $item['quantity']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <p>Total: $<?php echo $order['total']; ?></p>
    </main>
</body>

</html>