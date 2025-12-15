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

// Define the two ranges
$ranges = [
    [
        'id' => 1,
        'name' => 'Standard Range',
        'link' => 'tiles-standard.php',
        'image' => './uploads/categories/standard-tiles.jpg',
        'description' => 'Explore our comprehensive collection of standard tiles for everyday applications.'
    ],
    [
        'id' => 2,
        'name' => 'Project Range',
        'link' => 'tiles-project.php',
        'image' => './uploads/categories/project-range.jpg',
        'description' => 'Discover our premium project-specific tiles for specialized requirements.'
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Tiles</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" type="image/png" href="./assets/img/exel_lo.png">
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
        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-4">Tiles</h1>
        <nav class="text-xs sm:text-sm md:text-base 2xl:text-lg space-x-2">
            <a href="index.php" class="hover:underline text-white/80">Home</a>
            <span class="text-white/60">/</span>
            <span class="text-white">Tiles</span>
        </nav>
    </div>
</section>

<!-- MAIN -->
<section class="py-10 sm:py-16 2xl:py-20 bg-gray-50">
    <div class="container max-w-7xl 2xl:max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="flex flex-col lg:flex-row gap-8 2xl:gap-12">
            <!-- MAIN CONTENT -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 2xl:grid-cols-2 gap-6 2xl:gap-8">
                    <?php foreach ($ranges as $range): 
                        $img = isset($range['image']) && file_exists($range['image']) 
                            ? htmlspecialchars($range['image']) 
                            : './assets/img/placeholder.png';
                    ?>
                    <div class="item bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                        <div class="relative overflow-hidden group">
                            <img src="<?= $img ?>" alt="<?= htmlspecialchars($range['name']) ?>" class="w-full h-48 sm:h-56 md:h-64 2xl:h-72 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-5 2xl:p-6">
                            <h3 class="text-base sm:text-lg 2xl:text-xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($range['name']) ?></h3>
                            <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($range['description']) ?></p>
                            <a href="<?= $range['link'] ?>" class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-3 rounded-lg text-sm 2xl:text-base hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:scale-105">
                                <i class="fas fa-arrow-right mr-2"></i> Explore <?= htmlspecialchars($range['name']) ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
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