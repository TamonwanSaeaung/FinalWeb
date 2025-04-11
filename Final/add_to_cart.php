<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $conn->query("UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
    }
}

header("Location: dashboard_customer.php");
exit;
