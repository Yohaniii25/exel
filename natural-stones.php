<?php
require_once __DIR__ . '/admin/includes/db.php';

if (!isset($conn)) {
    if (class_exists('Database')) {
        $db = new Database();
        $conn = $db->getConnection();
    } elseif (isset($mysqli) && $mysqli instanceof mysqli) {
        $conn = $mysqli;
    } else {
        die('Database connection not found.');
    }
}

function slugify($text) {
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower($text));
    return trim($text, '-');
}

/* ---------------- GET PARAMETERS ---------------- */
$selectedCategory = (int)($_GET['category'] ?? 0);
$applyFilters = isset($_GET['apply_filters']);
$activeFilters = [];

/* ---------------- MODE 1: FILTERED CATEGORIES (ONLY IF APPLY) ---------------- */
$filteredCategories = [];

// Only apply filters if "Apply Filters" is clicked
if (!$selectedCategory && $applyFilters) {
    foreach ($_GET as $key => $value) {
        if (in_array($key, ['apply_filters'])) continue;
        $activeFilters[$key] = is_array($value) ? array_map('trim', $value) : [trim($value)];
    }

    $filterWhere = '';
    $bindParams = [];
    $bindTypes = '';

    if ($activeFilters) {
        $clauses = [];
        foreach ($activeFilters as $type => $values) {
            $placeholders = array_fill(0, count($values), '?');
            $clauses[] = "EXISTS (
                SELECT 1 FROM category_filters cf
                JOIN filter_options fo ON cf.filter_id = fo.filter_id
                JOIN filters f ON fo.filter_id = f.id
                WHERE cf.category_id = c.id
                  AND f.filter_type = ?
                  AND fo.value IN (" . implode(',', $placeholders) . ")
            )";
            array_unshift($values, $type);
            $bindParams = array_merge($bindParams, $values);
            $bindTypes .= str_repeat('s', count($values));
        }
        $filterWhere = ' AND ' . implode(' AND ', $clauses);
    }

    // Load filtered categories
    $sql = "SELECT c.id, c.name, c.image, c.description FROM categories c WHERE c.parent_id = 1 $filterWhere ORDER BY c.name";
    $stmt = $conn->prepare($sql);
    if (!empty($bindParams)) {
        $stmt->bind_param($bindTypes, ...$bindParams);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $filteredCategories[] = $row;
    }
    $stmt->close();
} else {
    // DEFAULT: Show ALL Natural Stone categories
    $stmt = $conn->prepare("SELECT id, name, image, description FROM categories WHERE parent_id = 1 ORDER BY name");
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $filteredCategories[] = $row;
    }
    $stmt->close();
}

/* ---------------- MODE 2: SINGLE CATEGORY (WITH PRODUCTS) ---------------- */
$categoryData = null;
$products = [];
$totalPages = 1;

