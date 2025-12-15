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
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.5/dist/tailwind.min.css" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        .card-hover:hover {
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }


        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>

<body>

    <?php require(__DIR__  . '/includes/header_all.php'); ?>


    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Services</h1>

            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Services</span>
            </nav>
        </div>
    </section>


    <section class="py-20 px-4 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 font-kalnia mb-6">
                Excellence in Every <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Stone</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                From restoration to custom design, we deliver unparalleled quality in natural stone services
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Service 1: Restoration -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden group transition-all hover:shadow-2xl">
                <img src="./assets/img/restore.png" alt="Restoration" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-kalnia group-hover:text-purple-600 transition-colors">
                        Restoration & Treatment of Natural Stone
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Our professional expertise in progressively cutting and polishing granite with state-of-the-art heavy duty grinding machines...
                    </p>
                    <div class="flex items-center text-purple-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>

            <!-- Service 2: De-staining -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden group transition-all hover:shadow-2xl">
                <img src="./assets/img/natural.png" alt="De-staining" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-kalnia group-hover:text-teal-600 transition-colors">
                        De-staining of Natural Stone
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Marble and natural stones are porous materials which stain easily...
                    </p>
                    <div class="flex items-center text-teal-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>

            <!-- Service 3: Engineering -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden group transition-all hover:shadow-2xl">
                <img src="./assets/img/engineer1.png" alt="Engineering" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-kalnia group-hover:text-red-600 transition-colors">
                        Engineering Services
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Our team consists of experienced Engineers, Quantity Surveyors, Draftsmen...
                    </p>
                    <div class="flex items-center text-red-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>

            <!-- Service 4: Custom Design -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden group transition-all hover:shadow-2xl">
                <img src="./assets/img/custom.png" alt="Custom Design" class="w-full h-64 object-cover">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-kalnia group-hover:text-rose-600 transition-colors">
                        Custom Design
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        We go the extra mile to customize and deliver distinctive designs...
                    </p>
                    <div class="flex items-center text-rose-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>






    <?php require(__DIR__  . '/includes/footer.php'); ?>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>