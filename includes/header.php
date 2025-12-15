<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings - Updated Header</title>
    <link rel="icon" type="image/png" href="./assets/img/exel_lo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/logo.png">
    <style>
        .dropdown-item:hover .dropdown-submenu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .dropdown-submenu {
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #facc15;
        }
    </style>
</head>

<body>

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

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-4 lg:space-x-6 xl:space-x-8 text-sm md:text-base xl:text-lg transition-colors duration-300 px-4" id="main-nav">
                        <a href="index.php" class="nav-link">Home</a>
                        <a href="about.php" class="nav-link">About Us</a>

                        <div class="relative group" id="products-dropdown">
                            <a href="products.php" class="nav-link text-white flex items-center">
                                Products
                                <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                            </a>

                            <!-- Full Width Mega Menu -->
                            <div id="products-menu"
                                class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-6xl bg-white shadow-xl rounded-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-8">
                                    <div class="grid grid-cols-5 gap-8">

                                        <!-- Tiles & Mosaics -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">
                                                Tiles & Mosaics
                                            </h3>
                                            <div class="space-y-2">
                                                <a href="tiles.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Tiles
                                                </a>
                                                <a href="mosaics.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Mosaics
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Natural Stones & Engineered Stones -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">
                                                Natural & Engineered Stones
                                            </h3>
                                            <div class="space-y-2">
                                                <a href="natural-stones.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Natural Stones
                                                </a>
                                                <a href="engineered-stones.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Engineered Stones
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Adhesive & Grout & Industrial Flooring -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">
                                                Adhesive & Grout & Industrial Flooring
                                            </h3>
                                            <div class="space-y-2">
                                                <a href="adhesives.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Explore
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Engineering Services -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">
                                                Engineering Services
                                            </h3>
                                            <div class="space-y-2">
                                                <a href="engineering-services.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Explore
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Complete Bathroom Solutions -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">
                                                Complete Bathroom Solutions
                                            </h3>
                                            <div class="space-y-2">
                                                <a href="sanitaryware.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1"><i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Sanitaryware</a>
                                                <a href="faucets-showers.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1"><i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Faucets & Showers</a>
                                                <a href="water-heater.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1"><i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Water Heater</a>
                                                <a href="wellness.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1"><i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Wellness</a>
                                                <a href="washroom-accessories.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all py-1"><i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Washroom Accessories</a>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Optional: Featured Products or CTA Section -->
                                    <div class="mt-8 pt-6 border-t border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <span class="text-sm text-gray-500">Explore our complete product range</span>
                                                <a href="products.php" class="inline-flex items-center text-sm font-medium text-yellow-600 hover:text-red-700">
                                                    View All Products
                                                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="projects.php" class="nav-link">Projects</a>
                        <a href="services.php" class="nav-link">Services</a>
                        <a href="blogs.php" class="nav-link">Blogs</a>
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
                <div class="max-w-[1920px] mx-auto">
                    <a href="index.php" class="block py-2 hover:text-red-900 font-medium">Home</a>
                    <a href="about.php" class="block py-2 hover:text-red-900 font-medium">About Us</a>

                    <!-- Mobile Products Dropdown -->
                    <div class="block">
                        <button id="mobile-products-btn" class="w-full text-left py-2 hover:text-red-900 font-medium flex items-center justify-between focus:outline-none">
                            <span>Products</span>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200" id="mobile-products-arrow"></i>
                        </button>
                        <div id="mobile-products-menu" class="ml-4 mt-1 space-y-1 max-h-0 overflow-hidden transition-all duration-300">

                            <!-- Mobile Tiles -->
                            <!-- Tiles & Mosaics -->
                            <div>
                                <button class="mobile-submenu-btn" data-target="mobile-tiles-mosaics-menu">
                                    Tiles & Mosaics <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-tiles-mosaics-menu" class="submenu">
                                    <a href="tiles-standard.php">Tiles</a>
                                    <a href="mosaics-glass.php">Mosaics</a>
                                </div>
                            </div>

                            <!-- Natural & Engineered Stones -->
                            <div>
                                <button class="mobile-submenu-btn" data-target="mobile-stones-menu">
                                    Natural & Engineered Stones <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-stones-menu" class="submenu">
                                    <a href="natural-stones.php">Natural Stones</a>
                                    <a href="engineered-stones.php">Engineered Stones</a>
                                </div>
                            </div>

                            <!-- Adhesives & Industrial -->
                            <div>
                                <a href="adhesives.php" class="block py-1 text-sm text-gray-300 hover:text-red-900">
                                    Adhesive & Grout & Industrial Flooring
                                </a>
                            </div>

                            <!-- Engineering Services -->
                            <div>
                                <a href="engineering-services.php" class="block py-1 text-sm text-gray-300 hover:text-red-900">
                                    Engineering Services
                                </a>
                            </div>

                            <!-- Complete Bathroom Solutions -->
                            <div>
                                <button class="mobile-submenu-btn" data-target="mobile-solutions-menu">
                                    Complete Bathroom Solutions <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-solutions-menu" class="submenu">
                                    <a href="sanitaryware.php">Sanitaryware</a>
                                    <a href="faucets-showers.php">Faucets & Showers</a>
                                    <a href="water-heater.php">Water Heater</a>
                                    <a href="wellness.php">Wellness</a>
                                    <a href="washroom-accessories.php">Washroom Accessories</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <a href="projects.php" class="block py-2 hover:text-red-900 font-medium">Projects</a>
                    <a href="services.php" class="block py-2 hover:text-red-900 font-medium">Services</a>
                    <a href="blogs.php" class="block py-2 hover:text-red-900 font-medium">Blogs</a>
                    <a href="contact.php" class="block py-2 hover:text-red-900 font-medium">Contact</a>
                    <div class="mt-4">
                        <input type="text" placeholder="Search..." class="w-full bg-white text-black px-3 py-2 rounded focus:outline-none">
                    </div>
                </div>
            </div>
        </header>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mobile menu toggle
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            if (toggleBtn && mobileMenu) {
                toggleBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('block');
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
                        // Collapse Products menu and all submenus
                        mobileProductsMenu.style.maxHeight = '0px';
                        mobileProductsArrow.classList.remove('rotate-180');
                        document.querySelectorAll('.mobile-submenu-btn').forEach(btn => {
                            const targetId = btn.getAttribute('data-target');
                            const submenu = document.getElementById(targetId);
                            const arrow = btn.querySelector('.mobile-submenu-arrow');
                            if (submenu) submenu.style.maxHeight = '0px';
                            if (arrow) arrow.classList.remove('rotate-180');
                        });
                    } else {
                        // Expand Products menu
                        mobileProductsMenu.style.maxHeight = mobileProductsMenu.scrollHeight + 'px';
                        mobileProductsArrow.classList.add('rotate-180');
                    }
                });
            }

            // Mobile Submenu Toggles
            document.querySelectorAll('.mobile-submenu-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const targetId = btn.getAttribute('data-target');
                    const submenu = document.getElementById(targetId);
                    const arrow = btn.querySelector('.mobile-submenu-arrow');

                    if (submenu) {
                        const isExpanded = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';

                        // Collapse all other submenus
                        document.querySelectorAll('.mobile-submenu-btn').forEach(otherBtn => {
                            const otherTargetId = otherBtn.getAttribute('data-target');
                            const otherSubmenu = document.getElementById(otherTargetId);
                            const otherArrow = otherBtn.querySelector('.mobile-submenu-arrow');
                            if (otherTargetId !== targetId && otherSubmenu && otherSubmenu.style.maxHeight !== '0px') {
                                otherSubmenu.style.maxHeight = '0px';
                                if (otherArrow) otherArrow.classList.remove('rotate-180');
                            }
                        });

                        // Toggle current submenu
                        if (isExpanded) {
                            submenu.style.maxHeight = '0px';
                            if (arrow) arrow.classList.remove('rotate-180');
                        } else {
                            submenu.style.maxHeight = submenu.scrollHeight + 'px';
                            if (arrow) arrow.classList.add('rotate-180');
                        }

                        // Recalculate Products menu height
                        let totalHeight = mobileProductsMenu.scrollHeight;
                        document.querySelectorAll('.mobile-submenu-btn').forEach(otherBtn => {
                            const otherTargetId = otherBtn.getAttribute('data-target');
                            const otherSubmenu = document.getElementById(otherTargetId);
                            if (otherSubmenu && otherSubmenu.style.maxHeight !== '0px') {
                                totalHeight += otherSubmenu.scrollHeight;
                            }
                        });
                        mobileProductsMenu.style.maxHeight = totalHeight + 'px';
                    }
                });
            });

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
                    if (topBar) {
                        topBar.classList.add('bg-white', 'text-black');
                        topBar.classList.remove('bg-black', 'bg-opacity-40', 'text-white');
                    }
                    if (topBorder) topBorder.classList.add('border-gray-300');
                    if (headerBorder) headerBorder.classList.add('border-gray-300');

                    navLinks.forEach(link => {
                        link.classList.remove('text-white');
                        link.classList.add('text-black');
                    });
                } else {
                    header.classList.remove('bg-white', 'shadow-md');
                    header.classList.add('bg-transparent');
                    if (topBar) {
                        topBar.classList.remove('bg-white', 'text-black');
                        topBar.classList.add('bg-black', 'bg-opacity-40', 'text-white');
                    }
                    if (topBorder) topBorder.classList.remove('border-gray-300');
                    if (headerBorder) headerBorder.classList.remove('border-gray-300');

                    navLinks.forEach(link => {
                        link.classList.add('text-white');
                        link.classList.remove('text-black');
                    });
                }
            });
        });
    </script>

</body>

</html>