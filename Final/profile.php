<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // $password2 = $_POST['password2'];
    // echo "<script>console.log('password====> " .  $password . "');</script>";
    // echo "<script>console.log('password2====> " .  $password2 . "');</script>";
    // if ($password !== $password2) {
    //     echo "<script>alert('รหัสผ่านไม่ตรงกัน');</script>";
    //     exit;
    // }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $hashed, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $email, $user_id);
    }

    $stmt->execute();
    $_SESSION['username'] = $username;
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขโปรไฟล์</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- <script>
function confirmUpdate() {
  Swal.fire({
    title: 'ยืนยันการแก้ไข?',
    text: "คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลหรือไม่?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลก',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('profileForm').submit();
    }
  });
}
</script> -->

<body class="bg-gray-100 min-h-screen">
<?php include 'navbar.php'; ?>

<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-lg shadow">
  <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
    <i class="fas fa-user-cog text-blue-500"></i> แก้ไขโปรไฟล์
  </h2>

  <form id="profileForm" method="POST" class="space-y-5">
    <input type="hidden" name="confirm_update" value="1">
    <div>
      <label class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
             class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">อีเมล</label>
      <input type="email" name="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required
             class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)</label>
      <input type="password" name="password"
             placeholder="ใส่รหัสผ่านใหม่ (ถ้าเปลี่ยน)"
             class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <!-- <div>
      <label class="block text-sm font-medium text-gray-700">ยืนยันรหัสผ่าน</label>
      <input type="password2" name="password"
             placeholder="ยืนยันรหัสผ่าน"
             class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div> -->
    <div class="flex justify-end">
      <button type="button" onclick="confirmUpdate()"
              class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        <i class="fas fa-save mr-2"></i> บันทึกข้อมูล
      </button>
    </div>
  </form>
</div>

<script>
function confirmUpdate() {
  Swal.fire({
    title: 'ยืนยันการแก้ไข?',
    text: "คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลหรือไม่?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('profileForm').submit();
    }
  });
}
</script>

</body>
</html>