<!-- Sticky Header Wrapper -->
<div class="fixed top-0 left-0 w-full z-[999]">

    <!-- Top Bar -->
    <div id="top-bar" class="bg-black bg-opacity-40 text-white text-xs sm:text-sm md:text-base xl:text-base 2xl:text-lg py-2 px-4 transition-all duration-300">
        <div class="max-w-[1920px] mx-auto flex justify-start items-center">
            <div class="flex items-center space-x-4 sm:space-x-6">
                <span class="flex items-center space-x-2">
                    <i class="fas fa-phone text-yellow-400 text-sm md:text-base"></i>
                    <span class="whitespace-nowrap">011 280 66 03</span>
                </span>
                <span class="flex items-center space-x-2">
                    <i class="fas fa-clock text-yellow-400 text-sm md:text-base"></i>
                    <span class="whitespace-nowrap">Mon–Sat: 9 AM – 6 PM</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Border line -->
    <div class="border-t border-white opacity-20" id="top-border"></div>

    <!-- Main Header -->
    <header id="main-header" class="bg-transparent transition-all duration-300 text-white">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.php">
                        <img src="./assets/img/logo.png" alt="Exel Holdings Logo" class="h-10 md:h-12 xl:h-14">
                    </a>
                </div>

                <nav class="hidden md:flex items-center space-x-4 lg:space-x-6 xl:space-x-8 text-sm md:text-base xl:text-lg transition-colors duration-300" id="main-nav">
                    <a href="index.php" class="nav-link">Home</a>
                    <a href="about.php" class="nav-link">About Us</a>

                    <div class="relative group" id="products-dropdown">
                        <a href="products2.php" class="nav-link text-white flex items-center">
                            Products
                            <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>

                        <!-- Dropdown Menu -->
                        <div id="products-menu"
                            class="absolute top-full left-0 mt-2 w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="py-2">
                                <!-- Tiles Submenu -->
                                <div class="relative group/sub">
                                    <a href="tiles.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 flex items-center">
                                        Tiles
                                        <i class="fas fa-chevron-right ml-auto text-xs transition-transform duration-200 group-hover/sub:rotate-90"></i>
                                    </a>
                                    <div class="absolute top-0 left-full w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-300 z-50">
                                        <a href="tiles-standard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Standard Range</a>
                                        <a href="tiles-project.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Project Range</a>
                                    </div>
                                </div>

                                <!-- Mosaics Submenu -->
                                <div class="relative group/sub">
                                    <a href="mosaics.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 flex items-center">
                                        Mosaics
                                        <i class="fas fa-chevron-right ml-auto text-xs transition-transform duration-200 group-hover/sub:rotate-90"></i>
                                    </a>
                                    <div class="absolute top-0 left-full w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-300 z-50">
                                        <a href="mosaics-glass.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Glass Mosaics</a>
                                        <a href="mosaics-project.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Project Range</a>
                                    </div>
                                </div>

                                <!-- Natural Stones Submenu -->
                                <div class="relative group/sub">
                                    <a href="natural-stones.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 flex items-center">
                                        Natural Stones
                                        <i class="fas fa-chevron-right ml-auto text-xs transition-transform duration-200 group-hover/sub:rotate-90"></i>
                                    </a>
                                    <div class="absolute top-0 left-full w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-300 z-50">
                                        <a href="natural-stones.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Natural Stones</a>
                                        <a href="engineered-stones.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Engineered Stones</a>
                                        <a href="adhesives.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Adhesives, Grouts & Industrial Flooring</a>
                                        <a href="engineering-services.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Engineering Services</a>
                                    </div>
                                </div>

                                <!-- Complete Solutions Submenu -->
                                <div class="relative group/sub">
                                    <a href="complete-solutions.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 flex items-center">
                                        Complete Solutions
                                        <i class="fas fa-chevron-right ml-auto text-xs transition-transform duration-200 group-hover/sub:rotate-90"></i>
                                    </a>
                                    <div class="absolute top-0 left-full w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-300 z-50">
                                        <a href="sanitaryware.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Sanitaryware</a>
                                        <a href="faucets-showers.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Faucets & Showers</a>
                                        <a href="water-heater.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Water Heater</a>
                                        <a href="wellness.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Wellness</a>
                                        <a href="washroom-accessories.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">Washroom Accessories</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="projects.php" class="nav-link">Projects</a>
                    <a href="services.php" class="nav-link">Services</a>
                    <a href="gallery.php" class="nav-link">Gallery</a>
                    <a href="contact.php" class="nav-link">Contact</a>

                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search..."
                            class="bg-white text-black text-sm px-3 py-1 pr-8 rounded-full focus:outline-none">
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-500 text-sm"></i>
                        </div>
                    </div>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-toggle" class="text-white focus:outline-none text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="border-t border-white opacity-20" id="header-border"></div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-black bg-opacity-90 text-white px-4 py-4 hidden">
            <a href="index.php" class="block py-2 hover:text-yellow-400 font-medium">Home</a>
            <a href="about.php" class="block py-2 hover:text-yellow-400 font-medium">About Us</a>

            <!-- Mobile Products Dropdown -->
            <div class="block">
                <button id="mobile-products-btn" class="w-full text-left py-2 hover:text-yellow-400 font-medium flex items-center justify-between focus:outline-none">
                    <span>Products</span>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200" id="mobile-products-arrow"></i>
                </button>
                <div id="mobile-products-menu" class="ml-4 mt-1 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                    <div class="block">
                        <button class="w-full text-left py-1 text-sm text-gray-300 hover:text-yellow-400 flex items-center justify-between focus:outline-none" onclick="this.nextElementSibling.classList.toggle('max-h-0'); this.nextElementSibling.classList.toggle('max-h-[500px]'); this.querySelector('i').classList.toggle('rotate-180');">
                            <span>Tiles</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                            <a href="tiles-standard.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Standard Range</a>
                            <a href="tiles-project.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Project Range</a>
                        </div>
                    </div>
                    <div class="block">
                        <button class="w-full text-left py-1 text-sm text-gray-300 hover:text-yellow-400 flex items-center justify-between focus:outline-none" onclick="this.nextElementSibling.classList.toggle('max-h-0'); this.nextElementSibling.classList.toggle('max-h-[500px]'); this.querySelector('i').classList.toggle('rotate-180');">
                            <span>Mosaics</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                            <a href="mosaics-glass.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Glass Mosaics</a>
                            <a href="mosaics-project.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Project Range</a>
                        </div>
                    </div>
                    <div class="block">
                        <button class="w-full text-left py-1 text-sm text-gray-300 hover:text-yellow-400 flex items-center justify-between focus:outline-none" onclick="this.nextElementSibling.classList.toggle('max-h-0'); this.nextElementSibling.classList.toggle('max-h-[500px]'); this.querySelector('i').classList.toggle('rotate-180');">
                            <span>Natural Stones</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                            <a href="natural-stones.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Natural Stones</a>
                            <a href="engineered-stones.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Engineered Stones</a>
                            <a href="adhesives.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Adhesives, Grouts & Industrial Flooring</a>
                            <a href="engineering-services.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Engineering Services</a>
                        </div>
                    </div>
                    <div class="block">
                        <button class="w-full text-left py-1 text-sm text-gray-300 hover:text-yellow-400 flex items-center justify-between focus:outline-none" onclick="this.nextElementSibling.classList.toggle('max-h-0'); this.nextElementSibling.classList.toggle('max-h-[500px]'); this.querySelector('i').classList.toggle('rotate-180');">
                            <span>Complete Solutions</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                            <a href="sanitaryware.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Sanitaryware</a>
                            <a href="faucets-showers.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Faucets & Showers</a>
                            <a href="water-heater.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Water Heater</a>
                            <a href="wellness.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Wellness</a>
                            <a href="washroom-accessories.php" class="block py-1 text-sm text-gray-300 hover:text-yellow-400">Washroom Accessories</a>
                        </div>
                    </div>
                </div>
            </div>

            <a href="projects.php" class="block py-2 hover:text-yellow-400 font-medium">Projects</a>
            <a href="services.php" class="block py-2 hover:text-yellow-400 font-medium">Services</a>
            <a href="gallery.php" class="block py-2 hover:text-yellow-400 font-medium">Gallery</a>
            <a href="contact.php" class="block py-2 hover:text-yellow-400 font-medium">Contact</a>
            <div class="mt-4">
                <input type="text" placeholder="Search..." class="w-full bg-white text-black px-3 py-2 rounded focus:outline-none">
            </div>
        </div>
    </header>
