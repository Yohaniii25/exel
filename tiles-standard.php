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

$tilesParentId = 26; 

$filters = [];
$filterSql = "SELECT DISTINCT f.id, f.name, f.filter_type, fo.id AS option_id, fo.value
              FROM filters f
              LEFT JOIN filter_options fo ON f.id = fo.filter_id
              INNER JOIN product_filters pf ON fo.id = pf.filter_option_id
              INNER JOIN products p ON pf.product_id = p.id
              INNER JOIN categories c ON (p.category_id = c.id OR p.subcategory_id = c.id)
              WHERE (c.id = ? OR c.parent_id = ?)
              AND fo.value IS NOT NULL
              ORDER BY f.name, fo.value";
$stmt = $conn->prepare($filterSql);
$stmt->bind_param('ii', $tilesParentId, $tilesParentId);
$stmt->execute();
$filterRes = $stmt->get_result();

if ($filterRes) {
    while ($row = $filterRes->fetch_assoc()) {
        $filters[$row['name']]['id'] = $row['id'];
        $filters[$row['name']]['filter_type'] = $row['filter_type'];
        $filters[$row['name']]['options'][] = [
            'id' => $row['option_id'],
            'value' => $row['value']
        ];
    }
} else {
    error_log("Filter query failed: " . $conn->error);
}
$stmt->close();

$categoryFilter = 0;
if (isset($_GET['category'])) {
    $categoryFilter = (int) $_GET['category'];
}

if ($categoryFilter == 0) {
    $categoryFilter = 28;
}

$subCategories = [];
$categoryName = '';
$categoryImage = './assets/img/engineer.jpg';
$categoryDescription = '';