if ($selectedCategory >= 2) {
    $stmt = $conn->prepare('SELECT name, image, description FROM categories WHERE id = ?');
    $stmt->bind_param('i', $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryData = $result->fetch_assoc();
    $stmt->close();

    if ($categoryData) {
        $perPage = 16;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $perPage;

        $countSql = "SELECT COUNT(*) FROM products WHERE category_id = ? OR subcategory_id = ?";
        $stmt = $conn->prepare($countSql);
        $stmt->bind_param('ii', $selectedCategory, $selectedCategory);
        $stmt->execute();
        $totalProducts = $stmt->get_result()->fetch_row()[0];
        $totalPages = ceil($totalProducts / $perPage);
        $stmt->close();

        $sql = "SELECT * FROM products WHERE category_id = ? OR subcategory_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiii', $selectedCategory, $selectedCategory, $perPage, $offset);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

/* ---------------- LOAD FILTERS (ONLY FOR MAIN PAGE) ---------------- */
$availableFilters = [];
if (!$selectedCategory) {
    $stmt = $conn->prepare("
        SELECT DISTINCT f.filter_type, fo.value
        FROM category_filters cf
        JOIN filters f ON cf.filter_id = f.id
        JOIN filter_options fo ON fo.filter_id = f.id
        WHERE cf.category_id BETWEEN 2 AND 13
        ORDER BY f.name, fo.value
    ");
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $availableFilters[$row['filter_type']][$row['value']] = true;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - <?= $selectedCategory ? htmlspecialchars($categoryData['name'] ?? 'Category') : 'Natural Stones' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        @media (min-width:1536px){.container{max-width:1536px}}
        .item{opacity:0;transform:translateY(20px);transition:opacity .5s,transform .5s}
        .item.animate{opacity:1;transform:none}
        .item:hover{transform:scale(1.05);box-shadow:0 4px 20px rgba(0,0,0,.1)}
    </style>
</head>
<body>
<?php require __DIR__ . '/includes/header_all.php'; ?>

<!-- HERO -->
<section class="w-full bg-center relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
         style="background-image:url('./assets/img/NS-banner.jpg');">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto">
        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-4">
            <?= $selectedCategory ? htmlspecialchars($categoryData['name'] ?? 'Category') : 'Natural Stones' ?>
        </h1>
        <nav class="text-xs sm:text-sm md:text-base 2xl:text-lg space-x-2">
            <a href="index.php" class="hover:underline text-white/80">Home</a>
            <span class="text-white/60">/</span>
            <a href="natural-stones.php" class="hover:underline text-white/80">Natural Stones</a>
            <?php if ($selectedCategory): ?>
            <span class="text-white/60">/</span>
            <span class="text-white"><?= htmlspecialchars($categoryData['name'] ?? '') ?></span>
            <?php endif; ?>
        </nav>
    </div>
</section>

<!-- MAIN -->
<section class="py-10 sm:py-16 2xl:py-20 bg-gray-50">
    <div class="container max-w-7xl 2xl:max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="flex flex-col lg:flex-row gap-8 2xl:gap-12">

            <!-- FILTER SIDEBAR (ONLY ON MAIN PAGE) -->
            <?php if (!$selectedCategory): ?>
            <aside class="lg:w-80 2xl:w-96 bg-white rounded-xl shadow-lg p-6 space-y-6 sticky top-24 h-fit">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl 2xl:text-2xl font-bold text-gray-900">Filter Categories</h3>
                    <a href="natural-stones.php" class="text-sm text-yellow-600 hover:text-yellow-700 underline">Clear All</a>
                </div>

                <form method="GET" class="space-y-6">
                    <?php
                    $labels = ['sizes'=>'Sizes','finishes'=>'Finishes','applications'=>'Applications','aesthetic'=>'Aesthetic Effect'];
                    foreach ($availableFilters as $type => $options):
                        $title = $labels[$type] ?? ucwords(str_replace('_',' ',$type));
                    ?>
                    <div class="filter-group">
                        <h4 class="font-semibold text-gray-800 mb-3 text-lg"><?= $title ?></h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                            <?php foreach (array_keys($options) as $val):
                                $checked = in_array($val, ($activeFilters[$type] ?? [])) ? 'checked' : '';
                                $id = "filter-{$type}-" . slugify($val);
                            ?>
                            <label for="<?= $id ?>" class="flex items-center cursor-pointer text-gray-700 hover:text-gray-900">
                                <input type="checkbox" id="<?= $id ?>" name="<?= $type ?>[]" value="<?= htmlspecialchars($val) ?>" <?= $checked ?> class="w-4 h-4 text-yellow-500 rounded focus:ring-yellow-400 mr-3">
                                <span class="text-sm 2xl:text-base"><?= htmlspecialchars($val) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <button type="submit" name="apply_filters" value="1" class="w-full bg-yellow-500 text-black font-bold py-3 rounded-lg hover:bg-yellow-600 transition">
                        Apply Filters
                    </button>
                </form>
            </aside>
            <?php endif; ?>

            <!-- MAIN CONTENT -->
            <div class="flex-1">
                <?php if (!$selectedCategory): ?>
                    <!-- ALL OR FILTERED CATEGORIES -->
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <?= $applyFilters ? 'Filtered Categories' : 'All Natural Stone Categories' ?>
                    </h2>

                    <?php if ($filteredCategories): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6 2xl:gap-8">
                        <?php foreach ($filteredCategories as $cat): 
                            $img = $cat['image'] ? htmlspecialchars($cat['image']) : './assets/img/placeholder.png';
                        ?>
                        <div class="item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                            <div class="relative overflow-hidden group">
                                <img src="<?= $img ?>" alt="<?= htmlspecialchars($cat['name']) ?>" class="w-full h-48 sm:h-56 md:h-64 2xl:h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5 2xl:p-6">
                                <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($cat['name']) ?></h3>
                                <a href="?category=<?= $cat['id'] ?>" class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                    <i class="fas fa-eye mr-2"></i> View Products
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-16">
                        <p class="text-xl text-gray-600">No categories found.</p>
                    </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- SINGLE CATEGORY VIEW -->
                    <?php if ($categoryData): ?>
                    <div class="mb-10">
                        <div class="flex flex-col md:flex-row gap-8 mb-8">
                            <div class="md:w-1/3">
                                <img src="<?= htmlspecialchars($categoryData['image'] ?: './assets/img/placeholder.png') ?>" alt="<?= htmlspecialchars($categoryData['name']) ?>" class="w-full h-64 md:h-80 object-cover rounded-xl shadow-lg">
                            </div>
                            <div class="md:w-2/3">
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($categoryData['name']) ?></h2>
                                <div class="prose prose-lg text-gray-700 leading-relaxed">
                                    <?= nl2br(htmlspecialchars($categoryData['description'] ?: 'No description available.')) ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Products</h3>
                            <a href="natural-stones.php" class="text-yellow-600 hover:text-yellow-700 underline text-sm">
                                Back to Categories
                            </a>
                        </div>

                        <?php if ($products): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 2xl:gap-8">
                            <?php foreach ($products as $p): 
                                $img = $p['image'] ? htmlspecialchars($p['image']) : './assets/img/bg-about.jpg';
                            ?>
                            <div class="item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                                <div class="relative overflow-hidden group">
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-48 sm:h-56 md:h-64 2xl:h-80 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                <div class="p-5 2xl:p-6">
                                    <h4 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-2 line-clamp-2"><?= htmlspecialchars($p['name']) ?></h4>
                                    <a href="product-details.php?id=<?= $p['id'] ?>" class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-eye mr-2"></i> View Details
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- PAGINATION -->
                        <?php if ($totalPages > 1): 
                            $base = http_build_query(array_merge($_GET, ['page'=>null]));
                            $base = preg_replace('/&page=\d+/', '', $base);
                        ?>
                        <div class="mt-8 flex justify-center space-x-2">
                            <?php if ($page>1): ?><a href="?<?= $base ?>&page=<?= $page-1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Prev</a><?php endif; ?>
                            <?php for($i=1;$i<=$totalPages;$i++): ?>
                                <a href="?<?= $base ?>&page=<?= $i ?>" class="px-4 py-2 rounded-lg <?= ($i==$page)?'bg-yellow-400 text-black font-bold':'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            <?php if ($page<$totalPages): ?><a href="?<?= $base ?>&page=<?= $page+1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Next</a><?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php else: ?>
                        <div class="text-center py-16">
                            <p class="text-xl text-gray-600">No products found in this category.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-16">
                        <p class="text-xl text-gray-600">Category not found.</p>
                        <a href="natural-stones.php" class="mt-4 inline-block text-yellow-600 hover:text-yellow-700 underline">Back to Categories</a>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((e,i) => {
            if (e.isIntersecting) {
                setTimeout(()=>e.target.classList.add('animate'), i*80);
                observer.unobserve(e.target);
            }
        });
    }, {threshold:0.1});
    document.querySelectorAll('.item').forEach(el=>observer.observe(el));
});
</script>
</body>
</html>