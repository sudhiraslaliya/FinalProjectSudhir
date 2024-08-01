<?php
include 'db_connect.php';
$product_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Details</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Product Details</h1>
                    </div>
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM products WHERE product_id='$product_id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='col-md-6'>";
                                echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row["name"] . "</h5>";
                                echo "<p class='card-text'>" . $row["description"] . "</p>";
                                echo "<p class='card-text'>Price: $" . $row["price"] . "</p>";
                                echo "<p class='card-text'>Stock: " . $row["stock_quantity"] . "</p>";
                                echo "<form method='post' action='add_to_cart.php'>";
                                echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                                echo "<div class='form-group'>";
                                echo "<label for='quantity'>Quantity:</label>";
                                echo "<input type='number' class='form-control' name='quantity' value='1'>";
                                echo "</div>";
                                echo "<button type='submit' class='btn btn-primary'>Add to Cart</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "Product not found.";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>

</html>