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

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

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
            position: relative;
        }

        .collection-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .collection-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .collection-card:hover::after {
            opacity: 1;
        }

        .pdf-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #dc2626;
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            z-index: 2;
        }

        .collection-card-header {
            padding: 2.5rem 2rem;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 2;
        }

        .collection-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fef2f2;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .collection-card:hover .collection-icon {
            transform: scale(1.15);
        }

        .collection-card-footer {
            padding: 0 2rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            z-index: 2;
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
            width: 100%;
        }

        .btn-primary i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover i {
            transform: translateX(4px);
        }

        .btn-filled {
            background: #dc2626;
            color: white;
        }

        .btn-filled:hover {
            background: #b91c1c;
        }

        .btn-outline {
            background: transparent;
            color: #dc2626;
            border-color: #dc2626;
        }
    </style>
</head>

<body>

    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <!-- HERO -->
    <section class="w-full bg-center bg-cover relative pt-20 pb-20 sm:pt-24 sm:pb-24 px-4 sm:px-6 lg:px-12 2xl:px-16"
        style="background-image: url('./assets/img/copy.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 text-center text-white max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold mb-4">
                Catalogs
            </h1>
            <nav class="text-sm sm:text-base space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span>Catalogs - Grifine Project Range</span>
            </nav>
        </div>
    </section>

    <?php
    $pdfCatalogs = [
        ['file' => './uploads/catalogs/Grifine Master catalouge 2025.pdf'],


    ];
    ?>

    <!-- PDF SECTION -->
    <section class="py-16 px-4 sm:px-6 lg:px-12 2xl:px-16 bg-gray-50">
        <div class="max-w-7xl mx-auto">

            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-12 text-gray-900">
                Download Our Catalogs
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

                <?php foreach ($pdfCatalogs as $pdf): ?>
                    <div class="collection-card" data-aos="fade-up">

                        <span class="pdf-badge">PDF</span>

                        <div class="collection-card-header">
                            <div class="collection-icon">
                                <i class="fa-solid fa-file-pdf text-5xl text-red-600"></i>
                            </div>
                        </div>

                        <div class="collection-card-footer">
                            <a href="<?= $pdf['file'] ?>" target="_blank" class="btn-primary btn-filled">
                                View PDF <i class="fa-solid fa-arrow-right"></i>
                            </a>

                            <a href="<?= $pdf['file'] ?>" download class="btn-primary btn-outline">
                                Download
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

</body>

</html>
