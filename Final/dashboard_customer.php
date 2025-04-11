<?php
session_start();
require 'config.php';




if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$cart_count_result = $conn->query("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = $user_id");
$cart_count_row = $cart_count_result->fetch_assoc();
$cart_count = $cart_count_row["total_items"] ?? 0;


echo "<script>console.log('user_id: " . $_SESSION["user_id"] . "');</script>";

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>หน้าลูกค้า</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

<div class="max-w-7xl mx-auto px-6 py-8">
  <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-store text-blue-600"></i> สินค้าทั้งหมด
      </h1>
      <a href="cart.php" class="relative inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
  <i class="fas fa-shopping-cart"></i> ตะกร้าของฉัน
  <?php if ($cart_count > 0): ?>
    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5">
      <?php echo $cart_count; ?>
    </span>
  <?php endif; ?>
</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden border border-gray-200">
          <div class="w-full h-48 bg-white flex items-center justify-center overflow-hidden rounded-t-xl">
            <img src="uploads/<?php echo $row["image"]; ?>" alt="รูปสินค้า" class="h-full object-contain transition-transform duration-300">
          </div>

          <div class="p-5">
            <h2 class="text-lg font-semibold text-gray-800 mb-1"><?php echo $row["name"]; ?></h2>
            <p class="text-sm text-gray-600 mb-2"><?php echo $row["description"]; ?></p>
            <div class="flex justify-between items-center mb-2">
              <span class="text-blue-600 font-bold"><?php echo $row["price"]; ?> บาท</span>
              <span class="text-xs px-2 py-1 bg-gray-100 border rounded-full text-gray-600">คงเหลือ: <?php echo $row["quantity"]; ?></span>
            </div>
            <form method="POST" action="add_to_cart.php" class="flex items-center gap-2 mt-4">
              <input type="hidden" name="product_id" value="<?php echo $row["id"]; ?>">
              <input type="number" name="quantity" min="1" max="<?php echo $row["quantity"]; ?>" value="1" class="w-16 px-2 py-1 border rounded">
              <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-500 text-white text-sm rounded shadow-sm hover:bg-green-600 hover:scale-105 transform transition duration-200 ease-in-out">
                <i class="fas fa-cart-plus"></i> ใส่ตะกร้า
              </button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

</body>
</html>
