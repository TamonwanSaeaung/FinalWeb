<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];


$total = 0;
$order_items = [];

$items = $conn->query("SELECT cart.product_id, cart.quantity, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = $user_id");

while ($item = $items->fetch_assoc()) {
    $pid = $item["product_id"];
    $qty = $item["quantity"];
    $price = $item["price"];
    $sum = $price * $qty;
    $total += $sum;

    $order_items[] = [
        "product_id" => $pid,
        "quantity" => $qty,
        "price" => $price
    ];

    $update = $conn->query("UPDATE products SET quantity = quantity - $qty WHERE id = $pid AND quantity >= $qty");
    // if ($conn->affected_rows == 0) {
    //     echo "<script>alert('สินค้าหมด');</script>";
    //     exit;
    // }
    if (!$update) {
        echo "<script>console.log('ไม่สามารถอัปเดตสินค้า ID $pid ได้: " . $conn->error . "');</script>";
    }else{
        echo "<script>console.log('อัปเดตสินค้า ID $pid สำเร็จ');</script>";
    }
}

$conn->query("INSERT INTO orders (user_id, total) VALUES ($user_id, $total)");
$order_id = $conn->insert_id;

foreach ($order_items as $item) {
    $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})");
}

$conn->query("DELETE FROM cart WHERE user_id = $user_id");


?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สั่งซื้อสำเร็จ</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      icon: 'success',
      title: 'สั่งซื้อเรียบร้อยแล้ว!',
      text: 'ขอบคุณสำหรับการสั่งซื้อ ',
      confirmButtonText: 'กลับหน้าหลัก',
    }).then(() => {
      window.location.href = 'dashboard_customer.php';
    });
  });
</script>
</body>
</html>