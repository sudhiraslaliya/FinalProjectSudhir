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
    if (isset($_POST['add_category'])) {
        $categoryName = $_POST['category_name'];
        $conn->query("INSERT INTO categories (name) VALUES ('$categoryName')");
    } elseif (isset($_POST['delete_category'])) {
        $categoryId = $_POST['category_id'];
        $conn->query("DELETE FROM categories WHERE id=$categoryId");
    } elseif (isset($_POST['update_category'])) {
        $categoryId = $_POST['category_id'];
        $categoryName = $_POST['category_name'];
        $conn->query("UPDATE categories SET name='$categoryName' WHERE id=$categoryId");
    }
    header("Location: manage_categories.php");
    exit();
}

// Fetch categories for display
$categoriesResult = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart icon"></i>View Cart</a>
    <div class="container">
        <h1>Manage Categories</h1>
        <form action="manage_categories.php" method="POST">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit" name="add_category" class="btn"><i class="fas fa-plus icon"></i>Add Category</button>
        </form>

        <h2>Categories</h2>
        <ul>
            <?php while ($category = $categoriesResult->fetch_assoc()): ?>
            <li>
                <?php echo $category['name']; ?>
                <form action="manage_categories.php" method="POST" style="display:inline;">
                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                    <input type="text" name="category_name" value="<?php echo $category['name']; ?>" required>
                    <button type="submit" name="update_category" class="btn"><i
                            class="fas fa-sync icon"></i>Update</button>
                    <button type="submit" name="delete_category" class="btn"><i
                            class="fas fa-trash icon"></i>Delete</button>
                </form>
            </li>
            <?php endwhile; ?>
        </ul>
        <a href="admin_dashboard.php" class="btn"><i class="fas fa-arrow-left icon"></i>Back</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>