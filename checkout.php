<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');
    $total_amount = $_POST['total_amount'];

    $sql = "INSERT INTO orders (user_id, order_date, total_amount) VALUES ('$user_id', '$order_date', '$total_amount')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql_product = "SELECT price FROM products WHERE product_id='$product_id'";
            $result_product = $conn->query($sql_product);
            $row_product = $result_product->fetch_assoc();
            $price = $row_product['price'];
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
            $conn->query($sql_item);
        }
        $_SESSION['cart'] = array(); // clear the cart
        echo "Order placed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Checkout</h1>
                    </div>
                    <form method="post" action="checkout.php" name="checkout">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order Summary</h5>
                                        <?php
                                        $total_amount = 0;

                                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                            $sql = "SELECT * FROM products WHERE product_id='$product_id'";
                                            $result = $conn->query($sql);
                                            $row = $result->fetch_assoc();

                                            $name = $row['name'];
                                            $price = $row['price'];
                                            $total = $price * $quantity;
                                            $total_amount += $total;

                                            echo "<p>$name x $quantity = $$total</p>";
                                        }

                                        echo "<p>Total Amount: $$total_amount</p>";
                                        echo "<input type='hidden' name='total_amount' value='$total_amount'>";
                                        ?>
                                    </div>
                                </div>
                                <div class="card">
                                    <button class="btn btn-secondary">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>

</html>