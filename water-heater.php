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

if (!function_exists('slugify')) {
    function slugify($text) {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower($text));
        $text = trim($text, '-');
        return $text;
    }
}

$categoryFilter = 0;
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $categoryFilter = (int) $_GET['category'];
}

$categories = [];
$subCategories = [];
$categoryName = '';
$categoryImage = './assets/img/bath_solution.jpg';
$categoryDescription = '';

if ($categoryFilter == 0) {
    $stmt = $conn->prepare('SELECT id, name, image FROM `jaquar-categories` WHERE parent_id = 3 ORDER BY name ASC');
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $stmt->close();
}

if ($categoryFilter != 0) {

    $stmt = $conn->prepare('SELECT id, name, image, description FROM `jaquar-categories` WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $categoryFilter);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $descRow = $result->fetch_assoc();
        $categoryName = $descRow['name'];
        $categoryDescription = $descRow['description'] ?? '';
        if (!empty($descRow['image'])) {
            $categoryImage = htmlspecialchars($descRow['image']);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare('SELECT parent_id FROM `jaquar-categories` WHERE id = ?');
    $stmt->bind_param('i', $categoryFilter);
    $stmt->execute();
    $result = $stmt->get_result();
    $isMainCategory = $result->num_rows > 0 && $result->fetch_assoc()['parent_id'] === null;
    $stmt->close();

    if ($isMainCategory) {
        $stmt = $conn->prepare('SELECT id, name, image FROM `jaquar-categories` WHERE parent_id = ? ORDER BY name ASC');
        $stmt->bind_param('i', $categoryFilter);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $subCategories[] = $row;
        }
        $stmt->close();
    }
}

$products = [];
$totalPages = 1;
if ($categoryFilter != 0) {
    $productsPerPage = 16;
    $page = 1;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = (int) $_GET['page'];
    }
    if ($page < 1) {
        $page = 1;
    }
    $offset = ($page - 1) * $productsPerPage;


    $stmt = $conn->prepare('SELECT COUNT(*) as total FROM `jaquar_products` WHERE category_id = ?');
    $stmt->bind_param('i', $categoryFilter);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalProducts = $result->num_rows > 0 ? (int) $result->fetch_assoc()['total'] : 0;
    $stmt->close();
    $totalPages = ceil($totalProducts / $productsPerPage);


    $stmt = $conn->prepare(
        'SELECT p.*, c.name AS category_name, parent.name AS main_category_name
         FROM `jaquar_products` p
         LEFT JOIN `jaquar-categories` c ON p.category_id = c.id
         LEFT JOIN `jaquar-categories` parent ON c.parent_id = parent.id
         WHERE p.category_id = ?
         ORDER BY p.created_at DESC LIMIT ? OFFSET ?'
    );
    $stmt->bind_param('iii', $categoryFilter, $productsPerPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Water Heater</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        @media (min-width: 1536px) {
            .container {
                max-width: 1536px;
            }
            .product-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
            .product-item img {
                height: 20rem;
            }
            .product-item h3 {
                font-size: 1.25rem;
            }
            .category-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
            .category-item img {
                height: 16rem;
            }
            .pagination a {
                padding: 0.75rem 1.25rem;
            }
        }
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .product-item, .category-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .product-item.animate, .category-item.animate {
            opacity: 1;
            transform: translateY(0);
        }
        .category-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .category-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <section class="w-full bg-center bg-cover relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
        style="background-image: url('<?php echo htmlspecialchars($categoryImage); ?>');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-3 sm:mb-4 leading-tight">
                <?php
                if (!empty($categoryName)) {
                    echo htmlspecialchars($categoryName);
                } else {
                    echo 'Water Heater';
                }
                ?>
            </h1>
            <nav class="text-xs sm:text-sm md:text-base 2xl:text-lg space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <?php
                if (!empty($categoryName)) {
                    echo '<span class="text-white/60">/</span>';
                    echo '<span class="text-white">' . htmlspecialchars($categoryName) . '</span>';
                } else {
                    echo '<span class="text-white">/ Water Heater</span>';
                }
                ?>
            </nav>
        </div>
    </section>

    <section class="py-10 sm:py-16 2xl:py-20 bg-white">
        <div class="container max-w-7xl 2xl:max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
            <div class="mb-8 sm:mb-12 2xl:mb-16 text-left mx-auto align-items-justify">
                <h2 class="text-2xl sm:text-3xl 2xl:text-4xl font-bold text-gray-900 mb-4">
                    <?php
                    if (!empty($categoryName)) {
                        echo htmlspecialchars($categoryName);
                    } elseif ($categoryFilter != 0) {
                        echo 'Our Collection';
                    } else {
                        echo 'Explore Water Heater';
                    }
                    ?>
                </h2>
                <?php if (!empty($categoryDescription)): ?>
                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed">
                        <?= nl2br(str_replace(["\\r\\n", "\\n", "\\r"], "\n", htmlspecialchars_decode($categoryDescription))) ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($categoryFilter == 0): ?>
                <div class="category-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6 2xl:gap-8">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <?php
                            $img = !empty($cat['image']) ? htmlspecialchars($cat['image']) : './assets/img/placeholder.png';
                            ?>
                            <div class="category-item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                                <div class="relative overflow-hidden group">
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                                        class="w-full h-48 sm:h-56 md:h-64 2xl:h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                <div class="p-5 2xl:p-6">
                                    <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </h3>
                                    <a href="?category=<?= $cat['id'] ?>"
                                        class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Products
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-search text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl 2xl:text-2xl font-bold text-gray-900 mb-2">No Categories Found</h3>
                                <p class="text-gray-500 mb-6 text-base 2xl:text-lg">No categories are available.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (!empty($subCategories)): ?>
                <div class="category-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6 2xl:gap-8">
                    <?php foreach ($subCategories as $subCat): ?>
                        <?php
                        $img = !empty($subCat['image']) ? htmlspecialchars($subCat['image']) : './assets/img/placeholder.png';
                        ?>
                        <div class="category-item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                            <div class="relative overflow-hidden group">
                                <img src="<?= $img ?>" alt="<?= htmlspecialchars($subCat['name']) ?>"
                                    class="w-full h-48 sm:h-56 md:h-64 2xl:h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5 2xl:p-6">
                                <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2">
                                    <?= htmlspecialchars($subCat['name']) ?>
                                </h3>
                                <a href="?category=<?= $subCat['id'] ?>"
                                    class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Products
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div id="product-grid" class="product-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 2xl:gap-8">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?php
                            $pid = (int) $product['id'];
                            $catLabel = !empty($product['category_name']) ? $product['category_name'] : ($product['main_category_name'] ?? 'Uncategorized');
                            $catSlug = slugify($catLabel);
                            $img = !empty($product['image']) ? htmlspecialchars($product['image']) : './assets/img/bg-about.jpg';
                            ?>
                            <div class="product-item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform"
                                data-category="<?= htmlspecialchars($catSlug) ?>">
                                <div class="relative overflow-hidden group">
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['item_code']) ?>"
                                        class="w-full h-48 sm:h-56 md:h-64 2xl:h-80 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-yellow-400 text-black text-xs 2xl:text-sm font-semibold px-2 py-1 rounded-full shadow-md">
                                            <?= htmlspecialchars($product['category_name']) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5 2xl:p-6">
                                    <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                        <?= htmlspecialchars($product['item_code']) ?>
                                    </h3>
                                    <div class="flex items-center text-sm 2xl:text-base text-gray-500 mb-3">
                                        <i class="fas fa-layer-group mr-2"></i>
                                        <span><?= htmlspecialchars($product['category_name']) ?></span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <a href="product-details.php?id=<?= $product['id'] ?>"
                                            class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-eye mr-2"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-search text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl 2xl:text-2xl font-bold text-gray-900 mb-2">No Products Found</h3>
                                <p class="text-gray-500 mb-6 text-base 2xl:text-lg">We couldn't find any products in this category.</p>
                                <a href="?category=0"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Browse All Categories
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($totalPages > 1): ?>
                    <div class="mt-8 2xl:mt-12 flex justify-center space-x-2 pagination">
                        <?php if ($page > 1): ?>
                            <a href="?category=<?= $categoryFilter ?>&page=<?= $page - 1 ?>"
                                class="px-4 py-2 2xl:px-5 2xl:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                « Prev
                            </a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?category=<?= $categoryFilter ?>&page=<?= $i ?>"
                                class="px-4 py-2 2xl:px-5 2xl:py-3 rounded-lg <?= ($i == $page) ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <a href="?category=<?= $categoryFilter ?>&page=<?= $page + 1 ?>"
                                class="px-4 py-2 2xl:px-5 2xl:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                Next »
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.product-item, .category-item');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '50px 0px'
            };
            const itemObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animate');
                        }, index * 100);
                        itemObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            items.forEach(item => {
                itemObserver.observe(item);
            });

            const images = document.querySelectorAll('.product-item img, .category-item img');
            images.forEach(img => {
                if (!img.complete) {
                    img.classList.add('loading-skeleton');
                    img.addEventListener('load', function() {
                        this.classList.remove('loading-skeleton');
                    });
                }
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>