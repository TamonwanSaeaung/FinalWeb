<?php
require 'config.php';

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);


    // echo "<script>console.log('stmt====> " .  $stmt . "');</script>";
    // echo "<script>console.log('username====> " .  $username . "');</script>";
    // echo "<script>console.log('email====> " .  $email . "');</script>";
    // echo "<script>console.log('password====> " .  $password . "');</script>";
    // echo "<script>console.log('role====> " .  $role . "');</script>";


    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">สมัครสมาชิก</h2>
    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
        <input type="text" name="username" required class="mt-1 w-full px-4 py-2 border rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">อีเมล</label>
        <input type="email" name="email" required class="mt-1 w-full px-4 py-2 border rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
        <input type="password" name="password" required class="mt-1 w-full px-4 py-2 border rounded-md">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">ประเภทผู้ใช้</label>
        <select name="role" required class="mt-1 w-full px-4 py-2 border rounded-md">
          <option value="customer">ลูกค้า</option>
          <option value="seller">ผู้ขาย</option>
          <!-- <option value="1">ลูกค้า</option>
          <option value="2">ผู้ขาย</option> -->
        </select>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">สมัครสมาชิก</button>
    </form>
  </div>

  <?php if ($success): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'สมัครสมาชิกสำเร็จ!',
        text: 'ไปยังหน้าเข้าสู่ระบบ',
        confirmButtonText: 'ตกลง'
      }).then(() => {
        window.location.href = 'login.php';
      });
    </script>
  <?php endif; ?>
</body>
</html>

<!-- // <!DOCTYPE html>
// <html lang="th">
// <head>
//   <meta charset="UTF-8">
//   <script src="https://cdn.tailwindcss.com"></script>
//   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
//   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
// </head>
// <body class="bg-gray-100">
// <script>
//   document.addEventListener('DOMContentLoaded', function () {
//     Swal.fire({
//       icon: 'success',
//       title: 'สำเร็จ',
//       confirmButtonText: 'ตกลง',
//     }).then(() => {
//       window.location.href = 'login.php';
//     });
//   });
// </script>
// </body>
// </html> -->