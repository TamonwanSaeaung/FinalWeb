<?php if (!isset($_SESSION)) session_start(); ?>
<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      <div class="flex items-center gap-3">
        <a href="<?php echo ($_SESSION['role'] === 'seller') ? 'dashboard_seller.php' : 'dashboard_customer.php'; ?>"
           class="text-2xl font-bold text-gray-800 hover:text-blue-600 transition flex items-center gap-2">
          <i class="fas fa-store text-blue-500"></i> ร้านขายเสื้อผ้าออนไลน์
        </a>
      </div>


      <!-- <button type="button" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
      Options
      <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
      </svg>
    </button> -->

      <div class="flex items-center gap-4">
        <?php if (isset($_SESSION["username"])): ?>
          <a href="profile.php" class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600">
            <i class="fas fa-user-circle text-xl"></i> <?php echo $_SESSION["username"]; ?>
          </a>

          <a href="logout.php" class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-800">
            <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
          </a>
        <?php else: ?>
          <div class="flex items-center gap-3">
            <a href="login.php" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
              <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
            </a>
            <a href="register.php" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
              <i class="fas fa-user-plus"></i> สมัครสมาชิก
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>


