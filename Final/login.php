<?php
session_start();
require 'config.php';

$login_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["username"] = $user["username"];

        if ($user["role"] === "seller") {
            header("Location: dashboard_seller.php");
        } else {
            header("Location: dashboard_customer.php");
        }
        exit;
    } else {
        $login_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">เข้าสู่ระบบ</h2>
    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
        <input type="text" name="username" required class="mt-1 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
        <input type="password" name="password" required class="mt-1 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">เข้าสู่ระบบ</button>
    </form>
    <p class="mt-4 text-center text-sm">ยังไม่มีบัญชี? <a href="register.php" class="text-blue-600 hover:underline">สมัครสมาชิก</a></p>
  </div>

  <?php if ($login_error): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'เข้าสู่ระบบไม่สำเร็จ',
        text: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
        confirmButtonText: 'ตกลง',
      });
    </script>
  <?php endif; ?>
</body>
</html>
