<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = intval($_POST['cart_id']);
    $action = $_POST['action'];

    // ดึงข้อมูลสินค้าในตะกร้า
    $query = "SELECT cart.quantity, products.quantity AS stock
              FROM cart
              JOIN products ON cart.product_id = products.id
              WHERE cart.id = $cart_id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: cart.php");
        exit;
    }

    $quantity = $row['quantity'];
    $stock = $row['stock'];

    if ($action === 'increase' && $quantity < $stock) {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE id = $cart_id");
    } elseif ($action === 'decrease' && $quantity > 1) {
        $conn->query("UPDATE cart SET quantity = quantity - 1 WHERE id = $cart_id");
    }

    header("Location: cart.php");
    exit;
}
?>
