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

$subCategories = [];
if ($categoryFilter == 0) {
    $subCategoriesSql = 'SELECT id, name, image 
                     FROM categories 
                     WHERE parent_id=23 
                     ORDER BY name ASC';
    $subCategoriesRes = $conn->query($subCategoriesSql);
    if ($subCategoriesRes) {
        while ($row = $subCategoriesRes->fetch_assoc()) {
            $subCategories[] = $row;
        }
    }
}

$categoryName = '';
$categoryImage = './assets/img/engineer.jpg';

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
    if ($page < 1)
        $page = 1;
    $offset = ($page - 1) * $productsPerPage;

    $countSql = "SELECT COUNT(*) as total 
                 FROM products p
                 WHERE p.category_id = {$categoryFilter} OR p.subcategory_id = {$categoryFilter}";

    $countRes = $conn->query($countSql);
    $totalProducts = 0;
    if ($countRes) {
        $totalProducts = (int) $countRes->fetch_assoc()['total'];
    }
    $totalPages = ceil($totalProducts / $productsPerPage);

    $sql = "SELECT p.*, 
                   c.name AS category_name, 
                   sc.name AS subcategory_name,
                   parent.name AS main_category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN categories sc ON p.subcategory_id = sc.id
            LEFT JOIN categories parent ON c.parent_id = parent.id
            WHERE p.category_id = {$categoryFilter} OR p.subcategory_id = {$categoryFilter}";

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
    <title>Exel Holdings - Engineering Services</title>
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
    </style>
</head>

<body>
    <?php require (__DIR__ . '/includes/header_all.php'); ?>

    <section
        class="w-full bg-center relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
        style="background-image: url('<?php if (!empty($categoryImage)) { echo $categoryImage; } else { echo './assets/img/NS-banner.jpg'; } ?>');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-3 sm:mb-4 leading-tight">
                <?php
                if (!empty($categoryName)) {
                    echo htmlspecialchars($categoryName);
                } else {
                    echo 'Engineering Services';
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
                    echo '<span class="text-white">/ Engineering Services</span>';
                }
                ?>
            </nav>
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
    });
    </script>
</body>

</html>