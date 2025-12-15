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
</head>


<body>

    <div id="sticky-header-wrapper" class="w-full z-50">

        <div class="bg-white text-black text-xs sm:text-sm md:text-base xl:text-base 2xl:text-lg py-2 px-4">
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

        <div class="border-t border-black opacity-20" id="top-border"></div>

        <header id="main-header" class="bg-white transition-all duration-300 shadow-md">
            <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <div class="flex-shrink-0">
                        <a href="index.php">
                            <img src="./assets/img/logo.png" alt="Exel Holdings Logo" class="h-10 md:h-12 xl:h-14">
                        </a>
                    </div>

                    <nav class="hidden md:flex items-center space-x-4 lg:space-x-6 xl:space-x-8 text-sm md:text-base xl:text-lg transition-colors duration-300">
                        <a href="index.php" class="nav-link text-black">Home</a>
                        <a href="about.php" class="nav-link text-black">About Us</a>

                        <div class="relative group" id="products-dropdown">
                            <a href="products.php" class="nav-link text-black flex items-center">
                                Products
                                <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                            </a>
                            <div id="products-menu"
                                class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-6xl bg-white shadow-xl rounded-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-8">
                                    <div class="grid grid-cols-5 gap-8">

                                        <!-- Column 1: Tiles & Mosaics -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">Tiles & Mosaics</h3>
                                            <div class="space-y-2">
                                                <a href="tiles.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Tiles
                                                </a>
                                                <a href="mosaics.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Mosaics
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Column 2: Stones -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">Natural Stones & Engineered Stones</h3>
                                            <div class="space-y-2">
                                                <a href="natural-stones.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Natural Stones
                                                </a>
                                                <a href="engineered-stones.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Engineered Stones
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Column 3: Adhesive & Grout -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">Adhesive & Grout & Industrial Flooring</h3>
                                            <div class="space-y-2">
                                                <a href="adhesives.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>View More
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Column 4: Engineering Services -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">Engineering Services</h3>
                                            <div class="space-y-2">
                                                <a href="engineering-services.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>View More
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Column 5: Complete Bathroom Solutions -->
                                        <div class="space-y-4">
                                            <h3 class="text-base font-bold text-gray-800 border-b-2 border-red-900 pb-2">Complete Bathroom Solutions</h3>
                                            <div class="space-y-2">
                                                <a href="sanitaryware.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Sanitaryware
                                                </a>
                                                <a href="faucets-showers.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Faucets & Showers
                                                </a>
                                                <a href="water-heater.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Water Heater
                                                </a>
                                                <a href="wellness.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Wellness
                                                </a>
                                                <a href="washroom-accessories.php" class="block text-sm text-gray-600 hover:text-yellow-600 transition-all duration-200 py-1">
                                                    <i class="fas fa-chevron-right mr-2 text-xs text-yellow-500"></i>Washroom Accessories
                                                </a>
                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>

                        <a href="projects.php" class="nav-link text-black">Projects</a>
                        <a href="services.php" class="nav-link text-black">Services</a>
                        <a href="blogs.php" class="nav-link text-black">Blogs</a>
                        <a href="contact.php" class="nav-link text-black">Contact</a>
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="bg-white text-black text-sm px-3 py-1 pr-8 rounded-full focus:outline-none">
                            <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-500 text-sm"></i>
                            </div>
                        </div>
                    </nav>

                    <div class="md:hidden">
                        <button id="mobile-menu-toggle" class="text-black text-2xl focus:outline-none">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t border-black opacity-20" id="top-border"></div>

            <div id="mobile-menu" class="md:hidden bg-white text-black px-4 py-4 hidden">
                <div>
                    <a href="index.php" class="block py-2 hover:text-yellow-400 font-medium">Home</a>
                    <a href="about.php" class="block py-2 hover:text-yellow-400 font-medium">About Us</a>

                    <div class="block">
                        <button id="mobile-products-btn" class="w-full text-left py-2 hover:text-red-900 font-medium flex items-center justify-between focus:outline-none">
                            <span>Products</span>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200" id="mobile-products-arrow"></i>
                        </button>
                        <div id="mobile-products-menu" class="ml-4 mt-1 space-y-1 max-h-0 overflow-hidden transition-all duration-300">

                            <div>
                                <button class="mobile-submenu-btn w-full text-left py-1 text-sm text-gray-600 hover:text-red-900 flex items-center justify-between focus:outline-none" data-target="mobile-tiles-menu">
                                    <span>Tiles</span>
                                    <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-tiles-menu" class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                                    <a href="tiles.php" class="block py-1 text-xs text-black hover:text-red-900">Standard Range</a>
                                    <a href="Mosaics.php" class="block py-1 text-xs text-black hover:text-red-900">Project Range</a>
                                </div>
                            </div>

                            <div>
                                <button class="mobile-submenu-btn w-full text-left py-1 text-sm text-gray-600 hover:text-red-900 flex items-center justify-between focus:outline-none" data-target="mobile-mosaics-menu">
                                    <span>Mosaics</span>
                                    <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-mosaics-menu" class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                                    <a href="mosaics-glass.php" class="block py-1 text-xs text-black hover:text-red-900">Designer Range</a>
                                    <a href="mosaics-project.php" class="block py-1 text-xs text-black hover:text-red-900">Project Range</a>
                                </div>
                            </div>

                            <div>
                                <button class="mobile-submenu-btn w-full text-left py-1 text-sm text-gray-600 hover:text-red-900 flex items-center justify-between focus:outline-none" data-target="mobile-stones-menu">
                                    <span>Natural Stones</span>
                                    <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-stones-menu" class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                                    <a href="natural-stones.php" class="block py-1 text-xs text-black hover:text-red-900">Natural Stones</a>
                                    <a href="engineered-stones.php" class="block py-1 text-xs text-black hover:text-red-900">Engineered Stones</a>
                                    <a href="adhesives.php" class="block py-1 text-xs text-black hover:text-red-900">Adhesive & Grout & Industrial Flooring</a>
                                    <a href="engineering-services.php" class="block py-1 text-xs text-black hover:text-red-900">Engineering Services</a>
                                </div>
                            </div>

                            <div>
                                <button class="mobile-submenu-btn w-full text-left py-1 text-sm text-gray-600 hover:text-red-900 flex items-center justify-between focus:outline-none" data-target="mobile-solutions-menu">
                                    <span>Complete Bathroom Solutions</span>
                                    <i class="fas fa-chevron-down text-xs mobile-submenu-arrow"></i>
                                </button>
                                <div id="mobile-solutions-menu" class="ml-4 space-y-1 max-h-0 overflow-hidden transition-all duration-300">
                                    <a href="sanitaryware.php" class="block py-1 text-xs text-black hover:text-red-900">Sanitaryware</a>
                                    <a href="faucets-showers.php" class="block py-1 text-xs text-black hover:text-red-900">Faucets & Showers</a>
                                    <a href="water-heater.php" class="block py-1 text-xs text-black hover:text-red-900">Water Heater</a>
                                    <a href="wellness.php" class="block py-1 text-xs text-black hover:text-red-900">Wellness</a>
                                    <a href="washroom-accessories.php" class="block py-1 text-xs text-black hover:text-red-900">Washroom Accessories</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="projects.php" class="block py-2 hover:text-yellow-400 font-medium">Projects</a>
                    <a href="services.php" class="block py-2 hover:text-yellow-400 font-medium">Services</a>
                    <a href="blogs.php" class="block py-2 hover:text-yellow-400 font-medium">Blogs</a>
                    <a href="contact.php" class="block py-2 hover:text-yellow-400 font-medium">Contact</a>
                    <div class="mt-4">
                        <input type="text" placeholder="Search..." class="w-full bg-gray-100 text-black px-3 py-2 rounded focus:outline-none">
                    </div>
                </div>
            </div>
        </header>
    </div>

    <style>
        .sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
            visibility: visible;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const header = document.getElementById('main-header');
            const mobileProductsBtn = document.getElementById('mobile-products-btn');
            const mobileProductsMenu = document.getElementById('mobile-products-menu');
            const mobileProductsArrow = document.getElementById('mobile-products-arrow');
            const mobileSubmenuButtons = document.querySelectorAll('.mobile-submenu-btn');
            let isSticky = false;

            toggleBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            mobileProductsBtn.addEventListener('click', () => {
                const isExpanded = mobileProductsMenu.style.maxHeight && mobileProductsMenu.style.maxHeight !== '0px';
                if (isExpanded) {
                    mobileProductsMenu.style.maxHeight = '0px';
                    mobileProductsArrow.classList.remove('rotate-180');
                    mobileSubmenuButtons.forEach(btn => {
                        const targetId = btn.getAttribute('data-target');
                        const submenu = document.getElementById(targetId);
                        const arrow = btn.querySelector('.mobile-submenu-arrow');
                        if (submenu) submenu.style.maxHeight = '0px';
                        if (arrow) arrow.classList.remove('rotate-180');
                    });
                } else {
                    mobileProductsMenu.style.maxHeight = mobileProductsMenu.scrollHeight + 'px';
                    mobileProductsArrow.classList.add('rotate-180');
                }
            });

            mobileSubmenuButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const targetId = btn.getAttribute('data-target');
                    const submenu = document.getElementById(targetId);
                    const arrow = btn.querySelector('.mobile-submenu-arrow');

                    if (submenu) {
                        const isExpanded = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';

                        // Collapse all other submenus
                        mobileSubmenuButtons.forEach(otherBtn => {
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
                        mobileSubmenuButtons.forEach(otherBtn => {
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

            window.addEventListener('scroll', () => {
                if (window.scrollY > 100 && !isSticky) {
                    header.classList.add('sticky-header');
                    document.body.style.paddingTop = header.offsetHeight + 'px';
                    isSticky = true;
                } else if (window.scrollY <= 100 && isSticky) {
                    header.classList.remove('sticky-header');
                    document.body.style.paddingTop = '0px';
                    isSticky = false;
                }
            });

            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>