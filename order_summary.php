<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

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
    $totalPrice = 0;

    if (!empty($productIds)) {
        $ids = implode(',', $productIds);
        $productsResult = $conn->query("SELECT * FROM items WHERE id IN ($ids)");

        while ($row = $productsResult->fetch_assoc()) {
            $quantity = $_SESSION['cart'][$row['id']];
            $price = $row['price'];
            $total = $price * $quantity;
            $products[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
            ];
            $totalPrice += $total;
        }
    }

    // Insert the order into the orders table using correct column names
    $stmt = $conn->prepare("INSERT INTO orders (name, email, address, total) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sssd", $name, $email, $address, $totalPrice);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Insert the order items into the order_items table
    foreach ($products as $product) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("iiid", $orderId, $product['id'], $product['quantity'], $product['price']);
        $stmt->execute();
        $stmt->close();
    }

    // Display the order summary
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Summary</title>
        <link rel='stylesheet' href='css/styles.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>
    </head>
    <body>
        <h1>Order Summary</h1>
        <p>Name: $name</p>
        <p>Email: $email</p>
        <p>Address: $address</p>
        <ul>";

    foreach ($products as $product) {
        echo "<li>{$product['name']} - \${$product['price']} x {$product['quantity']} = \${$product['total']}</li>";
    }

    echo "</ul>
        <p>Total Price: \$$totalPrice</p>
        <a href='index.php' class='btn'><i class='fas fa-arrow-left icon'></i>Back to Products</a>
    </body>
    </html>
    ";

    $conn->close();
    unset($_SESSION['cart']);
} else {
    header("Location: checkout.php");
    exit();
}
?>