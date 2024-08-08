<?php
session_start();
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
    if (isset($_POST['add_category'])) {
        $categoryName = $_POST['category_name'];
        $conn->query("INSERT INTO categories (name) VALUES ('$categoryName')");
    } elseif (isset($_POST['delete_category'])) {
        $categoryId = $_POST['category_id'];
        $conn->query("DELETE FROM categories WHERE id=$categoryId");
    } elseif (isset($_POST['add_item'])) {
        $itemName = $_POST['item_name'];
        $itemCategory = $_POST['item_category'];
        $itemPrice = $_POST['item_price'];
        $itemDescription = $_POST['item_description'];
        $conn->query("INSERT INTO items (name, category_id, price, description) VALUES ('$itemName', $itemCategory, $itemPrice, '$itemDescription')");
    } elseif (isset($_POST['delete_item'])) {
        $itemId = $_POST['item_id'];
        $conn->query("DELETE FROM items WHERE id=$itemId");
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch categories and items for display
$categoriesResult = $conn->query("SELECT * FROM categories");
$itemsResult = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <h1>Admin Dashboard</h1>
    <h2>Categories</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="text" name="category_name" placeholder="New Category">
        <button type="submit" name="add_category">Add Category</button>
    </form>
    <ul>
        <?php while ($category = $categoriesResult->fetch_assoc()): ?>
        <li>
            <?php echo $category['name']; ?>
            <form action="admin_dashboard.php" method="POST" style="display:inline;">
                <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                <button type="submit" name="delete_category">Delete</button>
            </form>
        </li>
        <?php endwhile; ?>
    </ul>

    <h2>Items</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="text" name="item_name" placeholder="New Item">
        <input type="text" name="item_category" placeholder="Category ID">
        <input type="number" name="item_price" placeholder="Price">
        <input type="text" name="item_description" placeholder="Description">
        <button type="submit" name="add_item">Add Item</button>
    </form>
    <ul>
        <?php while ($item = $itemsResult->fetch_assoc()): ?>
        <li>
            <?php echo $item['name']; ?> - $<?php echo $item['price']; ?> (Category ID:
            <?php echo $item['category_id']; ?>)
            <form action="admin_dashboard.php" method="POST" style="display:inline;">
                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                <button type="submit" name="delete_item">Delete</button>
            </form>
        </li>
        <?php endwhile; ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>

</html>

<?php
$conn->close();
?>