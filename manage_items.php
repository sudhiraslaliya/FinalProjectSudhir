<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yourfurniture";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_item'])) {
        $itemName = $_POST['item_name'];
        $itemCategory = $_POST['item_category'];
        $itemPrice = $_POST['item_price'];
        $itemDescription = $_POST['item_description'];
        $conn->query("INSERT INTO items (name, category_id, price, description) VALUES ('$itemName', $itemCategory, $itemPrice, '$itemDescription')");
    } elseif (isset($_POST['delete_item'])) {
        $itemId = $_POST['item_id'];
        $conn->query("DELETE FROM items WHERE id=$itemId");
    } elseif (isset($_POST['update_item'])) {
        $itemId = $_POST['item_id'];
        $itemName = $_POST['item_name'];
        $itemCategory = $_POST['item_category'];
        $itemPrice = $_POST['item_price'];
        $itemDescription = $_POST['item_description'];
        $conn->query("UPDATE items SET name='$itemName', category_id=$itemCategory, price=$itemPrice, description='$itemDescription' WHERE id=$itemId");
    }
    header("Location: manage_items.php");
    exit();
}

// Fetch items for display
$itemsResult = $conn->query("SELECT * FROM items");
$categoriesResult = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart icon"></i>View Cart</a>
    <div class="container">
        <h1>Manage Items</h1>
        <form action="manage_items.php" method="POST">
            <input type="text" name="item_name" placeholder="Item Name" required>
            <select name="item_category" required>
                <?php while ($category = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="item_price" placeholder="Price" step="0.01" required>
            <input type="text" name="item_description" placeholder="Description" required>
            <button type="submit" name="add_item" class="btn"><i class="fas fa-plus icon"></i>Add Item</button>
        </form>

        <h2>Items</h2>
        <ul>
            <?php while ($item = $itemsResult->fetch_assoc()): ?>
            <li>
                <?php echo $item['name']; ?> - $<?php echo $item['price']; ?>
                <form action="manage_items.php" method="POST" style="display:inline;">
                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                    <input type="text" name="item_name" value="<?php echo $item['name']; ?>" required>
                    <select name="item_category" required>
                        <?php
                            $categoriesResult->data_seek(0); // Reset pointer to the start of the result set
                            while ($category = $categoriesResult->fetch_assoc()): ?>
                        <option value="<?php echo $category['id']; ?>"
                            <?php if ($category['id'] == $item['category_id']) echo 'selected'; ?>>
                            <?php echo $category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="number" name="item_price" value="<?php echo $item['price']; ?>" step="0.01" required>
                    <input type="text" name="item_description" value="<?php echo $item['description']; ?>" required>
                    <button type="submit" name="update_item" class="btn"><i class="fas fa-sync icon"></i>Update</button>
                    <button type="submit" name="delete_item" class="btn"><i
                            class="fas fa-trash icon"></i>Delete</button>
                </form>
            </li>
            <?php endwhile; ?>
        </ul>
        <a href="admin_dashboard.php" class="btn"><i class="fas fa-arrow-left icon"></i>Back</a>
    </div>
    <div class="footer">
        <p>&copy; 2024 Sudhir Aslaliya</p>
    </div>
</body>

</html>

<?php
$conn->close();
?>