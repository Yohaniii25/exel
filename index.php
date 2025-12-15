<?php
require_once 'admin/includes/db.php';

$database = new Database();
$conn = $database->getConnection();


$projectQuery = "SELECT id, name, image FROM projects ORDER BY id DESC LIMIT 8";
$projectResult = $conn->query($projectQuery);


$query = "
    SELECT p.id, p.image, c.id AS category_id, c.name AS category_name
    FROM `jaquar_products` p
    LEFT JOIN `jaquar-categories` c ON p.category_id = c.id
    WHERE p.image IS NOT NULL AND p.image != ''
    GROUP BY c.id
    ORDER BY c.id DESC
";
$result = $conn->query($query);


$desiredCategories = [
    'Natural Stones',
    'Engineered Stones',
    'Tiles',
    'Mosaics',
    'Adhesive & Grout & Industrial Flooring'
];

$categories = [];


$sql1 = "
    SELECT id, name, image 
    FROM categories 
    WHERE parent_id IS NULL 
    AND name IN ('" . implode("','", $desiredCategories) . "') 
    ORDER BY FIELD(name, '" . implode("','", $desiredCategories) . "')
";
$res1 = $conn->query($sql1);
if ($res1 && $res1->num_rows > 0) {
    while ($row = $res1->fetch_assoc()) {
        $categories[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'image' => !empty($row['image']) ? $row['image'] : './assets/img/placeholder.png'
        ];
    }
}



$categoryProducts = [];

