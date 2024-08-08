<?php
session_start();

if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

header('Location: view_cart.php');
?>