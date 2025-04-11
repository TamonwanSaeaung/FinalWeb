<?php
session_start();
require 'config.php';

if (isset($_GET["id"])) {
    $cart_id = $_GET["id"];
    $conn->query("DELETE FROM cart WHERE id = $cart_id");
}

header("Location: cart.php");
exit;

// <!DOCTYPE html>
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
//       title: 'ลบสินค้าสำเร็จ!',
//       text: 'สินค้าถูกลบออกจากตะกร้าเรียบร้อยแล้ว',
//       confirmButtonText: 'ตกลง',
//     }).then(() => {
//       window.location.href = 'login.php';
//     });
//   });
// </script>
// </body>
// </html>