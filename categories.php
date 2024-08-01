<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Categories</title>
    <link href="css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Product Categories</h1>
                    </div>
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='col-md-4'>";
                                echo "<div class='card'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row["category_name"] . "</h5>";
                                echo "<a href='categories_products.php?id=" . $row["category_id"] . "' class='btn btn-primary'>View Products</a>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "No categories found.";
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