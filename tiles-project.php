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
    function slugify($text)
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower($text));
        $text = trim($text, '-');
        return $text;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Tiles - Project Range</title>
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="icon" type="image/png" href="./assets/img/logo.png">
    <style>
        .collection-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .collection-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            border-color: #d1d5db;
        }

        .collection-card-header {
            padding: 2rem;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .collection-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .collection-card:hover .collection-icon {
            transform: scale(1.15);
        }

        .collection-card h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #111827;
            transition: all 0.3s ease;
        }

        .collection-card p {
            font-size: 0.95rem;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .collection-card-footer {
            padding: 0 2rem 2rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            border: 2px solid transparent;
        }

        .btn-primary i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover i {
            transform: translateX(4px);
        }

        .btn-outline {
            background: transparent;
            color: inherit;
            border-color: currentColor;
        }

        .btn-filled {
            background: currentColor;
            color: white;
        }
    </style>
</head>

<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <section class="w-full bg-center bg-cover relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16 header-section"
             style="background-image: url('./assets/img/NS-banner.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-3xl sm:max-w-4xl 2xl:max-w-5xl mx-auto px-2 sm:px-4">
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl 2xl:text-7xl font-bold mb-3 sm:mb-4 leading-tight">
                Tiles - Project Range
            </h1>
            <nav class="text-xs sm:text-sm md:text-base 2xl:text-lg space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Tiles - Project Range</span>
            </nav>
        </div>
    </section>

    <section class="py-10 sm:py-16 2xl:py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-12 2xl:px-16">
            <!-- Section Header -->
            <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl 2xl:text-6xl font-bold text-gray-900 mb-4">
                    Our Premium Collections
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto">
                    Explore our curated selection of world-class tile brands and premium collections
                </p>
            </div>

            <!-- Collections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">

                <!-- EMIL Collection -->
                <div class="collection-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="collection-card-header">
                        <div class="collection-icon" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
                            <i class="fas fa-th-large text-3xl text-indigo-600"></i>
                        </div>
                        <h3 style="color: #4f46e5;">EMIL</h3>
                        <p>Discover Italian excellence with EMIL's innovative ceramic solutions. Premium quality tiles that blend contemporary design with timeless elegance.</p>
                    </div>
                    <div class="collection-card-footer">
                        <a href="https://www.emilgroup.com/" target="_blank" class="btn-primary btn-filled" style="background-color: #4f46e5; color: white;">
                            Explore Collection
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="emil-catalogs.php" class="btn-primary btn-outline" style="color: #4f46e5;">
                            View Catalogs
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>

                <!-- GRIFINE Collection -->
                <div class="collection-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="collection-card-header">
                        <div class="collection-icon" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                            <i class="fas fa-gem text-3xl text-emerald-600"></i>
                        </div>
                        <h3 style="color: #059669;">GRIFINE</h3>
                        <p>Experience refined craftsmanship with GRIFINE's exquisite tile collections. Where luxury meets functionality in every design.</p>
                    </div>
                    <div class="collection-card-footer">
                        <a href="https://grifine.in/collections" target="_blank" class="btn-primary btn-filled" style="background-color: #059669; color: white;">
                            Explore Collection
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="grifine-catalogs.php" class="btn-primary btn-outline" style="color: #059669;">
                            View Catalogs
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>

                <!-- NEXION Collection -->
                <div class="collection-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="collection-card-header">
                        <div class="collection-icon" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
                            <i class="fas fa-layer-group text-3xl text-amber-600"></i>
                        </div>
                        <h3 style="color: #d97706;">NEXION</h3>
                        <p>Step into the future with NEXION's cutting-edge tile technology. Modern aesthetics combined with superior durability.</p>
                    </div>
                    <div class="collection-card-footer">
                        <a href="https://nexiontiles.com/" target="_blank" class="btn-primary btn-filled" style="background-color: #d97706; color: white;">
                            Explore Collection
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="nexion-catalogs.php" class="btn-primary btn-outline" style="color: #d97706;">
                            View Catalogs
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>

                <!-- Industrial Collection -->
                <div class="collection-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="collection-card-header">
                        <div class="collection-icon" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                            <i class="fas fa-industry text-3xl text-gray-700"></i>
                        </div>
                        <h3 style="color: #374151;">Industrial</h3>
                        <p>Robust, versatile tiles designed for commercial and industrial applications. 50+ premium items with high durability.</p>
                    </div>
                    <div class="collection-card-footer">
                        <a href="#" class="btn-primary btn-filled" style="background-color: #374151; color: white;">
                            Explore Collection
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="industrial-catalogs.php" class="btn-primary btn-outline" style="color: #374151;">
                            View Catalogs
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12 sm:mt-16" data-aos="fade-up" data-aos-delay="500">
                <p class="text-gray-600 text-base sm:text-lg mb-6">
                    Need help choosing the perfect tiles for your project?
                </p>
                <a href="contact.php"
                   class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-semibold rounded-full hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-phone-alt mr-3"></i>
                    Contact Our Experts
                </a>
            </div>
        </div>
    </section>

    <!-- Initialize AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    </script>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

</body>
</html>