foreach ($categories as $category) {
    $products = [];


    $stmt = $conn->prepare("
        SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.category_id = ?
        ORDER BY RAND()
        LIMIT 5
    ");
    if ($stmt) {
        $stmt->bind_param('i', $category['id']);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $products[] = [
                'id' => $row['id'],
                'title' => $row['name'],
                'description' => $row['description'] ?: 'Premium product',
                'image' => $row['image'] ?: './assets/img/bg-about.jpg',
                'category_name' => $row['category_name']
            ];
        }
        $stmt->close();
    }

    $categoryProducts[$category['name']] = $products;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="icon" type="image/png" href="./assets/img/exel_lo.png">

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        .pt-9 {
            padding-top: 20rem;
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

        .product-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .product-item.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .product-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .swiper-button-next, .swiper-button-prev {
            color: white;
            width: 30px;
        }
    </style>
</head>

<body>
    <?php require(__DIR__ . '/includes/header.php'); ?>

    <section class="w-full relative">
        <div class="swiper hero-swiper h-[80vh] md:h-[100vh]">
            <div class="swiper-wrapper">
                <div class="swiper-slide relative">
                    <img src="./assets/img/home_slider.jpg" alt="Slide 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Where comfort and design beautifully come together</h1>
                        <p class="text-lg md:text-xl max-w-xl">
                            Experience the perfect balance of elegance and ease, where every piece is crafted to bring both style and comfort into your home.
                        </p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Explore More</a>
                    </div>
                </div>
                <div class="swiper-slide relative">
                    <img src="./assets/img/slider22.jpg" alt="Slide 2" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Modern Tiles Collection</h1>
                        <p class="text-lg md:text-xl mb-6">Elegance & durability in every detail</p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Shop Now</a>
                    </div>
                </div>
                <div class="swiper-slide relative">
                    <img src="./assets/img/slider33.jpg" alt="Slide 3" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Sanitaryware & Faucets</h1>
                        <p class="text-lg md:text-xl mb-6">Premium solutions for your modern bathroom</p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="swiper-button-next !text-white"></div>
            <div class="swiper-button-prev !text-white"></div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const heroSwiper = new Swiper(".hero-swiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 1000,
        });
    </script>


    <section class="bg-white text-black py-16 px-4 md:px-12 bg-cover bg-center bg-no-repeat"
        style="background-image: url('./assets/img/bg-product.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic3.jpg');" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Natural Stones</h3>
                    <p class="text-sm">Imported premium Natural Stones for luxury interiors.</p>
                </div>
            </div>
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic1.jpg');" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Engineering Stones</h3>
                    <p class="text-sm">Durable Engineering Stones for modern surfaces.</p>
                </div>
            </div>
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic2.jpg');" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Tiles & Mosaics</h3>
                    <p class="text-sm">Creative tiling options from across the globe.</p>
                </div>
            </div>
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic2.jpg');" data-aos="fade-up" data-aos-delay="400">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Mosaics</h3>
                    <p class="text-sm">Intricate designs for unique spaces.</p>
                </div>
            </div>
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic4.jpg');" data-aos="fade-up" data-aos-delay="500">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Adhesive & Grout</h3>
                    <p class="text-sm">Reliable solutions for secure installations.</p>
                </div>
            </div>
            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/wellness.jpg');" data-aos="fade-up" data-aos-delay="600">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Industrial Flooring</h3>
                    <p class="text-sm">Durable flooring for industrial applications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>


    <section class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 bg-white">
        <div class="relative aspect-square bg-cover bg-center flex items-end"
            style="background-image: url('./assets/img/rec_1.jpg');">
            <div class="text-black w-full pb-8 pt-9 px-4 text-center bg-gradient-to-t from-black/60 to-transparent mr-3px">
                <h2 class="text-3xl font-bold mb-2">Complete Bathroom Solutions</h2>
                <p class="mb-4">Transform your space into a sanctuary of style and comfort</p>
                <a href="./sanitaryware.php" class="bg-white text-black font-semibold px-6 py-2 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                    View More
                </a>
            </div>
        </div>
        <div class="relative aspect-square bg-cover bg-center flex items-end"
            style="background-image: url('./assets/img/2224.jpg');">
            <div class="text-black w-full pb-8 pt-9 px-4 text-center bg-gradient-to-t from-black/60 to-transparent ml-3px">
                <h2 class="text-3xl font-bold mb-2">Tiles, Mosaics & Natural Stones</h2>
                <p class="mb-4">Where texture, color, and craftsmanship meet timeless design</p>
                <a href="./tiles-standard.php" class="bg-white text-black font-semibold px-6 py-2 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                    View More
                </a>
            </div>
        </div>
    </section>


    <section class="bg-white text-black py-16 px-4 md:px-12 lg:px-1 xl:px-32">
        <div class="max-w-[1700px] mx-auto">

            <div class="flex flex-wrap gap-4 border-b border-gray-200 mb-6">
                <?php foreach ($categories as $index => $category): ?>
                    <?php
                    $tabId = str_replace(' ', '', $category['name']) . '-tab';
                    $activeClass = $index === 0
                        ? 'border-b-2 border-black font-semibold text-black'
                        : 'border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700';
                    ?>
                    <button onclick="showTab('<?php echo htmlspecialchars($category['name']); ?>')"
                        id="<?php echo $tabId; ?>"
                        class="pb-3 px-1 <?php echo $activeClass; ?> transition-colors">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="min-h-[400px]">
                <?php foreach ($categories as $index => $category): ?>
                    <?php
                    $contentId = str_replace(' ', '', $category['name']) . '-content';
                    $displayClass = $index === 0 ? '' : 'hidden';
                    ?>
                    <div id="<?php echo $contentId; ?>" class="<?php echo $displayClass; ?>">

                        <div class="swiper mySwiper-<?php echo $category['id']; ?>">
                            <div class="swiper-wrapper">
                                <?php foreach ($categoryProducts[$category['name']] as $product): ?>
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-500">
                                            <div class="relative overflow-hidden group">
                                                <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                                    alt="<?php echo htmlspecialchars($product['title']); ?>"
                                                    class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110">
                                            </div>
                                            <div class="p-4">
                                                <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2">
                                                    <?php echo htmlspecialchars($product['title']); ?>
                                                </h3>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                    <?php echo htmlspecialchars($product['description']); ?>
                                                </p>
                                                <a href="product-details.php?id=<?php echo $product['id']; ?>"
                                                    class="block bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-semibold px-4 py-2 rounded-lg text-sm hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 text-center">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script>
        function showTab(tabName) {
            const allContents = document.querySelectorAll('[id$="-content"]');
            const allTabs = document.querySelectorAll('[id$="-tab"]');

            allContents.forEach(c => c.classList.add('hidden'));
            allTabs.forEach(t => {
                t.classList.remove('border-black', 'text-black', 'font-semibold');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            const activeTab = document.getElementById(tabName.replace(/\s/g, '') + '-tab');
            const activeContent = document.getElementById(tabName.replace(/\s/g, '') + '-content');

            activeTab.classList.add('border-black', 'text-black', 'font-semibold');
            activeTab.classList.remove('text-gray-500');
            activeContent.classList.remove('hidden');
        }


        document.addEventListener("DOMContentLoaded", function() {
            <?php foreach ($categories as $cat): ?>
                new Swiper(".mySwiper-<?php echo $cat['id']; ?>", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    navigation: {
                        nextEl: ".mySwiper-<?php echo $cat['id']; ?> .swiper-button-next",
                        prevEl: ".mySwiper-<?php echo $cat['id']; ?> .swiper-button-prev",
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2
                        },
                        1024: {
                            slidesPerView: 4
                        },
                        1440: {
                            slidesPerView: 5
                        }
                    }
                });
            <?php endforeach; ?>
        });
    </script>


    <section class="w-full py-16 px-4 md:px-12 bg-white">
        <div class="max-w-full mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center lg:px-1">
            <div class="text-center">
                <img src="./assets/img/texture2.png" alt="Product Image 1" class="w-full h-64 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Stylish Kitchens</h3>
                <p class="text-gray-600">Elevate your cooking space with modern finishes and thoughtful design.</p>
            </div>
            <div class="text-center">
                <img src="./assets/img/texture3.png" alt="Product Image 2" class="w-full h-64 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Elegant Flooring</h3>
                <p class="text-gray-600">Bring warmth and style to your rooms with high-quality flooring options.</p>
            </div>
            <div class="relative text-center md:text-left">
                <h4 class="text-sm text-yellow-500 uppercase mb-2 tracking-wider">Experience the perfect</h4>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Created With Nature</h2>
                <p class="text-gray-600 mb-6">Experience the perfect balance of elegance and ease, where every piece </p>
                <a href="./about.php" style="background-color: #E6DAC9; font-weight:600;" class="text-black px-6 py-3 rounded-full hover:opacity-90 transition duration-300">
                    Explore More
                </a>
            </div>
        </div>
    </section>



    <section class="w-full bg-white py-16 px-4 md:px-12">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Complete Bathroom Solutions</h2>
            <p class="text-gray-600 mt-2">Fresh Styles Just in! Elevate your look</p>
        </div>

        <div class="relative">
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="swiper-slide">
                                <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                                    <a href="sanitaryware.php?category=<?php echo urlencode($row['category_id']); ?>">
                                        <img src="<?php echo htmlspecialchars($row['image']); ?>"
                                            alt="<?php echo htmlspecialchars($row['category_name']); ?>"
                                            class="w-full h-64 object-cover">
                                    </a>
                                    <div class="p-4 text-center">
                                        <a href="sanitaryware.php?category=<?php echo urlencode($row['category_id']); ?>"
                                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition">
                                            <?php echo htmlspecialchars($row['category_name']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500">No products available right now.</p>
                    <?php endif; ?>
                </div>

                <!-- Swiper navigation -->
                <div class="swiper-button-next text-gray"></div>
                <div class="swiper-button-prev text-gray"></div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".product-swiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                },
                1440: {
                    slidesPerView: 4
                }
            }
        });
    </script>


    <section class="w-full bg-white py-16 px-4 md:px-12">
        <h2 class="text-3xl md:text-4xl font-bold text-black text-center mb-4">Our Projects</h2>
        <p class="text-center text-gray-600 mb-12">Crafted spaces that speak volumes.</p>

        <?php if (isset($projectResult) && $projectResult->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while ($row = $projectResult->fetch_assoc()): ?>
                    <div class="relative group h-64 overflow-hidden rounded-lg shadow">
                        <img src="./admin/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="<?php echo htmlspecialchars($row['name']); ?>"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <h3 class="text-white text-lg font-semibold mb-2">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h3>
                            <a href="project.php?id=<?php echo urlencode($row['id']); ?>"
                                class="bg-white text-black px-4 py-2 rounded-full text-sm hover:bg-gray-200 transition">
                                View More
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500">No projects available at the moment.</p>
        <?php endif; ?>
    </section>


    <?php require(__DIR__ . '/includes/footer.php'); ?>


    <script>
        function showTab(category) {

            document.querySelectorAll('[id$="-content"]').forEach(div => {
                div.classList.add('hidden');
            });

            document.getElementById(category.replace(/\s/g, '') + '-content').classList.remove('hidden');


            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.classList.remove('border-b-2', 'border-black', 'font-semibold', 'text-black');
                tab.classList.add('border-b-2', 'border-transparent', 'font-medium', 'text-gray-500', 'hover:text-gray-700');
            });
            document.getElementById(category.replace(/\s/g, '') + '-tab').classList.add('border-b-2', 'border-black', 'font-semibold', 'text-black');


            const items = document.querySelectorAll('#' + category.replace(/\s/g, '') + '-content .product-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('animate');
                }, index * 100);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            <?php if (!empty($categories)): ?>
                showTab('<?php echo htmlspecialchars($categories[0]['name']); ?>');
            <?php endif; ?>


            const images = document.querySelectorAll('.product-item img');
            images.forEach(img => {
                if (!img.complete) {
                    img.classList.add('loading-skeleton');
                    img.addEventListener('load', function() {
                        this.classList.remove('loading-skeleton');
                    });
                }
            });


            const items = document.querySelectorAll('.product-item');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '50px 0px'
            };
            const itemObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => entry.target.classList.add('animate'), index * 100);
                        itemObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            items.forEach(item => itemObserver.observe(item));
        });
    </script>
</body>

</html>