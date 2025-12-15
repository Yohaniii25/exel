<?php
require_once(__DIR__ . '/admin/includes/db.php');

if (!isset($conn)) {
    if (class_exists('Database')) {
        $db = new Database();
        $conn = $db->getConnection();
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $conn = $mysqli;
    } else {
        die('Database connection not found. Please ensure admin/includes/db.php provides $conn or Database class.');
    }
}


$productId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;
$product = null;
$categoryName = '';
$breadcrumbs = [['name' => 'Home', 'url' => 'index.php'], ['name' => 'Sanitaryware', 'url' => 'sanitaryware.php?category=0']];


if ($productId > 0) {
    $stmt = $conn->prepare(
        'SELECT p.*, c.name AS category_name, c.parent_id
         FROM `jaquar_products` p
         LEFT JOIN `jaquar-categories` c ON p.category_id = c.id
         WHERE p.id = ? LIMIT 1'
    );
    if ($stmt) {
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $categoryName = $product['category_name'];
        }
        $stmt->close();
    }

 
    if ($product) {
        $currentId = $product['category_id'];
        $path = [['name' => $product['category_name'], 'url' => 'sanitaryware.php?category=' . $product['category_id']]];
        while ($currentId) {
            $stmt = $conn->prepare('SELECT id, name, parent_id FROM `jaquar-categories` WHERE id = ?');
            if ($stmt) {
                $stmt->bind_param('i', $currentId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    if ($row['parent_id']) {
                        $path[] = ['name' => $row['name'], 'url' => 'sanitaryware.php?category=' . $row['id']];
                    }
                    $currentId = $row['parent_id'];
                } else {
                    break;
                }
                $stmt->close();
            }
        }
        $breadcrumbs = array_merge($breadcrumbs, array_reverse($path));
        $breadcrumbs[] = ['name' => $product['item_code'], 'url' => ''];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Jaquar Product Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .product-image {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .product-image.animate {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <section class="w-full bg-center bg-cover relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
        style="background-image: url('<?php echo htmlspecialchars($product && !empty($product['image']) ? $product['image'] : './assets/img/bath_solution.jpg'); ?>');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-3 sm:mb-4 leading-tight">
                <?php echo htmlspecialchars($product ? $product['item_code'] : 'Product Not Found'); ?>
            </h1>
            <nav class="text-xs sm:text-sm md:text-base 2xl:text-lg space-x-1 sm:space-x-2">
                <?php foreach ($breadcrumbs as $index => $crumb): ?>
                    <?php if ($index < count($breadcrumbs) - 1): ?>
                        <a href="<?= htmlspecialchars($crumb['url']) ?>" class="hover:underline text-white/80"><?php echo htmlspecialchars($crumb['name']); ?></a>
                        <span class="text-white/60">/</span>
                    <?php else: ?>
                        <span class="text-white"><?php echo htmlspecialchars($crumb['name']); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        </div>
    </section>

    <section class="py-10 sm:py-16 2xl:py-20 bg-white">
        <div class="container max-w-7xl 2xl:max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
            <?php if ($product): ?>
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Product Image -->
                    <div class="lg:w-1/2">
                        <img src="<?php echo htmlspecialchars($product['image'] ?: './assets/img/bg-about.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($product['item_code']); ?>"
                             class="w-full h-auto rounded-xl shadow-lg product-image"
                             data-aos="fade-up">
                    </div>
                    <!-- Product Details -->
                    <div class="lg:w-1/2">
                        <h2 class="text-2xl sm:text-3xl 2xl:text-4xl font-bold text-gray-900 mb-4">
                            <?php echo htmlspecialchars($product['item_code']); ?>
                        </h2>
                        <div class="space-y-4">
                            <?php if (!empty($product['category_name'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg">
                                    <span class="font-semibold">Category:</span> <?php echo htmlspecialchars($product['category_name']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($product['collection'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg">
                                    <span class="font-semibold">Collection:</span> <?php echo htmlspecialchars($product['collection']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($product['item_type'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg">
                                    <span class="font-semibold">Type:</span> <?php echo htmlspecialchars($product['item_type']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($product['item_finish'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg">
                                    <span class="font-semibold">Finish:</span> <?php echo htmlspecialchars($product['item_finish']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($product['product_link'])): ?>
                                <p class="text-gray-600 text-base sm:text-lg">
                                    <span class="font-semibold">Product Link:</span> 
                                    <a href="<?php echo htmlspecialchars($product['product_link']); ?>" 
                                       class="text-yellow-500 hover:underline" target="_blank">View More</a>
                                </p>
                            <?php endif; ?>
                        </div>
                        <a href="sanitaryware.php?category=<?php echo $product['category_id']; ?>" 
                           class="mt-6 inline-flex items-center px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Products
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl 2xl:text-2xl font-bold text-gray-900 mb-2">Product Not Found</h3>
                        <p class="text-gray-500 mb-6 text-base 2xl:text-lg">The requested product could not be found.</p>
                        <a href="sanitaryware.php?category=0" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Browse All Categories
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.product-image');
            const observerOptions = { threshold: 0.1, rootMargin: '50px 0px' };
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        imageObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            images.forEach(img => imageObserver.observe(img));

            images.forEach(img => {
                if (!img.complete) {
                    img.classList.add('loading-skeleton');
                    img.addEventListener('load', function() { this.classList.remove('loading-skeleton'); });
                }
            });
        });
    </script>
</body>
</html>