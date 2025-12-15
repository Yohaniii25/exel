<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Navigation Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        <a href="products2.php" class="nav-link text-black flex items-center">
                            Products
                            <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                        </a>
                        <div id="products-menu" class="absolute top-full left-0 mt-2 w-64 bg-white shadow-lg rounded-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="py-2">
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
                    <a href="projects.php" class="nav-link text-black">Projects</a>
                    <a href="services.php" class="nav-link text-black">Services</a>
                    <a href="gallery.php" class="nav-link text-black">Gallery</a>
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


<!-- Sticky CSS -->
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

    /* Ensure dropdown stays visible when hovering over submenu */
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
        visibility: visible;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("mobile-menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");
        const headerWrapper = document.getElementById("sticky-header-wrapper");
        const mobileProductsBtn = document.getElementById("mobile-products-btn");
        const mobileProductsMenu = document.getElementById("mobile-products-menu");
        const mobileProductsArrow = document.getElementById("mobile-products-arrow");
        let isSticky = false;

        // Mobile menu toggle
        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener("click", () => {
                mobileMenu.classList.toggle("hidden");
            });
        }

        // Mobile products menu toggle
        if (mobileProductsBtn && mobileProductsMenu && mobileProductsArrow) {
            mobileProductsBtn.addEventListener("click", (e) => {
                e.preventDefault();
                const isExpanded = mobileProductsMenu.classList.contains("max-h-[500px]");
                mobileProductsMenu.classList.toggle("max-h-0", isExpanded);
                mobileProductsMenu.classList.toggle("max-h-[500px]", !isExpanded);
                mobileProductsArrow.classList.toggle("rotate-180");
            });
        }

        // Mobile submenu toggles
        document.querySelectorAll(".mobile-submenu-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                const targetId = btn.getAttribute("data-target");
                const submenu = document.getElementById(targetId);
                const arrow = btn.querySelector(".mobile-submenu-arrow");

                if (submenu) {
                    const isExpanded = submenu.classList.contains("max-h-[500px]");
                    submenu.classList.toggle("max-h-0", isExpanded);
                    submenu.classList.toggle("max-h-[500px]", !isExpanded);
                    arrow.classList.toggle("rotate-180");

                    // Recalculate parent menu height
                    if (mobileProductsMenu) {
                        mobileProductsMenu.style.maxHeight = isExpanded ?
                            `${mobileProductsMenu.scrollHeight}px` :
                            `${mobileProductsMenu.scrollHeight + submenu.scrollHeight}px`;
                    }
                }
            });
        });

        // Sticky header
        if (headerWrapper) {
            window.addEventListener("scroll", () => {
                if (window.scrollY > 100 && !isSticky) {
                    headerWrapper.classList.add("sticky-header");
                    document.body.style.paddingTop = `${headerWrapper.offsetHeight}px`;
                    isSticky = true;
                } else if (window.scrollY <= 100 && isSticky) {
                    headerWrapper.classList.remove("sticky-header");
                    document.body.style.paddingTop = "0px";
                    isSticky = false;
                }
            });
        }

        // Close mobile menu when clicking outside
        if (mobileMenu && toggleBtn) {
            document.addEventListener("click", (e) => {
                if (!mobileMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    mobileMenu.classList.add("hidden");
                }
            });
        }

        // Desktop dropdown handling for better cross-device compatibility
        const productsDropdown = document.getElementById("products-dropdown");
        const productsMenu = document.getElementById("products-menu");
        let dropdownTimeout;

        if (productsDropdown && productsMenu) {
            // Mouse enter - show dropdown
            productsDropdown.addEventListener("mouseenter", () => {
                clearTimeout(dropdownTimeout);
                productsMenu.classList.remove("opacity-0", "invisible");
                productsMenu.classList.add("opacity-100", "visible");
            });

            // Mouse leave - hide dropdown with delay
            productsDropdown.addEventListener("mouseleave", () => {
                dropdownTimeout = setTimeout(() => {
                    productsMenu.classList.add("opacity-0", "invisible");
                    productsMenu.classList.remove("opacity-100", "visible");
                }, 150);
            });

            // Handle submenu hover
            document.querySelectorAll("[class*='group/sub']").forEach((submenuItem) => {
                const submenu = submenuItem.querySelector("div");
                if (submenu) {
                    let submenuTimeout;

                    submenuItem.addEventListener("mouseenter", () => {
                        clearTimeout(submenuTimeout);
                        submenu.classList.remove("opacity-0", "invisible");
                        submenu.classList.add("opacity-100", "visible");
                    });

                    submenuItem.addEventListener("mouseleave", () => {
                        submenuTimeout = setTimeout(() => {
                            submenu.classList.add("opacity-0", "invisible");
                            submenu.classList.remove("opacity-100", "visible");
                        }, 150);
                    });
                }
            });

            // Click handling for touch devices
            const mainProductsLink = productsDropdown.querySelector("a");
            if (mainProductsLink) {
                mainProductsLink.addEventListener("click", (e) => {
                    // Only prevent default if it's a touch device and menu is closed
                    if (window.matchMedia("(hover: none)").matches) {
                        const isMenuVisible = productsMenu.classList.contains("opacity-100");
                        if (!isMenuVisible) {
                            e.preventDefault();
                            productsMenu.classList.remove("opacity-0", "invisible");
                            productsMenu.classList.add("opacity-100", "visible");
                        }
                    }
                });
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (productsDropdown && !productsDropdown.contains(e.target)) {
                if (productsMenu) {
                    productsMenu.classList.add("opacity-0", "invisible");
                    productsMenu.classList.remove("opacity-100", "visible");
                }
            }
        });
    });
</script>

</body>
</html>