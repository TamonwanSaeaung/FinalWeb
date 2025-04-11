<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT cart.id, products.name, products.price, cart.quantity, products.id AS product_id, products.quantity AS stock
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";
$result = $conn->query($sql);

$total = 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ตะกร้าสินค้า</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

<div class="max-w-5xl mx-auto px-6 py-8">
  <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-shopping-cart text-blue-500"></i> ตะกร้าสินค้า
      </h2>
      <a href="dashboard_customer.php" class="text-sm text-blue-600 hover:underline">
        <i class="fas fa-arrow-left"></i> กลับไปซื้อเพิ่ม
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left border border-gray-200">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2">ชื่อสินค้า</th>
            <th class="px-4 py-2">ราคา</th>
            <th class="px-4 py-2">จำนวน</th>
            <th class="px-4 py-2">รวม</th>
            <th class="px-4 py-2">ลบ</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): 
            $sum = $row["price"] * $row["quantity"];
            $total += $sum;
          ?>
          <tr class="border-t">
            <td class="px-4 py-2 text-gray-800"><?php echo $row["name"]; ?></td>
            <td class="px-4 py-2 text-blue-600 font-semibold"><?php echo $row["price"]; ?> บาท</td>
            <td class="px-4 py-2">
              <form method="POST" action="update_quantity.php" class="flex items-center gap-2">
                <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                <span><?php echo $row["quantity"]; ?></span>
                <button type="submit" name="action" value="increase" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" <?php if ($row['quantity'] >= $row['stock']) echo 'disabled'; ?>>+</button>
              </form>
            </td>
            <td class="px-4 py-2"><?php echo $sum; ?> บาท</td>
            <td class="px-4 py-2">
              <a href="remove_cart.php?id=<?php echo $row["id"]; ?>" 
                 onclick="return confirm('ลบสินค้านี้ใช่ไหม?')"
                 class="text-red-600 hover:text-red-800">
                <i class="fas fa-trash-alt"></i> ลบ
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="text-right mt-6">
      <h3 class="text-xl font-semibold text-gray-800">รวมทั้งหมด: <span class="text-blue-600"><?php echo $total; ?> บาท</span></h3>
    </div>

    <form id="checkoutForm" method="POST" class="text-right mt-4">
      <button type="button" onclick="confirmCheckout()" class="inline-flex items-center gap-2 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
        <i class="fas fa-check-circle"></i> ยืนยันการสั่งซื้อ
      </button>
    </form>
  </div>
</div>

<script>
function confirmCheckout() {
  Swal.fire({
    title: 'ยืนยันการสั่งซื้อ?',
    text: 'คุณต้องการดำเนินการสั่งซื้อสินค้าทั้งหมดในตะกร้าหรือไม่?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, สั่งซื้อเลย',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'checkout=1'
      })
      .then(() => {
        Swal.fire({
          icon: 'success',
          title: 'สั่งซื้อเรียบร้อยแล้ว!',
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
          window.location.reload();
        });
      });
    }
  });
}
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
  $conn->query("DELETE FROM cart WHERE user_id = $user_id");
  exit;
}
?>

</body>
</html>