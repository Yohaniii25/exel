<?php
// Ensure user is authenticated
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$user = $_SESSION['user'];
?>
<header class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex justify-between items-center">
    <!-- Left: Dashboard Title -->
    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Dashboard</h1>

    <!-- Right: Visit Site Button and User Menu -->
    <div class="flex items-center space-x-4">
      <a href="/" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-colors duration-200">
        <i class="fas fa-globe mr-2"></i> Visit Site
      </a>
      <div class="relative group">
        <button class="flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
          <i class="fas fa-user-circle text-2xl"></i>
          <span class="ml-2 text-sm font-medium"><?php echo htmlspecialchars($user['email'] ?? $user['username'] ?? 'User'); ?></span>
        </button>
        <!-- Dropdown Menu -->
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block z-10">
          <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</header>