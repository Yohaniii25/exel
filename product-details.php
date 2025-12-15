<?php
require_once(__DIR__ . '/admin/includes/db.php');

if (!isset($conn)) {
    $db = new Database();
    $conn = $db->getConnection();
}

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($productId <= 0) {
    die("Invalid product ID");
}

$sql = "
    SELECT p.*, 
           c1.name AS category_name, 
           c2.name AS subcategory_name
    FROM products p
    LEFT JOIN categories c1 ON c1.id = p.category_id
    LEFT JOIN categories c2 ON c2.id = p.subcategory_id
    WHERE p.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found.");
}

// Clean description
$productDescription = nl2br(htmlspecialchars($product['description'] ?? 'No description available.'));

// Load filter options
$filterOptions = [];
$filterSql = "
    SELECT f.name AS filter_name, f.filter_type, fo.value
    FROM product_filters pf
    JOIN filter_options fo ON pf.filter_option_id = fo.id
    JOIN filters f ON fo.filter_id = f.id
    WHERE pf.product_id = ?
    ORDER BY f.name, fo.value
";
$filterStmt = $conn->prepare($filterSql);
$filterStmt->bind_param("i", $productId);
$filterStmt->execute();
$filterResult = $filterStmt->get_result();
while ($row = $filterResult->fetch_assoc()) {
    $filterOptions[$row['filter_name']][] = $row['value'];
}
$filterStmt->close();

// Related products
$relatedSql = "
    SELECT id, name, image 
    FROM products 
    WHERE subcategory_id = ? AND id != ?
    LIMIT 10
";
$relatedStmt = $conn->prepare($relatedSql);
$relatedStmt->bind_param("ii", $product['subcategory_id'], $productId);
$relatedStmt->execute();
$relatedResult = $relatedStmt->get_result();
$relatedProducts = $relatedResult->fetch_all(MYSQLI_ASSOC);
$relatedStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - <?= htmlspecialchars($product['name']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <!-- BREADCRUMB -->
    <!-- BREADCRUMB -->
<section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12" 
         style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
            <?= htmlspecialchars($product['name']) ?>
        </h1>
        <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
            <a href="index.php" class="hover:underline text-white/80">Home</a>
            <span class="text-white/60">/</span>

            <?php if ($product['category_name']): ?>
                <?php 
                // Map category name to its correct page URL
                $categorySlugMap = [
                    'Natural Stones' => 'natural-stones.php',
                    'Engineered Stones' => 'engineered-stones.php',
                    'Adhesive & Grout & Industrial Flooring' => 'adhesive-grout.php',
                    'Engineering Services' => 'engineering-services.php',
                    'Tiles' => 'tiles.php',
                    'Mosaics' => 'mosaics.php',
                    'Complete Solutions' => 'complete-solutions.php',
                    // Add more as needed
                ];

                $categoryPage = $categorySlugMap[$product['category_name']] ?? 'category.php?name=' . urlencode($product['category_name']);
                ?>
                <a href="<?= $categoryPage ?>" class="hover:underline text-white/80">
                    <?= htmlspecialchars($product['category_name']) ?>
                </a>
            <?php else: ?>
                <span class="text-white/80">Products</span>
            <?php endif; ?>

            <?php if ($product['subcategory_name'] && $product['subcategory_name'] != $product['category_name']): ?>
                <span class="text-white/60">/</span>
                <span class="text-white"><?= htmlspecialchars($product['subcategory_name']) ?></span>
            <?php endif; ?>
        </nav>
    </div>
</section>

    <!-- PRODUCT DETAILS -->
    <section class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Image -->
        <div data-aos="fade-right">
            <img src="<?= htmlspecialchars($product['image']) ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>"
                 class="w-full rounded-xl shadow-lg object-cover max-h-[600px] mx-auto">
        </div>

        <!-- Details -->
        <div class="flex flex-col space-y-6" data-aos="fade-left">
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($product['name']) ?></h1>
                <p class="text-gray-500 mt-2 text-lg">
                    <?= htmlspecialchars($product['category_name'] . ' - ' . $product['subcategory_name']) ?>
                </p>
            </div>

            <?php if ($product['price'] > 0): ?>
                <p class="text-2xl font-semibold text-blue-600">USD <?= number_format($product['price'], 2) ?></p>
            <?php endif; ?>

            <!-- DESCRIPTION + FILTERS IN ONE SECTION -->
            <div class="prose max-w-none bg-gray-50 p-6 rounded-xl">
                <h2 class="text-xl font-semibold mb-3 flex items-center">
                    <i class="fas fa-info-circle text-yellow-500 mr-2"></i> Product Details
                </h2>

                <!-- Main Description -->
                <?php if (!empty($product['description'])): ?>
                    <div class="mb-6 text-gray-700 leading-relaxed">
                        <?= $productDescription ?>
                    </div>
                <?php endif; ?>

                <!-- Filter Specifications -->
                <?php if (!empty($filterOptions)): ?>
                    <div class="border-t pt-4">
                        <h3 class="text-lg font-semibold mb-3 flex items-center">
                            <i class="fas fa-cogs text-yellow-500 mr-2"></i> Specifications
                        </h3>
                        <dl class="grid grid-cols-1 gap-3 text-sm">
                            <?php foreach ($filterOptions as $filterName => $values): ?>
                                <div class="flex justify-between border-b pb-2">
                                    <dt class="font-medium text-gray-800"><?= htmlspecialchars($filterName) ?>:</dt>
                                    <dd class="text-gray-600 ml-2">
                                        <?= htmlspecialchars(implode(', ', $values)) ?>
                                    </dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    <?php if (!empty($relatedProducts)): ?>
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold mb-6 text-center">Related Products</h2>
        <div class="relative">
            <div id="relatedCarousel" class="flex gap-6 overflow-x-auto scroll-smooth pb-4 snap-x">
                <?php foreach ($relatedProducts as $rel): ?>
                    <a href="product-details.php?id=<?= $rel['id'] ?>"
                       class="w-[220px] bg-white rounded-lg shadow hover:shadow-xl transition-all duration-300 flex-shrink-0 snap-center group">
                        <div class="w-full h-48 overflow-hidden rounded-t-lg">
                            <img src="<?= htmlspecialchars($rel['image']) ?>"
                                 alt="<?= htmlspecialchars($rel['name']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-yellow-600 transition">
                                <?= htmlspecialchars($rel['name']) ?>
                            </h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Scroll Buttons -->
            <button onclick="scrollCarousel(-1)" class="absolute top-1/2 -left-4 transform -translate-y-1/2 bg-white rounded-full shadow-lg p-3 hover:bg-yellow-50 transition">
                <i class="fas fa-chevron-left text-gray-700"></i>
            </button>
            <button onclick="scrollCarousel(1)" class="absolute top-1/2 -right-4 transform -translate-y-1/2 bg-white rounded-full shadow-lg p-3 hover:bg-yellow-50 transition">
                <i class="fas fa-chevron-right text-gray-700"></i>
            </button>
        </div>
    </section>

    <script>
        function scrollCarousel(direction) {
            const carousel = document.getElementById('relatedCarousel');
            const itemWidth = 240;
            carousel.scrollBy({ left: direction * itemWidth, behavior: 'smooth' });
        }
    </script>
    <?php endif; ?>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
</body>
</html>