</div>

<!-- FontAwesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script src="https://cdn.tailwindcss.com"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mobile menu toggle
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Mobile Products Dropdown
        const mobileProductsBtn = document.getElementById('mobile-products-btn');
        const mobileProductsMenu = document.getElementById('mobile-products-menu');
        const mobileProductsArrow = document.getElementById('mobile-products-arrow');

        if (mobileProductsBtn && mobileProductsMenu) {
            mobileProductsBtn.addEventListener('click', () => {
                const isExpanded = mobileProductsMenu.style.maxHeight && mobileProductsMenu.style.maxHeight !== '0px';

                if (isExpanded) {
                    mobileProductsMenu.style.maxHeight = '0px';
                    mobileProductsArrow.classList.remove('rotate-180');
                } else {
                    mobileProductsMenu.style.maxHeight = mobileProductsMenu.scrollHeight + 'px';
                    mobileProductsArrow.classList.add('rotate-180');
                }
            });
        }

        // Scroll behavior
        const header = document.getElementById('main-header');
        const navLinks = document.querySelectorAll('.nav-link');
        const topBar = document.getElementById('top-bar');
        const topBorder = document.getElementById('top-border');
        const headerBorder = document.getElementById('header-border');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('bg-white', 'shadow-md');
                header.classList.remove('bg-transparent');
                topBar.classList.add('bg-white', 'text-black');
                topBar.classList.remove('bg-black', 'bg-opacity-40', 'text-white');
                topBorder.classList.add('border-gray-300');
                headerBorder.classList.add('border-gray-300');

                navLinks.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-black');
                });
            } else {
                header.classList.remove('bg-white', 'shadow-md');
                header.classList.add('bg-transparent');
                topBar.classList.remove('bg-white', 'text-black');
                topBar.classList.add('bg-black', 'bg-opacity-40', 'text-white');
                topBorder.classList.remove('border-gray-300');
                headerBorder.classList.remove('border-gray-300');

                navLinks.forEach(link => {
                    link.classList.add('text-white');
                    link.classList.remove('text-black');
                });
            }
        });
    });
</script>