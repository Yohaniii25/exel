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
    <link rel="icon" type="image/png" href="./assets/img/exel_lo.png">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        .icon-wrap {
            position: relative;
            transition: all 0.3s ease;
        }

        .icon-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 9999px;
            background-image: linear-gradient(135deg, #FFD700, #FFA500);
            opacity: 0;
            transform: scale(1.2);
            transition: opacity 0.3s ease, transform 0.3s ease;
            z-index: 0;
        }

        .group:hover .icon-wrap::after {
            opacity: 1;
            transform: scale(1);
        }
    </style>

</head>

<body>

    <?php require(__DIR__  . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Contact Us</h1>

            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Contact Us</span>
            </nav>
        </div>
    </section>

    <section class="py-20 px-4 mx-auto max-w-7xl overflow-x-hidden">


        <div class="relative z-10 max-w-8xl mx-auto text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 md:mb-6">Connect WIth Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

            <div class="bg-white text-center shadow-md rounded-xl p-6 group">
                <div class="w-16 h-16 mx-auto mb-4 relative z-10 icon-wrap">
                    <div class="w-full h-full rounded-full bg-red-600 text-white flex items-center justify-center relative z-10 text-2xl">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-gray-800 mb-1">Our Office</h4>
                <p class="text-lg font-semibold text-gray-600">
                    No 87, Nawala Road,<br>
                    Nugegoda
                </p>
            </div>

            <!-- Item 2 -->
            <div class="bg-white text-center shadow-md rounded-xl p-6 group">
                <div class="w-16 h-16 mx-auto mb-4 relative z-10 icon-wrap">
                    <div class="w-full h-full rounded-full bg-red-600 text-white flex items-center justify-center relative z-10 text-2xl">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-gray-800 mb-1">Call Us</h4>
                <p class="text-lg font-semibold text-gray-600">94 712 614 614</p>
            </div>

            <!-- Item 3 -->
            <div class="bg-white text-center shadow-md rounded-xl p-6 group">
                <div class="w-16 h-16 mx-auto mb-4 relative z-10 icon-wrap">
                    <div class="w-full h-full rounded-full bg-red-600 text-white flex items-center justify-center relative z-10 text-2xl">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <h4 class="text-lg font-bold text-gray-800 mb-1">Email Us</h4>
                <p class="text-lg font-semibold text-gray-600">info@exelholdings.lk</p>
            </div>
        </div>


        <!-- Contact Form + Map -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold mb-6 text-gray-800 font-kalnia">Send Us a Message</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                        <input type="text" placeholder="Your Name" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" placeholder="you@example.com" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Message</label>
                        <textarea rows="5" placeholder="Your message" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Send Message</button>
                </form>
            </div>

            <!-- Google Map -->
            <div class="w-full">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.1023601955208!2d79.88794087413447!3d6.878338818939934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25960d2621615%3A0xa5fbe56034cc68e!2sExel%20Holdings%20(Pvt)%20Ltd%20-%20Nugegoda!5e0!3m2!1sen!2slk!4v1755149869283!5m2!1sen!2slk"
                    width="100%"
                    height="400"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    class="rounded-xl shadow-lg w-full h-[400px]"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
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