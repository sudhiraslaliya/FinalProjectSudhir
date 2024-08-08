<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the cart exists in the session and is an array
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialize the cart if it does not exist
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

    // Retrieve products from the session cart
    $productIds = array_keys($_SESSION['cart']);
    $products = [];
    $totalPrice = 0;

    if (!empty($productIds)) {
        $ids = implode(',', $productIds);
        $productsResult = $conn->query("SELECT * FROM items WHERE id IN ($ids)");

        while ($row = $productsResult->fetch_assoc()) {
            $row['quantity'] = $_SESSION['cart'][$row['id']];
            $row['total'] = $row['price'] * $row['quantity'];
            $products[] = $row;
            $totalPrice += $row['total'];
        }
    }

    // Display the order summary
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Summary</title>
        <link rel='stylesheet' href='/styles.css'>
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
        <a href='index.php' class='btn'>Back to Products</a>
    </body>
    </html>
    ";

    $conn->close();
    // Clear the cart after displaying the summary
    unset($_SESSION['cart']);
} else {
    header("Location: checkout.php");
    exit();
}
?>