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
        /* Global overflow prevention */
        html,
        body {
            overflow-x: hidden;
            box-sizing: border-box;
        }

        *,
        *::before,
        *::after {
            box-sizing: inherit;
        }

        .bg-pattern {
            background-image: url('./assets/img/vision-bg.jpg');
            background-size: cover, 50px 50px;
            background-position: center, center;
            position: relative;
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

        }


        .content-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.98);
        }

        .icon-container {
            transition: all 0.3s ease;
        }

        .content-card:hover .icon-container {
            transform: scale(1.1);
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite linear;
        }

        .floating-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: -5s;
        }

        .floating-circle:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 70%;
            animation-delay: -10s;
        }

        .custom-hover:hover {
            background-color: #95161d !important;
            color: white !important;
        }

        .custom-hover:hover h4,
        .custom-hover:hover p {
            color: white !important;
        }

        .custom-hover:hover .icon-wrapper {
            background-color: white !important;
        }

        .custom-hover:hover .icon-wrapper i {
            color: #95161d !important;
        }
    </style>

</head>

<body>

    <?php require(__DIR__  . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">About Us</h1>

            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">About Us</span>
            </nav>
        </div>
    </section>


    <!-- Who We Are Section -->

    <section class="relative py-16 md:py-20 lg:py-24 px-4 md:px-8 bg-cover bg-center bg-no-repeat"
        style="background-image: url('./assets/img/bg-about.jpg'); background-size: cover; background-position: center;">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-white/90 backdrop-blur-sm"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-8xl mx-auto text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 md:mb-6">Who We Are</h2>

            <p class="text-sm sm:text-base md:text-lg text-gray-700 mb-4 md:mb-6">
                At EXEL, we pledge to elevate living spaces to higher standards with our exceptional products and services. We remain committed to adopting the best quality products and cutting-edge technologies available in the global arena to meet and exceed our customers' expectations.
            </p>

            <p class="text-sm sm:text-base md:text-lg text-gray-700 mb-4 md:mb-6">
                Our dedicated team is driven by the ambition to enhance Leisure and Corporate premises in Sri Lanka and Maldives with Genuine Marble and Granite, Tile, Mosaics, Sanitaryware, Faucets and other building finishes sourced globally.
            </p>

            <p class="text-sm sm:text-base md:text-lg text-gray-700 mb-4 md:mb-6">
                As one of the pioneers of the modern era of superior finishes since 1992, EXEL boasts an unblemished track record and rich heritage in every aspect of the industry.
            </p>

            <p class="text-sm sm:text-base md:text-lg text-gray-700 mb-4 md:mb-6">
                The projects awarded to EXEL over the years speak for themselves. We invite you to explore our product and service portfolio and discover what sets us apart.
            </p>

            <p class="text-sm sm:text-base md:text-lg text-gray-700">
                We are confident this will be the beginning of a warm, lifelong relationship between you and EXEL.
            </p>
        </div>
    </section>

    <section class="py-16 bg-pattern relative min-h-screen">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24 relative z-10">

            <!-- Vision Row -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16 items-center">
                <!-- Vision Image -->
                <div class="md:col-span-4 flex justify-center" data-aos="fade-right" data-aos-duration="1000">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg transform rotate-3 opacity-20"></div>
                        <img src="./assets/img/vision.png" alt="Vision"
                            class="relative w-full max-w-[18rem] rounded-lg shadow-2xl object-contain transform hover:scale-105 transition-transform duration-300">
                    </div>
                </div>

                <!-- Vision Text -->
                <div class="md:col-span-8" data-aos="fade-left" data-aos-duration="1000">
                    <div class="content-card rounded-xl p-6 sm:p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="icon-container bg-gradient-to-br from-yellow-100 to-orange-100 p-4 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-eye text-2xl bg-gradient-to-br from-yellow-600 to-orange-600 bg-clip-text text-transparent"></i>
                            </div>
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Our Vision</h3>
                        </div>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            At EXEL, our vision is to be a transformative force in shaping forward-thinking, future-ready businesses that enrich lives and industries alike. We strive to lead with innovation, integrity, and global relevance, creating a legacy that goes beyond success — one that inspires excellence and meaningful impact across every community we touch.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mission Row -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16 items-center">
                <!-- Mission Text -->
                <div class="md:col-span-8 order-2 md:order-1" data-aos="fade-right" data-aos-duration="1000">
                    <div class="content-card rounded-xl p-6 sm:p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="icon-container bg-gradient-to-br from-blue-100 to-indigo-100 p-4 rounded-full mr-4 shadow-lg">
                                <i class="fas fa-bullseye text-2xl bg-gradient-to-br from-blue-600 to-indigo-600 bg-clip-text text-transparent"></i>
                            </div>
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Our Mission</h3>
                        </div>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Our mission is to create lasting value by developing, investing in, and empowering exceptional businesses that deliver excellence in every detail. We are committed to providing world-class solutions through strategic leadership, continuous innovation, and a steadfast dedication to quality, ensuring that our clients, partners, and communities experience growth that is both sustainable and significant.
                        </p>
                    </div>
                </div>

                <!-- Mission Image -->
                <div class="md:col-span-4 flex justify-center order-1 md:order-2" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg transform -rotate-3 opacity-20"></div>
                        <img src="./assets/img/mission.png" alt="Mission"
                            class="relative w-full max-w-[18rem] rounded-lg shadow-2xl object-contain transform hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Our Values Section -->
    <section class="py-16 bg-white">
        <div class="max-w-[1920px] mx-auto px-4 md:px-8">
            <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Values</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Our core values guide every decision we make and every relationship we build.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-handshake text-2xl text-blue-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Excellence in Quality</h4>
                    <p class="transition-all">
                        We are committed to offering only the finest materials and finishes, ensuring superior durability, design, and craftsmanship in every project we undertake.
                    </p>
                </div>

                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-green-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-award text-2xl text-green-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Innovation & Progress</h4>
                    <p class="transition-all">
                        At EXEL, we embrace modern technologies and global design trends to deliver cutting-edge solutions that shape the future of living spaces.
                    </p>
                </div>

                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-purple-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-lightbulb text-2xl text-purple-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Integrity & Trust</h4>
                    <p class="transition-all">
                        Honesty, transparency, and ethical practices guide all our actions, building lasting trust with our clients, partners, and communities.
                    </p>
                </div>

                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-orange-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-users text-2xl text-orange-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Customer-Centric Approach</h4>
                    <p class="transition-all">
                        We listen, understand, and prioritize our customers' needs, offering tailored solutions that exceed expectations at every stage.
                    </p>
                </div>

                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-emerald-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-leaf text-2xl text-emerald-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Sustainability</h4>
                    <p class="transition-all">
                        We take pride in sourcing and promoting environmentally responsible products, contributing to a greener, more sustainable future.
                    </p>
                </div>

                <!-- VALUE CARD -->
               <div class="group text-center p-6 rounded-lg shadow transition-all duration-300 custom-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-red-100 group-hover:bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transition-all">
                        <i class="fas fa-rocket text-2xl text-red-600 group-hover:text-[#95161d]"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-3 transition-all">Teamwork & Collaboration</h4>
                    <p class="transition-all">
                        Our success is built on strong relationships, open communication, and a shared vision, fostering collaboration across every level of our organization.
                    </p>
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