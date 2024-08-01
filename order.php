<?php
include "sessionA.php";
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');
    $total_amount = $_POST['total_amount'];

    $sql = "INSERT INTO orders (user_id, order_date, total_amount) VALUES ('$user_id', '$order_date', '$total_amount')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        foreach ($_POST['products'] as $product_id => $quantity) {
            $price = $_POST['prices'][$product_id];
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
            $conn->query($sql_item);
        }
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
    <title>Place Order</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        <div class="main">
            <?php include "nav.php"; ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Place Order</h1>
                    </div>
                    <form method="post" action="order.php" name="order">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order Summary</h5>
                                        <?php
                                        $sql = "SELECT * FROM products";
                                        $result = $conn->query($sql);
                                        $total_amount = 0;

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<div class='form-group'>";
                                                echo "<label>" . $row["name"] . "</label>";
                                                echo "<input type='number' class='form-control' name='products[" . $row["product_id"] . "]' value='0'>";
                                                echo "<input type='hidden' name='prices[" . $row["product_id"] . "]' value='" . $row["price"] . "'>";
                                                echo "</div>";
                                                $total_amount += $row["price"];
                                            }
                                        }

                                        echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
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