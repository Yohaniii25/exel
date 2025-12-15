<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Blogs</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kalnia:opsz,wght@16..144,400;700&display=stylesheet" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Lightbox2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet">

    <style>
        .tab-content {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .active-tab {
            border-bottom: 3px solid #c09f2c;
            color: #96161a;
            background: linear-gradient(to top, #eff6ff, #ffffff);
        }
    </style>
</head>

<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12" style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Blogs</h1>
            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Blogs</span>
            </nav>
        </div>
    </section>

    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="mb-8">
            <!-- Tabs Navigation -->
            <div class="flex flex-wrap justify-center gap-2 sm:gap-4 lg:gap-6 border-b-2 border-gray-200 bg-white rounded-t-xl shadow-sm px-4">
                <button onclick="showTab('Tiles')" id="Tiles-tab" class="tab-btn px-6 py-3 font-semibold text-gray-600 rounded-t-lg hover:text-red-600 focus:outline-none transition-all duration-300 active-tab">
                    Tiles
                </button>
                <button onclick="showTab('Mosaics')" id="Mosaics-tab" class="tab-btn px-6 py-3 font-semibold text-gray-600 rounded-t-lg hover:text-red-600 focus:outline-none transition-all duration-300">
                    Mosaics
                </button>
                <button onclick="showTab('NaturalStones')" id="NaturalStones-tab" class="tab-btn px-6 py-3 font-semibold text-gray-600 rounded-t-lg hover:text-red-600 focus:outline-none transition-all duration-300">
                    Natural Stones
                </button>
                <button onclick="showTab('CompleteSolutions')" id="CompleteSolutions-tab" class="tab-btn px-6 py-3 font-semibold text-gray-600 rounded-t-lg hover:text-red-600 focus:outline-none transition-all duration-300">
                    Complete Solutions
                </button>
            </div>
            
            <!-- Tab Content -->
            <div class="mt-8">
                <!-- Tiles Content -->
                <div id="Tiles-content" class="tab-content">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?w=600" alt="Latest Tile Trends" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Latest Tile Trends</h3>
                                <p class="text-gray-600 mb-4">Explore the newest designs in ceramic and porcelain tiles for 2025.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1620626011761-996317b8d101?w=600" alt="Installation Tips" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Installation Tips</h3>
                                <p class="text-gray-600 mb-4">Learn how to install tiles like a pro with our step-by-step guide.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mosaics Content -->
                <div id="Mosaics-content" class="tab-content hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600" alt="Mosaic Art Revival" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Mosaic Art Revival</h3>
                                <p class="text-gray-600 mb-4">Discover the resurgence of mosaic art in modern interiors.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1581858726788-75bc0f6a952d?w=600" alt="DIY Mosaic Projects" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">DIY Mosaic Projects</h3>
                                <p class="text-gray-600 mb-4">Create your own mosaic masterpiece with these easy projects.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Natural Stones Content -->
                <div id="NaturalStones-content" class="tab-content hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=600" alt="Marble Care Guide" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Marble Care Guide</h3>
                                <p class="text-gray-600 mb-4">Tips to maintain the beauty of natural marble surfaces.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?w=600" alt="Granite vs. Marble" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Granite vs. Marble</h3>
                                <p class="text-gray-600 mb-4">A comparison to help you choose the right stone.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Complete Solutions Content -->
                <div id="CompleteSolutions-content" class="tab-content hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600" alt="Full Home Renovation" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Full Home Renovation</h3>
                                <p class="text-gray-600 mb-4">Transform your home with our complete solution packages.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600" alt="Sustainable Design" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-3 text-gray-800">Sustainable Design</h3>
                                <p class="text-gray-600 mb-4">Eco-friendly options for your next project.</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                    Read More
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require(__DIR__ . '/includes/footer.php'); ?>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Lightbox2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox-plus-jquery.min.js"></script>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.classList.remove('active-tab');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            document.getElementById(tabName + '-tab').classList.add('active-tab');
        }
    </script>
</body>

</html>