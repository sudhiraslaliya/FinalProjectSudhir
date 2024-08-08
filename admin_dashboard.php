<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart icon"></i>View Cart</a>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</p>
        <a href="manage_items.php" class="btn"><i class="fas fa-box icon"></i>Manage Items</a>
        <a href="manage_categories.php" class="btn"><i class="fas fa-tags icon"></i>Manage Categories</a>
        <a href="admin_orders.php" class="btn"><i class="fas fa-list icon"></i>Check Order List</a>
        <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
        <a href="index.php" class="btn"><i class="fas fa-home icon"></i>Main Page</a>
    </div>
    <div class="footer">
        <p>&copy; 2024 Sudhir Aslaliya</p>
    </div>
</body>

</html>