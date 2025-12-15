<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Downloads</title>

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
        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-btn::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: transparent;
            transition: all 0.3s ease;
        }

        .tab-btn.active-tab::before {
            background: linear-gradient(to bottom, #c6aa4b, #c1a234);
        }

        .fade-in {
            animation: fadeIn 0.4s ease-in;
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
    </style>
</head>

<body>
    <?php require(__DIR__ . '/includes/header_all.php'); ?>

    <section class="w-full bg-cover bg-center relative pt-24 pb-24 px-4 sm:px-6 lg:px-12"
        style="background-image: url('./assets/img/breadcrumb-bg1.jpg');">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-2 sm:px-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Downloads</h1>
            <nav class="text-xs sm:text-sm md:text-base space-x-1 sm:space-x-2">
                <a href="index.php" class="hover:underline text-white/80">Home</a>
                <span class="text-white/60">/</span>
                <span class="text-white">Downloads</span>
            </nav>
        </div>
    </section>

    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row bg-white overflow-hidden border border-gray-100">

            <!-- Tabs -->
            <div class="w-full lg:w-1/4 border-b lg:border-b-0 lg:border-r border-gray-200 bg-gradient-to-b from-gray-50 to-white">
                <div class="flex lg:flex-col justify-around lg:justify-start p-2">
                    <button style="background-color: #e9e9e9;" onclick="showTab('Tiles')" id="Tiles-tab"
                        class="tab-btn active-tab w-full px-6 py-4 text-left font-semibold text-red-600 hover:text-red-600 hover:bg-red-50 focus:outline-none transition-all duration-300 rounded-lg my-1 bg-white shadow-sm">
                        Tiles
                    </button>
                    <button style="background-color: #e9e9e9;" onclick="showTab('Mosaics')" id="Mosaics-tab"
                        class="tab-btn w-full px-6 py-4 text-left font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 focus:outline-none transition-all duration-300 rounded-lg my-1">
                        Mosaics
                    </button>
                    <button style="background-color: #e9e9e9;" onclick="showTab('NaturalStones')" id="NaturalStones-tab"
                        class="tab-btn w-full px-6 py-4 text-left font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 focus:outline-none transition-all duration-300 rounded-lg my-1">
                        Natural Stones
                    </button>
                    <button style="background-color: #e9e9e9;" onclick="showTab('CompleteSolutions')" id="CompleteSolutions-tab"
                        class="tab-btn w-full px-6 py-4 text-left font-semibold text-gray-700 hover:text-red-600 hover:bg-red-50 focus:outline-none transition-all duration-300 rounded-lg my-1">
                        Complete Solutions
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="w-full lg:w-3/4 p-8 bg-gradient-to-br from-white to-gray-50">

                <!-- Tiles List -->
                <div id="Tiles-content" class="tab-content fade-in">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Latest Tile Trends</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="pdfs/tile-trends.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="pdfs/tile-trends.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mosaics List -->
                <div id="Mosaics-content" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Latest Mosaic Designs</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="pdfs/mosaic-designs.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="pdfs/mosaic-designs.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Natural Stones List -->
                <div id="NaturalStones-content" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Engineered Marble Collection</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="./uploads/downloads/EXEL ENGINEERED MARBLE COLLECTION.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="./uploads/downloads/EXEL ENGINEERED MARBLE COLLECTION.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Lava Stones Collection</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="./uploads/downloads/EXEL -LAVASTONE.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="./uploads/downloads/EXEL -LAVASTONE.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Granite</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="./uploads/downloads/GRANITE.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="./uploads/downloads/GRANITE.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Mosaics - Ledges</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="./uploads/downloads/Ledgers.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="./uploads/downloads/Ledgers.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complete Solutions List -->
                <div id="CompleteSolutions-content" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                            <div class="flex items-center gap-4">
                                <img src="./assets/img/pdf.png" alt="PDF Icon"
                                    class="w-16 h-16 object-contain bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800">Complete Solutions Guide</h3>
                            </div>
                            <div class="flex gap-3">
                                <a href="pdfs/complete-solutions.pdf" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    View PDF
                                </a>
                                <a href="pdfs/complete-solutions.pdf" download
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Download
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
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            const selectedContent = document.getElementById(`${tabName}-content`);
            selectedContent.classList.remove('hidden');
            selectedContent.classList.add('fade-in');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('text-red-600', 'bg-white', 'shadow-sm', 'font-bold', 'active-tab');
                btn.classList.add('text-gray-700');
            });

            const activeTab = document.getElementById(`${tabName}-tab`);
            activeTab.classList.remove('text-gray-700');
            activeTab.classList.add('text-red-600', 'font-bold', 'bg-white', 'shadow-sm', 'active-tab');
        }

        document.addEventListener('DOMContentLoaded', () => {
            showTab('Tiles');
        });
    </script>
</body>

</html>
