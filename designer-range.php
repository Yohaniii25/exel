<?php
require_once (__DIR__ . '/admin/includes/db.php');

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
    function slugify($text)
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower($text));
        $text = trim($text, '-');
        return $text;
    }
}

$categoryFilter = 0;
if (isset($_GET['category'])) {
    $categoryFilter = (int) $_GET['category'];
}

if ($categoryFilter == 0) {
    $categoryFilter = 30;
}

$selectedFilters = [];
if (isset($_GET['filters']) && is_array($_GET['filters'])) {
    $selectedFilters = array_map('intval', $_GET['filters']);
}

// Fetch filters that are relevant only for this category/subcategory (Designer Range = 30)
$filters = [];
$filterSql = "SELECT DISTINCT f.id, f.name, fo.id AS option_id, fo.value
              FROM filters f
              LEFT JOIN filter_options fo ON f.id = fo.filter_id
              INNER JOIN product_filters pf ON fo.id = pf.filter_option_id
              INNER JOIN products p ON pf.product_id = p.id
              WHERE (p.category_id = ? OR p.subcategory_id = ?)
              AND fo.value IS NOT NULL
              ORDER BY f.name, fo.value";
if ($stmt = $conn->prepare($filterSql)) {
    $stmt->bind_param('ii', $categoryFilter, $categoryFilter);
    $stmt->execute();
    $filterRes = $stmt->get_result();
    if ($filterRes) {
        while ($row = $filterRes->fetch_assoc()) {
            $filters[$row['name']]['id'] = $row['id'];
            $filters[$row['name']]['options'][] = [
                'id' => $row['option_id'],
                'value' => $row['value']
            ];
        }
    }
    $stmt->close();
}

$subCategories = [];
$categoryName = '';
$categoryImage = './assets/img/engineer.jpg';
$categoryDescription = '';

