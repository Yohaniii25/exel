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

    <!-- Lightbox2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet">


</head>

<body>

    <?php require(__DIR__  . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12 mt-[130px]" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Gallery</h1>

            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Gallery</span>
            </nav>
        </div>
    </section>

    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Image 1 -->
            <a href="./assets/img/blog.jpeg" data-lightbox="gallery" data-title="Gallery Image 1">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="100">
                    <img src="./assets/img/blog.jpeg" alt="Gallery Image 1"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>

            <!-- Image 2 -->
            <a href="./assets/img/blog1.jpg" data-lightbox="gallery" data-title="Gallery Image 2">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="200">
                    <img src="./assets/img/blog1.jpg" alt="Gallery Image 2"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>

            <!-- Image 3 -->
            <a href="./assets/img/blog2.jpg" data-lightbox="gallery" data-title="Gallery Image 3">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="300">
                    <img src="./assets/img/blog2.jpg" alt="Gallery Image 3"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>

            <!-- Image 4 -->
            <a href="./assets/img/blog3.jpg" data-lightbox="gallery" data-title="Gallery Image 4">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="400">
                    <img src="./assets/img/blog3.jpg" alt="Gallery Image 4"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>

            <!-- Image 5 -->
            <a href="./assets/img/blog4.jpg" data-lightbox="gallery" data-title="Gallery Image 5">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="500">
                    <img src="./assets/img/blog4.jpg" alt="Gallery Image 5"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>

            <!-- Image 6 -->
            <a href="./assets/img/blog11.jpg" data-lightbox="gallery" data-title="Gallery Image 6">
                <div class="overflow-hidden rounded-xl shadow-lg group" data-aos="zoom-in" data-aos-delay="600">
                    <img src="./assets/img/blog11.jpg" alt="Gallery Image 6"
                        class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500 ease-in-out">
                </div>
            </a>
        </div>
    </section>





    <?php require(__DIR__  . '/includes/footer.php'); ?>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Lightbox2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox-plus-jquery.min.js"></script>

    <script>
        AOS.init();
    </script>

</body>

</html>