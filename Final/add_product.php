<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "seller") {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_save"])) {
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $qty = $_POST["quantity"];
    $image = "";

    //echo "<script>console.log('$name====> " .  $$name . "');</script>";
    // echo "<script>console.log('$desc====> " .  $$desc . "');</script>";
    // echo "<script>console.log('$price====> " .  $$price . "');</script>";
    // echo "<script>console.log('$qty====> " .  $$qty . "');</script>";
    // echo "<script>console.log('$image====> " .  $$image . "');</script>";
    // echo "<script>console.log('$_FILES====> " .  $_FILES["image"]["name"] . "');</script>";
    // if ($_FILES["image"]["error"] != 0) {
    //     echo "<script>alert('Error uploading file.');</script>";
    //     exit;
    // }

    if ($_FILES["image"]["name"]) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, quantity, image) VALUES (?, ?, ?, ?, ?)");
    
    console_log("stmt====>",$stmt);
    // if ($stmt === false) {
    //     die('Prepare failed: ' . htmlspecialchars($conn->error));
    // }
    
    $stmt->bind_param("ssdis", $name, $desc, $price, $qty, $image);
    $stmt->execute();

    header("Location: dashboard_seller.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มสินค้า</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
  <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 flex items-center justify-center gap-2">
    <i class="fas fa-plus-circle text-blue-500"></i> เพิ่มสินค้าใหม่
  </h2>

  <form id="addProductForm" method="POST" enctype="multipart/form-data" class="space-y-5">
    <input type="hidden" name="confirm_save" value="1">

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อผ้า</label>
      <input type="text" name="name" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">คำอธิบาย</label>
      <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ราคา (บาท)</label>
        <input type="number" name="price" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">จำนวนคงเหลือ</label>
        <input type="number" name="quantity" required class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">รูปภาพสินค้า</label>
      <input type="file" name="image" class="w-full border rounded-md px-4 py-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>

    <div class="flex justify-between items-center mt-6">
      <a href="dashboard_seller.php" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
        <i class="fas fa-arrow-left"></i> ย้อนกลับ
      </a>
      <button type="button" onclick="confirmSubmit()" class="inline-flex items-center gap-2 px-5 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 hover:scale-105 transform transition duration-200 ease-in-out">
        <i class="fas fa-save"></i> บันทึกสินค้า
      </button>
    </div>
  </form>
</div>

<script>
function confirmSubmit() {
  Swal.fire({
    title: 'ยืนยันการบันทึก?',
    text: "คุณต้องการเพิ่มสินค้านี้ใช่หรือไม่?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('addProductForm').submit();
    }
  });
}
</script>

</body>
</html>