if ($categoryFilter != 0) {
    $descSql = "SELECT name, image 
            FROM categories 
            WHERE id = {$categoryFilter} 
            LIMIT 1";
    $descRes = $conn->query($descSql);
    if ($descRes && $descRes->num_rows > 0) {
        $descRow = $descRes->fetch_assoc();
        $categoryName = $descRow['name'];

        if (!empty($descRow['image'])) {
            $categoryImage = htmlspecialchars($descRow['image']);
        }
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
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $productsPerPage;

    // Build filter conditions if any filters selected
    $filterConditions = [];
    if (!empty($selectedFilters)) {
        $in = implode(',', array_map('intval', $selectedFilters));
        $filterConditions[] = "p.id IN (
            SELECT pf.product_id
            FROM product_filters pf
            WHERE pf.filter_option_id IN ($in)
            GROUP BY pf.product_id
            HAVING COUNT(DISTINCT pf.filter_option_id) = " . count($selectedFilters) . "
        )";
    }

    // Note: use parentheses to group the category OR subcategory before appending ANDs
    $countSql = "SELECT COUNT(*) as total 
                 FROM products p
                 WHERE (p.category_id = {$categoryFilter} OR p.subcategory_id = {$categoryFilter})";
    if (!empty($filterConditions)) {
        $countSql .= " AND " . implode(' AND ', $filterConditions);
    }
    $countRes = $conn->query($countSql);
    $totalProducts = 0;
    if ($countRes) {
        $totalProducts = (int) $countRes->fetch_assoc()['total'];
    }
    $totalPages = max(1, ceil($totalProducts / $productsPerPage));

    $sql = "SELECT p.*, 
                   c.name AS category_name, 
                   sc.name AS subcategory_name,
                   parent.name AS main_category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN categories sc ON p.subcategory_id = sc.id
            LEFT JOIN categories parent ON c.parent_id = parent.id
            WHERE (p.category_id = {$categoryFilter} OR p.subcategory_id = {$categoryFilter})";
    if (!empty($filterConditions)) {
        $sql .= " AND " . implode(' AND ', $filterConditions);
    }
    $sql .= " ORDER BY p.created_at DESC LIMIT $productsPerPage OFFSET $offset";

    $res = $conn->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $products[$row['id']] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Tiles - Standard Range</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap"
        rel="stylesheet">
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
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    .product-item,
    .category-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .product-item.animate,
    .category-item.animate {
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

    /* Add light grey shade for full filter board and shadow cards for each filter group */
    .filter-sidebar {
        background: #f3f4f6;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e6e9ee;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    }

    .filter-sidebar .sidebar-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        gap: 12px;
    }

    .filter-sidebar .sidebar-title h3 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }

    .filter-card {
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        border: 1px solid #eceff3;
        box-shadow: 0 6px 14px rgba(2, 6, 23, 0.04);
    }

    .filter-card h4 {
        margin: 0 0 8px 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #0b1220;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 220px;
        overflow: auto;
        padding-right: 6px;
    }

    .filter-option-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 8px;
        border-radius: 8px;
    }

    .filter-option-row:hover {
        background: #fbfbfd;
        transform: translateX(2px);
    }

    .filter-option-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #f59e0b;
    }

    .filter-actions-row {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .btn-apply {
        flex: 1;
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
        color: #071133;
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        border: 0;
    }

    .btn-clear {
        flex: 1;
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 10px;
        border-radius: 10px;
        font-weight: 600;
    }

    .active-filters-strip {
        display: none;
        gap: 8px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .active-filters-strip.show {
        display: flex;
    }

    .filter-badge {
        background: #fff7ed;
        color: #92400e;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 600;
        border: 1px solid #fde3b7;
    }
    </style>
</head>

<body>
    <?php require (__DIR__ . '/includes/header_all.php'); ?>

    <section
        class="w-full bg-center bg-cover relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
        style="background-image: url('<?php if (!empty($categoryImage)) { echo $categoryImage; } else { echo './assets/img/NS-banner.jpg'; } ?>');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-3 sm:mb-4 leading-tight">
                <?php
                if (!empty($categoryName)) {
                    echo htmlspecialchars($categoryName);
                } else {
                    echo 'Tiles - Standard Range';
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
                    echo '<span class="text-white">/ Tiles - Standard Range</span>';
                }
                ?>
            </nav>
        </div>
    </section>



    <section class="py-10 sm:py-16 2xl:py-20 bg-white">
        <div class="container max-w-7xl 2xl:max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
            <div class="mb-8 sm:mb-12 2xl:mb-16 text-center">
                <h2 class="text-2xl sm:text-3xl 2xl:text-4xl font-bold text-gray-900">
                    <?php if ($categoryFilter != 0) { echo 'Our Collection'; } else { echo 'Explore Designer Range'; } ?>
                </h2>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 2xl:gap-8">
                <!-- Sidebar: only show for Designer Range (subcategory 30) -->
                <?php if ($categoryFilter == 30): ?>
                <aside class="w-full lg:w-1/4 xl:w-1/5 hidden lg:block">
                    <div class="filter-sidebar">
                        <div class="sidebar-title">
                            <h3>Filter Designer Range</h3>
                            <button type="button" id="desktop-clear-btn" class="btn-clear" title="Clear all filters">Clear
                            </button>
                        </div>

                        <div id="active-filters-strip-desktop" class="active-filters-strip" aria-hidden="true"></div>

                        <form id="filter-form" method="GET" action="">
                            <input type="hidden" name="category" value="<?= $categoryFilter ?>">
                            <input type="hidden" name="page" value="<?= $page ?? 1 ?>">

                            <?php foreach ($filters as $filterName => $filter): ?>
                            <div class="filter-card">
                                <h4><?= htmlspecialchars($filterName) ?></h4>
                                <div class="filter-options">
                                    <?php foreach ($filter['options'] as $option): if (empty($option['id'])) continue; ?>
                                    <label class="filter-option-row">
                                        <input type="checkbox" name="filters[]" value="<?= (int)$option['id'] ?>"
                                            <?= in_array((int)$option['id'], $selectedFilters) ? 'checked' : '' ?>
                                            class="filter-checkbox">
                                        <span class="text-sm"><?= htmlspecialchars($option['value']) ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="filter-actions-row">
                                <button type="submit" class="btn-apply">
                                    <i class="fas fa-check mr-2"></i> Apply
                                </button>
                                <button type="button" id="desktop-clear-local" class="btn-clear">
                                    <i class="fas fa-times mr-2"></i> Clear Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </aside>
                <?php endif; ?>

                <!-- Products / Content -->
                <div class="<?= ($categoryFilter == 30) ? 'w-full lg:w-3/4 xl:w-4/5' : 'w-full' ?>">
                    <?php if ($categoryFilter == 0): ?>
                    <div class="category-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6 2xl:gap-8">
                        <?php if (!empty($subCategories)): ?>
                        <?php foreach ($subCategories as $subCat): ?>
                        <?php
                        if (!empty($subCat['image'])) {
                            $img = htmlspecialchars($subCat['image']);
                        } else {
                            $img = './assets/img/placeholder.png';
                        }
                        ?>
                        <div
                            class="category-item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                            <div class="relative overflow-hidden group">
                                <img src="<?= $img ?>" alt="<?= htmlspecialchars($subCat['name']) ?>"
                                    class="w-full h-48 sm:h-56 md:h-64 2xl:h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
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
                        <?php else: ?>
                        <div class="col-span-full text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-search text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-xl 2xl:text-2xl font-bold text-gray-900 mb-2">No Subcategories Found
                                </h3>
                                <p class="text-gray-500 mb-6 text-base 2xl:text-lg">No subcategories are available for
                                    Natural
                                    Stones.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div id="product-grid"
                        class="product-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 2xl:gap-8">
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <?php
                        $pid = (int) $product['id'];

                        if (!empty($product['subcategory_name'])) {
                            $catLabel = $product['subcategory_name'];
                        } elseif (!empty($product['category_name'])) {
                            $catLabel = $product['category_name'];
                        } else {
                            $catLabel = $product['main_category_name'];
                        }

                        if (!empty($catLabel)) {
                            $catSlug = slugify($catLabel);
                        } else {
                            $catSlug = 'uncategorized';
                        }

                        if (!empty($product['image'])) {
                            $img = htmlspecialchars($product['image']);
                        } else {
                            $img = './assets/img/bg-about.jpg';
                        }
                        ?>
                        <div class="product-item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform"
                            data-category="<?= htmlspecialchars($catSlug) ?>">
                            <div class="relative overflow-hidden group">
                                <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-48 sm:h-56 md:h-64 2xl:h-80 object-cover transition-transform duration-500 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-yellow-400 text-black text-xs 2xl:text-sm font-semibold px-2 py-1 rounded-full shadow-md">
                                        <?= htmlspecialchars($product['category_name']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 2xl:p-6">
                                <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                    <?= htmlspecialchars($product['name']) ?>
                                </h3>
                                <div class="flex items-center text-sm 2xl:text-base text-gray-500 mb-3">
                                    <i class="fas fa-layer-group mr-2"></i>
                                    <span><?= htmlspecialchars($product['category_name']) ?></span>
                                    <?php if (!empty($product['subcategory_name'])): ?>
                                    <span class="mx-1">→</span>
                                    <span><?= htmlspecialchars($product['subcategory_name']) ?></span>
                                    <?php endif; ?>
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
                                <p class="text-gray-500 mb-6 text-base 2xl:text-lg">We couldn't find any products in this
                                    category.</p>
                                <a href="natural-stones.php"
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
            </div>
        </div>
    </section>

    <?php require (__DIR__ . '/includes/footer.php'); ?>

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

        // Clear filters helper - reloads page keeping category=30 and page=1
        function clearAllFiltersAndReload() {
            const keep = new URLSearchParams();
            keep.set('category', '<?= (int)$categoryFilter ?>');
            keep.set('page', '1');
            window.location.search = keep.toString();
        }
        const desktopClearBtn = document.getElementById('desktop-clear-btn');
        const desktopClearLocal = document.getElementById('desktop-clear-local');
        if (desktopClearBtn) desktopClearBtn.addEventListener('click', clearAllFiltersAndReload);
        if (desktopClearLocal) desktopClearLocal.addEventListener('click', clearAllFiltersAndReload);

        // Update active badges
        function updateActiveBadges() {
            const checked = document.querySelectorAll('.filter-checkbox:checked');
            const strip = document.getElementById('active-filters-strip-desktop');
            if (!strip) return;
            if (checked.length === 0) {
                strip.classList.remove('show');
                strip.innerHTML = '';
                return;
            }
            const badges = Array.from(checked).map(cb => {
                const label = cb.closest('.filter-option-row')?.querySelector('span')?.textContent || '';
                return `<span class="filter-badge">${label.trim()}</span>`;
            }).join('');
            strip.innerHTML = badges;
            strip.classList.add('show');
        }
        document.querySelectorAll('.filter-checkbox').forEach(cb => cb.addEventListener('change', updateActiveBadges));
        updateActiveBadges();
    });
    </script>
</body>

</html>