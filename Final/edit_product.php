<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_save'])) {
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $qty = $_POST["quantity"];
    $image = $product["image"];

    if ($_FILES["image"]["name"]) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, quantity=?, image=? WHERE id=?");
    $stmt->bind_param("ssdisi", $name, $desc, $price, $qty, $image, $id);
    $stmt->execute();
    header("Location: dashboard_seller.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขสินค้า</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
  <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 flex items-center justify-center gap-2">
    <i class="fas fa-edit text-orange-500"></i> แก้ไขสินค้า
  </h2>

  <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-5">
    <input type="hidden" name="confirm_save" value="1">

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อผ้า</label>
      <input type="text" name="name" value="<?php echo $product["name"]; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">คำอธิบาย</label>
      <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo $product["description"]; ?></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ราคา (บาท)</label>
        <input type="number" name="price" value="<?php echo $product["price"]; ?>" required inputmode="decimal" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">จำนวนคงเหลือ</label>
        <input type="number" name="quantity" value="<?php echo $product["quantity"]; ?>" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">รูปภาพใหม่ (ไม่เลือกจะใช้รูปเดิม)</label>
      <input type="file" name="image" class="w-full border rounded-md px-4 py-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>

    <div class="flex justify-between items-center mt-6">
      <a href="dashboard_seller.php" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
        <i class="fas fa-arrow-left"></i> ย้อนกลับ
      </a>
      <button type="button" onclick="confirmEdit()" class="inline-flex items-center gap-2 px-5 py-2 bg-orange-500 text-white rounded-md shadow hover:bg-orange-600 hover:scale-105 transform transition duration-200 ease-in-out">
        <i class="fas fa-save"></i> บันทึกการแก้ไข
      </button>
    </div>
  </form>
</div>

<script>
function confirmEdit() {
  Swal.fire({
    title: 'ยืนยันการแก้ไข?',
    text: "คุณต้องการบันทึกการแก้ไขสินค้านี้หรือไม่?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('editProductForm').submit();
    }
  });
}
</script>

</body>
</html>