if ($categoryFilter != 0) {
    $descSql = "SELECT name, image 
                FROM categories 
                WHERE id = ? 
                LIMIT 1";
    $stmt = $conn->prepare($descSql);
    $stmt->bind_param('i', $categoryFilter);
    $stmt->execute();
    $descRes = $stmt->get_result();
    if ($descRes && $descRes->num_rows > 0) {
        $descRow = $descRes->fetch_assoc();
        $categoryName = $descRow['name'];
        if (!empty($descRow['image'])) {
            $categoryImage = htmlspecialchars($descRow['image']);
        }
    }
    $stmt->close();
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

    // Handle filter conditions
    $filterConditions = [];
    $selectedFilters = [];
    if (isset($_GET['filters']) && is_array($_GET['filters'])) {
        $selectedFilters = array_map('intval', $_GET['filters']);
        if (!empty($selectedFilters)) {
            $filterConditions[] = "p.id IN (
                SELECT pf.product_id
                FROM product_filters pf
                WHERE pf.filter_option_id IN (" . implode(',', $selectedFilters) . ")
                GROUP BY pf.product_id
                HAVING COUNT(DISTINCT pf.filter_option_id) = " . count($selectedFilters) . "
            )";
        }
    }

    $countSql = "SELECT COUNT(*) as total 
                 FROM products p
                 WHERE p.category_id = ? OR p.subcategory_id = ?";
    if (!empty($filterConditions)) {
        $countSql .= " AND " . implode(' AND ', $filterConditions);
    }
    $stmt = $conn->prepare($countSql);
    $stmt->bind_param('ii', $categoryFilter, $categoryFilter);
    $stmt->execute();
    $countRes = $stmt->get_result();
    $totalProducts = 0;
    if ($countRes) {
        $totalProducts = (int) $countRes->fetch_assoc()['total'];
    }
    $totalPages = ceil($totalProducts / $productsPerPage);
    $stmt->close();

    $sql = "SELECT p.*, 
                   c.name AS category_name, 
                   sc.name AS subcategory_name,
                   parent.name AS main_category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN categories sc ON p.subcategory_id = sc.id
            LEFT JOIN categories parent ON c.parent_id = parent.id
            WHERE p.category_id = ? OR p.subcategory_id = ?";
    if (!empty($filterConditions)) {
        $sql .= " AND " . implode(' AND ', $filterConditions);
    }
    $sql .= " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiii', $categoryFilter, $categoryFilter, $productsPerPage, $offset);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $products[$row['id']] = $row;
        }
    } else {
        error_log("Product query failed: " . $conn->error);
    }
    $stmt->close();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    /* Sidebar Scrollbar */
    aside .scrollable-filters::-webkit-scrollbar {
        width: 6px;
    }
    aside .scrollable-filters::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 3px;
    }
    aside .scrollable-filters::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }

    /* Mobile Modal Scrollbar */
    #mobile-filter-modal .scrollable-modal::-webkit-scrollbar {
        width: 6px;
    }
    #mobile-filter-modal .scrollable-modal::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 3px;
    }
    #mobile-filter-modal .scrollable-modal::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }

    /* Mobile Modal */
    #mobile-filter-modal {
        transition: opacity 0.3s ease;
    }
    #mobile-filter-modal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    /* FILTER BOARD - updated: light grey shade and card-style filter boxes */
    .filter-sidebar {
        background: #f3f4f6; /* light grey shade for whole filter board */
        border-radius: 14px;
        padding: 18px;
        border: 1px solid #e6e9ee;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }

    /* header/title inside the sidebar */
    .filter-sidebar .sidebar-title {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        margin-bottom: 14px;
    }
    .filter-sidebar .sidebar-title h3 {
        margin:0;
        font-weight:700;
        color:#0f172a;
        font-size:1.05rem;
    }

    /* each filter group becomes a card */
    .filter-card {
        background: #fff;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 12px;
        border: 1px solid #e6e6ee;
        box-shadow: 0 6px 18px rgba(2,6,23,0.04);
        transition: box-shadow .18s ease, transform .12s ease;
    }
    .filter-card:hover {
        box-shadow: 0 10px 30px rgba(2,6,23,0.06);
        transform: translateY(-2px);
    }
    .filter-card h4 {
        margin:0 0 10px 0;
        font-size:0.95rem;
        font-weight:700;
        color:#0b1220;
    }
    .filter-options {
        display:flex;
        flex-direction:column;
        gap:8px;
        max-height:220px;
        overflow:auto;
        padding-right:4px;
    }
    .filter-option-row {
        display:flex;
        align-items:center;
        gap:10px;
        padding:6px 8px;
        border-radius:8px;
        transition: background .12s ease, transform .12s ease;
    }
    .filter-option-row:hover {
        background:#fbfbfd;
        transform: translateX(3px);
    }
    .filter-option-row input[type="checkbox"] {
        width:16px;
        height:16px;
        accent-color:#f59e0b;
    }
    .filter-actions-row {
        display:flex;
        gap:10px;
        margin-top:10px;
    }
    .btn-apply {
        flex:1;
        background: linear-gradient(90deg,#f59e0b,#fbbf24);
        color:#071133;
        padding:10px 12px;
        border-radius:10px;
        font-weight:700;
        border:0;
        box-shadow:0 6px 18px rgba(245,158,11,0.16);
        cursor:pointer;
    }
    .btn-clear {
        flex:1;
        background:#ffffff;
        border:1px solid #e5e7eb;
        color:#374151;
        padding:10px 12px;
        border-radius:10px;
        font-weight:600;
        cursor:pointer;
        box-shadow:0 4px 12px rgba(2,6,23,0.04);
    }

    /* small helper - active badges area */
    .active-filters-strip {
        display:none;
        margin-bottom:12px;
        gap:8px;
        align-items:center;
        flex-wrap:wrap;
    }
    .active-filters-strip.show {
        display:flex;
    }
    .filter-badge {
        background:#fff7ed;
        color:#92400e;
        padding:6px 10px;
        border-radius:999px;
        font-weight:600;
        border:1px solid #fde3b7;
        font-size:0.85rem;
    }

    /* scrollbars themed */
    .filter-options::-webkit-scrollbar { width:6px; }
    .filter-options::-webkit-scrollbar-thumb { background: linear-gradient(180deg,#fbbf24,#f59e0b); border-radius:6px; }
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
                    <?php
                    if ($categoryFilter != 0) {
                        echo 'Our Collection';
                    } else {
                        echo 'Explore Tiles - Standard Range';
                    }
                    ?>
                </h2>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 2xl:gap-8">
                <!-- Sidebar -->
                <aside class="w-full lg:w-1/4 xl:w-1/5 hidden lg:block">
                    <div class="filter-sidebar">
                        <div class="sidebar-title">
                            <h3>Filter Products</h3>
                            <!-- Desktop clear button (actioned with JS) -->
                            <button type="button" id="desktop-clear-btn" class="btn-clear" title="Clear all filters">Clear</button>
                        </div>

                        <div id="active-filters-strip-desktop" class="active-filters-strip" aria-hidden="true"></div>

                        <form id="filter-form" method="GET" action="">
                            <input type="hidden" name="category" value="<?= $categoryFilter ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">

                            <?php foreach ($filters as $filterName => $filter): ?>
                            <div class="filter-card">
                                <h4><?= htmlspecialchars($filterName) ?></h4>
                                <div class="filter-options">
                                    <?php foreach ($filter['options'] as $option): ?>
                                    <label class="filter-option-row">
                                        <input type="checkbox" name="filters[]" value="<?= $option['id'] ?>"
                                            <?= in_array($option['id'], $selectedFilters) ? 'checked' : '' ?>
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

                <!-- Mobile Filter Button -->
                <div class="lg:hidden mb-6">
                    <button id="mobile-filter-toggle"
                        class="w-full bg-yellow-400 text-black font-semibold py-3 px-4 rounded-lg hover:bg-yellow-500 transition-colors flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter Products
                    </button>
                </div>

                <!-- Mobile Filter Modal (Hidden by Default) -->
                <div id="mobile-filter-modal"
                    class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center lg:hidden">
                    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 scrollable-modal max-h-[80vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Filter Products</h3>
                            <button id="mobile-filter-close" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="mobile-filter-form" method="GET" action="">
                            <input type="hidden" name="category" value="<?= $categoryFilter ?>">
                            <input type="hidden" name="page" value="<?= $page ?>">
                            <?php foreach ($filters as $filterName => $filter): ?>
                            <div class="mb-6">
                                <h4 class="text-base font-semibold text-gray-800 mb-3"><?= htmlspecialchars($filterName) ?></h4>
                                <div class="space-y-2">
                                    <?php foreach ($filter['options'] as $option): ?>
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="filters[]" value="<?= $option['id'] ?>"
                                            <?= in_array($option['id'], $selectedFilters) ? 'checked' : '' ?>
                                            class="form-checkbox h-4 w-4 text-yellow-400">
                                        <span class="text-sm text-gray-700"><?= htmlspecialchars($option['value']) ?></span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <button type="submit"
                                class="w-full bg-yellow-400 text-black font-semibold py-2 px-4 rounded-lg hover:bg-yellow-500 transition-colors">
                                Apply Filters
                            </button>
                            <?php if (!empty($selectedFilters)): ?>
                            <a href="?category=<?= $categoryFilter ?>&page=1"
                                class="block text-center mt-4 text-sm text-gray-500 hover:underline">Clear Filters</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="w-full lg:w-3/4 xl:w-4/5">
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
                                <p class="text-gray-500 mb-6 text-base 2xl:text-lg">We couldn't find any products in this category.</p>
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
                        <a href="?category=<?= $categoryFilter ?>&page=<?= $page - 1 ?><?php if (!empty($selectedFilters)) echo '&filters[]=' . implode('&filters[]=', $selectedFilters); ?>"
                            class="px-4 py-2 2xl:px-5 2xl:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            « Prev
                        </a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?category=<?= $categoryFilter ?>&page=<?= $i ?><?php if (!empty($selectedFilters)) echo '&filters[]=' . implode('&filters[]=', $selectedFilters); ?>"
                            class="px-4 py-2 2xl:px-5 2xl:py-3 rounded-lg <?= ($i == $page) ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                            <?= $i ?>
                        </a>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                        <a href="?category=<?= $categoryFilter ?>&page=<?= $page + 1 ?><?php if (!empty($selectedFilters)) echo '&filters[]=' . implode('&filters[]=', $selectedFilters); ?>"
                            class="px-4 py-2 2xl:px-5 2xl:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Next »
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php require (__DIR__ . '/includes/footer.php'); ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        function clearAllFiltersAndReload() {
            
            const url = new URL(window.location.href);
            url.searchParams.delete('filters[]'); 
            const keep = new URLSearchParams();
            if (<?= (int)$categoryFilter ?>) keep.set('category', '<?= (int)$categoryFilter ?>');
            keep.set('page', '1');
            window.location.search = keep.toString();
        }

        // Desktop clear button (top)
        const desktopClearBtn = document.getElementById('desktop-clear-btn');
        const desktopClearLocal = document.getElementById('desktop-clear-local');
        if (desktopClearBtn) desktopClearBtn.addEventListener('click', clearAllFiltersAndReload);
        if (desktopClearLocal) desktopClearLocal.addEventListener('click', clearAllFiltersAndReload);

        // update active badges in sidebar
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

        // Mobile filter modal toggle
        const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
        const mobileFilterModal = document.getElementById('mobile-filter-modal');
        const mobileFilterClose = document.getElementById('mobile-filter-close');

        if (mobileFilterToggle && mobileFilterModal && mobileFilterClose) {
            mobileFilterToggle.addEventListener('click', () => {
                mobileFilterModal.classList.toggle('hidden');
            });
            mobileFilterClose.addEventListener('click', () => {
                mobileFilterModal.classList.add('hidden');
            });
        }

        // AJAX for desktop filter form
        document.getElementById('filter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: window.location.pathname,
                method: 'GET',
                data: formData,
                success: function(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newProductGrid = doc.getElementById('product-grid');
                    const newPagination = doc.querySelector('.pagination');
                    if (newProductGrid) {
                        document.getElementById('product-grid').innerHTML = newProductGrid.innerHTML;
                    }
                    if (newPagination) {
                        const paginationContainer = document.querySelector('.pagination');
                        if (paginationContainer) {
                            paginationContainer.outerHTML = newPagination.outerHTML;
                        }
                    } else {
                        const paginationContainer = document.querySelector('.pagination');
                        if (paginationContainer) {
                            paginationContainer.remove();
                        }
                    }
                    // Re-apply IntersectionObserver for new items
                    const newItems = document.querySelectorAll('.product-item');
                    newItems.forEach((item, index) => {
                        itemObserver.observe(item);
                    });
                    // update badges after ajax reload (server-rendered)
                    updateActiveBadges();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error applying filters. Please try again.');
                }
            });
        });

        // AJAX for mobile filter form
        document.getElementById('mobile-filter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: window.location.pathname,
                method: 'GET',
                data: formData,
                success: function(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newProductGrid = doc.getElementById('product-grid');
                    const newPagination = doc.querySelector('.pagination');
                    if (newProductGrid) {
                        document.getElementById('product-grid').innerHTML = newProductGrid.innerHTML;
                    }
                    if (newPagination) {
                        const paginationContainer = document.querySelector('.pagination');
                        if (paginationContainer) {
                            paginationContainer.outerHTML = newPagination.outerHTML;
                        }
                    } else {
                        const paginationContainer = document.querySelector('.pagination');
                        if (paginationContainer) {
                            paginationContainer.remove();
                        }
                    }
                    mobileFilterModal.classList.add('hidden');
                    // Re-apply IntersectionObserver
                    const newItems = document.querySelectorAll('.product-item');
                    newItems.forEach((item, index) => {
                        itemObserver.observe(item);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error applying filters. Please try again.');
                }
            });
        });
    });
    </script>
</body>

</html>