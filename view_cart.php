<?php
session_start();
include 'db_connect.php';

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $_SESSION['cart'][$product_id] = $quantity;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shopping Cart</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Shopping Cart</h1>
                    </div>
                    <div class="row">
                        <?php
                        if (empty($_SESSION['cart'])) {
                            echo "<p>Your cart is empty.</p>";
                        } else {
                            echo "<table class='table'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Product</th>";
                            echo "<th>Quantity</th>";
                            echo "<th>Price</th>";
                            echo "<th>Total</th>";
                            echo "<th>Actions</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            $total_amount = 0;

                            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                $sql = "SELECT * FROM products WHERE product_id='$product_id'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();

                                $name = $row['name'];
                                $price = $row['price'];
                                $total = $price * $quantity;
                                $total_amount += $total;

                                echo "<tr>";
                                echo "<td>$name</td>";
                                echo "<td>";
                                echo "<form method='post' action='view_cart.php'>";
                                echo "<input type='hidden' name='product_id' value='$product_id'>";
                                echo "<input type='number' name='quantity' value='$quantity'>";
                                echo "<button type='submit' name='update' class='btn btn-primary btn-sm'>Update</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "<td>$$price</td>";
                                echo "<td>$$total</td>";
                                echo "<td>";
                                echo "<form method='post' action='view_cart.php'>";
                                echo "<input type='hidden' name='product_id' value='$product_id'>";
                                echo "<button type='submit' name='remove' class='btn btn-danger btn-sm'>Remove</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }

                            echo "<tr>";
                            echo "<td colspan='3'>Total</td>";
                            echo "<td>$$total_amount</td>";
                            echo "<td></td>";
                            echo "</tr>";

                            echo "</tbody>";
                            echo "</table>";
                            echo "<a href='checkout.php' class='btn btn-primary'>Checkout</a>";
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>

</html>