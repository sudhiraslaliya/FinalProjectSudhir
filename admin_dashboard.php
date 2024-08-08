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
</head>

<body>
    <a href="cart.php" class="cart-btn"><i class="fas fa-shopping-cart icon"></i>View Cart</a>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</p>
        <a href="manage_items.php" class="btn"><i class="fas fa-box icon"></i>Manage Items</a>
        <a href="manage_categories.php" class="btn"><i class="fas fa-tags icon"></i>Manage Categories</a>
        <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
    </div>
</body>

</html>