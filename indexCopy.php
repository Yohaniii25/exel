<?php
require_once 'admin/includes/db.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT id, name, image FROM projects ORDER BY id DESC LIMIT 8";
$result = $conn->query($query);

$categories_query = $conn->query("SELECT id, name FROM categories ORDER BY id ASC");
$categories = [];
while ($row = $categories_query->fetch_assoc()) {
    $categories[] = $row;
}
?>


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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />



    <style>
        .pt-9 {
            padding-top: 20rem;
        }
    </style>

</head>

<body>

    <?php require(__DIR__  . '/includes/header.php'); ?>


    <section class="w-full relative">

        <div class="swiper hero-swiper h-[80vh] md:h-[100vh]">
            <div class="swiper-wrapper">

                <div class="swiper-slide relative">
                    <img src="./assets/img/home_slider.jpg" alt="Slide 1" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Where comfort and design beautifully come together</h1>
                        <p class="text-lg md:text-xl max-w-xl">
                            Experience the perfect balance of elegance and ease, where every piece is crafted to bring both style and comfort into your home.
                        </p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Explore More</a>
                    </div>
                </div>

                <div class="swiper-slide relative">
                    <img src="./assets/img/slider22.jpg" alt="Slide 2" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Modern Tiles Collection</h1>
                        <p class="text-lg md:text-xl mb-6">Elegance & durability in every detail</p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Shop Now</a>
                    </div>
                </div>


                <div class="swiper-slide relative">
                    <img src="./assets/img/slider33.jpg" alt="Slide 3" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl xl:text-6xl 2xl:text-7xl font-bold leading-tight mb-4">Sanitaryware & Faucets</h1>
                        <p class="text-lg md:text-xl mb-6">Premium solutions for your modern bathroom</p>
                        <a href="#" class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">Shop Now</a>
                    </div>
                </div>
            </div>

            <!-- Swiper Controls -->
            <div class="swiper-button-next !text-white"></div>
            <div class="swiper-button-prev !text-white"></div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const heroSwiper = new Swiper(".hero-swiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 1000,
        });
    </script>


    <section class="bg-white text-black py-16 px-4 md:px-12 bg-cover bg-center bg-no-repeat"
        style="background-image: url('./assets/img/bg-product.jpg'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic3.jpg');" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Natural Stones</h3>
                    <p class="text-sm">Imported premium Natural Stones for luxury interiors.</p>
                </div>
            </div>


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic1.jpg');" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Engineering Stones</h3>
                    <p class="text-sm">Durable Engineering Stones for modern surfaces.</p>
                </div>
            </div>


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic2.jpg');" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Tiles & Mosaics</h3>
                    <p class="text-sm">Creative tiling options from across the globe.</p>
                </div>
            </div>


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic4.jpg');" data-aos="fade-up" data-aos-delay="400">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Complete Bathroom Solutions</h3>
                    <p class="text-sm">High-quality fittings for elegant bathrooms.</p>
                </div>
            </div>


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/topic5.jpg');" data-aos="fade-up" data-aos-delay="500">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Engineering Services</h3>
                    <p class="text-sm">Explore our work across Sri Lanka & Maldives.</p>
                </div>
            </div>


            <div class="relative h-72 bg-cover bg-center rounded-xl shadow-md overflow-hidden"
                style="background-image: url('./assets/img/wellness.jpg');" data-aos="fade-up" data-aos-delay="600">
                <div class="absolute bottom-0 bg-black bg-opacity-60 w-full p-4 text-center text-white">
                    <h3 class="text-xl font-bold">Industrial Flooring</h3>
                    <p class="text-sm">Adhesive , Grout and Industrial Flooring</p>
                </div>
            </div>

        </div>
    </section>


    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>


    <section class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 bg-white">

        <div class="relative aspect-square bg-cover bg-center flex items-end"
            style="background-image: url('./assets/img/rec_1.jpg');">
            <div class="text-black w-full pb-8 pt-9 px-4 text-center bg-gradient-to-t from-black/60 to-transparent mr-3px">
                <h2 class="text-3xl font-bold mb-2">Complete Bathroom Solutions</h2>
                <p class="mb-4">Transform your space into a sanctuary of style and comfort</p>
                <a href="./sanitaryware.php" class="bg-white text-black font-semibold px-6 py-2 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                    View More
                </a>
            </div>
        </div>


        <div class="relative aspect-square bg-cover bg-center flex items-end"
            style="background-image: url('./assets/img/2224.jpg');">
            <div class="text-black w-full pb-8 pt-9 px-4 text-center bg-gradient-to-t from-black/60 to-transparent ml-3px">
                <h2 class="text-3xl font-bold mb-2">Tiles, Mosaics & Natural Stones</h2>
                <p class="mb-4">Where texture, color, and craftsmanship meet timeless design</p>
                <a href="./tiles-standard.php" class="bg-white text-black font-semibold px-6 py-2 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                    View More
                </a>
            </div>
        </div>
    </section>

    <section class="bg-white text-black py-16 px-4 md:px-12 lg:px-1 xl:px-16">
        <div class="max-w-[1700px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">

            <div class="flex flex-col justify-center">
                <h4 class="text-sm text-gray-500 uppercase mb-2 tracking-wide">Our Range</h4>
                <h2 class="text-3xl font-bold mb-4 text-gray-900">Explore Product Categories</h2>
                <p class="mb-6 text-gray-600 leading-relaxed">Browse through our finest selections crafted to match every aesthetic and functionality need for your space.</p>
                <button class="bg-black text-white px-6 py-3 rounded-full hover:bg-gray-800 transition-colors duration-300 font-medium">
                    Explore All
                </button>
            </div>


            <div class="col-span-2">

                <div class="flex flex-wrap gap-4 border-b border-gray-200 mb-6">
                    <button onclick="showTab('Tiles')" id="Tiles-tab" class="pb-3 px-1 border-b-2 border-black font-semibold text-black transition-colors">Tiles</button>
                    <button onclick="showTab('Mosaics')" id="Mosaics-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Mosaics</button>
                    <button onclick="showTab('NaturalStones')" id="NaturalStones-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Natural Stones</button>
                    <button onclick="showTab('EngineeredStones')" id="EngineeredStones-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Engineered Stones</button>
                    <button onclick="showTab('TapsFaucets')" id="TapsFaucets-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Taps & Faucets</button>
                    <button onclick="showTab('Sanitaryware')" id="Sanitaryware-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Sanitaryware</button>
                    <button onclick="showTab('Wellness')" id="Wellness-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Wellness</button>
                    <button onclick="showTab('ShowerSolutions')" id="ShowerSolutions-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Shower Solutions</button>
                    <button onclick="showTab('Adhesives')" id="Adhesives-tab" class="pb-3 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 transition-colors">Adhesives, Grouts & Industrial Flooring</button>
                </div>


                <div class="min-h-[400px]">
                    <div id="Tiles-content"></div>
                    <div id="Mosaics-content" class="hidden"></div>
                    <div id="NaturalStones-content" class="hidden"></div>
                    <div id="EngineeredStones-content" class="hidden"></div>
                    <div id="TapsFaucets-content" class="hidden"></div>
                    <div id="Sanitaryware-content" class="hidden"></div>
                    <div id="Wellness-content" class="hidden"></div>
                    <div id="ShowerSolutions-content" class="hidden"></div>
                    <div id="Adhesives-content" class="hidden"></div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const categories = {
            "Tiles": [{
                    img: "./assets/img/products/1.jpeg",
                    title: "Absolute",
                    desc: "Beautiful floor tile."
                },
                {
                    img: "./assets/img/products/2.jpeg",
                    title: "Delight",
                    desc: "Elegant wall tile."
                },
                {
                    img: "./assets/img/products/3.jpeg",
                    title: "Bio Select",
                    desc: "Premium outdoor tile."
                }
            ],
            "Mosaics": [{
                    img: "./assets/img/products/10.jpg",
                    title: "Blue Dot Mix",
                    desc: "Stylish mosaic pattern."
                },
                {
                    img: "./assets/img/products/11.jpg",
                    title: "Cement Lustre",
                    desc: "Modern mosaic style."
                },
                {
                    img: "./assets/img/products/12.jpg",
                    title: "Hawai Blue Blend",
                    desc: "Classic mosaic look."
                }
            ],
            "NaturalStones": [{
                    img: "./assets/img/products/4.jpg",
                    title: "Marble",
                    desc: "Granite slab."
                },
                {
                    img: "./assets/img/products/5.jpg",
                    title: "Granite",
                    desc: "Marble countertop."
                },
                {
                    img: "./assets/img/products/6.jpg",
                    title: "Sinks",
                    desc: "Limestone tile."
                }
            ],
            "EngineeredStones": [{
                    img: "./assets/img/products/13.jpg",
                    title: "Engineering Marble",
                    desc: "Quartz surface."
                },
                {
                    img: "./assets/img/products/14.jpg",
                    title: "Engineered Quartz",
                    desc: "Composite stone."
                },
                {
                    img: "./assets/img/products/15.jpg",
                    title: "Engineered Stone 3",
                    desc: "Modern engineered slab."
                }
            ],
            "TapsFaucets": [{
                    img: "./assets/img/products/16.jpg",
                    title: "Basin Area",
                    desc: "Modern chrome faucet."
                },
                {
                    img: "./assets/img/products/17.jpg",
                    title: "Blush Sensor",
                    desc: "Luxury gold tap."
                },
                {
                    img: "./assets/img/products/18.jpg",
                    title: "Arc",
                    desc: "Matte black faucet."
                }
            ],
            "Sanitaryware": [{
                    img: "./assets/img/products/7.jpeg",
                    title: "Sanitaryware",
                    desc: "Modern wash basin."
                },
                {
                    img: "./assets/img/products/8.jpeg",
                    title: "Bath Accessories",
                    desc: "Classic ceramic sink."
                },
                {
                    img: "./assets/img/products/9.jpeg",
                    title: "Sanitaryware Accessories",
                    desc: "Luxury sanitary set."
                }
            ],
            "Wellness": [{
                    img: "./assets/img/products/22.jpg",
                    title: "Whirlpools",
                    desc: "Jacuzzi bathtub."
                },
                {
                    img: "./assets/img/products/23.jpg",
                    title: "Bathtubs",
                    desc: "Luxury sauna."
                },
                {
                    img: "./assets/img/products/24.jpg",
                    title: "Bathtub Accessories",
                    desc: "Steam shower cabin."
                }
            ],
            "ShowerSolutions": [{
                    img: "./assets/img/products/19.jpg",
                    title: "Bathroom Showers",
                    desc: "Rain shower head."
                },
                {
                    img: "./assets/img/products/20.png",
                    title: "Shower Enclosures",
                    desc: "Glass shower enclosure."
                },
                {
                    img: "./assets/img/products/21.jpg",
                    title: "Shower Panels",
                    desc: "Luxury shower panel."
                }
            ],
            "Adhesives": [{
                    img: "./assets/img/products/4.jpg",
                    title: "Industrial Adhesive",
                    desc: "Strong bonding solution."
                },
                {
                    img: "./assets/img/products/5.jpg",
                    title: "Premium Grout",
                    desc: "Durable tile grout."
                },
                {
                    img: "./assets/img/products/6.jpg",
                    title: "Flooring Mix",
                    desc: "Industrial flooring mix."
                }
            ]
        };

        function showTab(tabName) {
            Object.keys(categories).forEach(name => {
                const tab = document.getElementById(`${name}-tab`);
                const content = document.getElementById(`${name}-content`);
                if (name === tabName) {
                    tab.classList.add("border-black", "text-black", "font-semibold");
                    tab.classList.remove("border-transparent", "text-gray-500", "font-medium");
                    content.classList.remove("hidden");
                } else {
                    tab.classList.remove("border-black", "text-black", "font-semibold");
                    tab.classList.add("border-transparent", "text-gray-500", "font-medium");
                    content.classList.add("hidden");
                }
            });
        }


        Object.keys(categories).forEach(category => {
            const container = document.getElementById(`${category}-content`);
            const grid = document.createElement("div");
            grid.className = "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6";

            categories[category].forEach(product => {
                const card = document.createElement("div");
                card.className = "bg-gray-50 p-4 rounded-lg hover:shadow-md transition-shadow";
                card.innerHTML = `
        <div class="w-full h-48 bg-gray-200 rounded mb-3 overflow-hidden flex items-center justify-center">
          <img src="${product.img}" alt="${product.title}" class="object-cover h-full w-full" />
        </div>
        <h3 class="font-semibold text-gray-900 mb-1">${product.title}</h3>
        <p class="text-sm text-gray-600">${product.desc}</p>
      `;
                grid.appendChild(card);
            });

            container.appendChild(grid);
        });


        showTab('Tiles');
    </script>


    <section class="w-full py-16 px-4 md:px-12  bg-white">
        <div class="max-w-full mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 items-center lg:px-1">

            <div class="text-center">
                <img src="./assets/img/texture2.png" alt="Product Image 1" class="w-full h-64 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Stylish Kitchens</h3>
                <p class="text-gray-600">Elevate your cooking space with modern finishes and thoughtful design.</p>
            </div>

            <div class="text-center">
                <img src="./assets/img/texture3.png" alt="Product Image 2" class="w-full h-64 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Elegant Flooring</h3>
                <p class="text-gray-600">Bring warmth and style to your rooms with high-quality flooring options.</p>
            </div>

            <div class="relative text-center md:text-left">
                <h4 class="text-sm text-yellow-500 uppercase mb-2 tracking-wider">Experience the perfect</h4>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Created With Nature</h2>
                <p class="text-gray-600 mb-6">Experience the perfect balance of elegance and ease, where every piece </p>
                <button style="background-color: #E6DAC9; font-weight:600;" class="text-black px-6 py-3 rounded-full hover:opacity-90 transition duration-300">
                    Explore All
                </button>


            </div>

        </div>
    </section>

    <section class="w-full bg-white py-16 px-4 md:px-12">

        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Top Picks You'll Love</h2>
            <p class="text-gray-600 mt-2">Fresh Styles Just in! Elevate your look</p>
        </div>

        <div class="relative">
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car1.png" alt="Product 1" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Natural Stones</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car2.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Tiles</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car1.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Mosaics</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car2.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Engineering Stones</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car1.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Taps & Faucets</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car2.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Sanitaryware</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car1.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Wellness</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>


                    <div class="swiper-slide">
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <img src="./assets/img/car2.png" alt="Product 2" class="w-full h-64 object-cover">
                            <div class="p-4 text-center">
                                <h3 class="text-lg font-semibold text-gray-900">Shower Solutions</h3>
                                <p class="text-gray-600 mt-1">Rs. 15,000.00</p>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="swiper-button-next text-gray"></div>
                <div class="swiper-button-prev text-gray"></div>
            </div>
        </div>
    </section>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper(".product-swiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                },
                1440: {
                    slidesPerView: 4
                }
            }
        });
    </script>

    <section class="w-full bg-white py-16 px-4 md:px-12">
        <h2 class="text-3xl md:text-4xl font-bold text-black text-center mb-4">Our Projects</h2>
        <p class="text-center text-gray-600 mb-12">Crafted spaces that speak volumes.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="relative group h-64 overflow-hidden rounded-lg shadow">
                    <img src="./admin/<?php echo htmlspecialchars($row['image']); ?>"
                        alt="<?php echo htmlspecialchars($row['name']); ?>"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <h3 class="text-white text-lg font-semibold mb-2">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </h3>
                        <a href="project.php?id=<?php echo urlencode($row['id']); ?>"
                            class="bg-white text-black px-4 py-2 rounded-full text-sm hover:bg-gray-200 transition">
                            View More
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>




    <?php require(__DIR__  . '/includes/footer.php'); ?>
</body>

</html>