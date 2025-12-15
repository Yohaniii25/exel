<?php
include_once(__DIR__ . "/includes/auth.php");
include_once(__DIR__ . "/includes/db.php");

$database = new Database();
$conn = $database->getConnection();

$project_count = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];
$product_count = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'] ?? 0;



$page = $_GET['page'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @keyframes slideIn {
      0% {
        transform: translateY(20px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }
    .animate-slide-in {
      animation: slideIn 0.5s ease-out forwards;
    }
    .card:nth-child(1) {
      animation-delay: 0.1s;
    }
    .card:nth-child(2) {
      animation-delay: 0.2s;
    }
    .card:nth-child(3) {
      animation-delay: 0.3s;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen font-sans transition-all duration-300">

  <?php include "includes/header.php"; ?>
  <?php include "includes/sidebar.php"; ?>

  <div class="md:ml-64 p-6 lg:p-8 pt-20">
    <?php
    if ($page === 'add_project') {
      include "pages/add_project.php";
    } elseif ($page === 'project_list') {
      include "pages/project_list.php";
    } elseif ($page === 'add_product') {
      include "pages/add_product.php";
    } elseif ($page === 'product_list') {
      include "pages/product_list.php";
    } elseif ($page === 'add_category_description') {
      include "pages/add_category_description.php";
    } elseif ($page === 'jaquar_products') {
      include "pages/jaquar_products.php";
    } elseif ($page === 'add_jaquar_product') {
      include "pages/add_jaquar_product.php";

    } else {

    ?>
      <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

  
          <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Projects</h3>
                <p class="text-4xl font-bold mt-2 text-blue-600"><?php echo $project_count; ?></p>
              </div>
              <i class="fas fa-folder-open text-3xl text-blue-200"></i>
            </div>
            <a href="?page=project_list" class="text-sm text-blue-500 mt-4 inline-block hover:text-blue-600 transition-colors duration-200">View Projects</a>
          </div>

          <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                <p class="text-4xl font-bold mt-2 text-green-600"><?php echo $product_count; ?></p>
              </div>
              <i class="fas fa-box text-3xl text-green-200"></i>
            </div>
            <a href="?page=product_list" class="text-sm text-green-500 mt-4 inline-block hover:text-green-600 transition-colors duration-200">View Products</a>
          </div>



        </div>
      </div>
    <?php
    }
    ?>
  </div>
</body>
</html>
