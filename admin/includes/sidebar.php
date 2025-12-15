<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exel Holdings </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .submenu-slide {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            overflow: hidden;
        }

        .submenu-slide.hidden {
            max-height: 0;
            opacity: 0;
        }

        .submenu-slide.visible {
            max-height: 200px;
            opacity: 1;
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(139, 69, 19, 0.1), transparent);
            transition: left 0.5s;
        }

        .nav-item:hover::before {
            left: 100%;
        }

        .logo-container {
            background: linear-gradient(135deg, #8B4513, #A0522D);
        }

        .active-item {
            background: linear-gradient(135deg, #8B4513, #A0522D);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
        }

        .submenu-item:hover {
            transform: translateX(8px);
        }
    </style>
</head>

<body class="bg-gray-100">

    <aside class="fixed top-0 left-0 h-screen w-64 bg-white shadow-2xl flex flex-col z-50 border-r border-gray-200">


        <div class="logo-container p-6 border-b border-gray-200">
            <div class="bg-white rounded-lg p-3 shadow-md">
                <div class="flex items-center justify-center">
                    <i class="fas fa-building text-3xl text-amber-600"></i>
                    <span class="ml-2 text-xl font-bold text-gray-800">Admin</span>
                </div>
            </div>
        </div>


        <nav class="flex-1 p-4 overflow-y-auto">
            <ul class="space-y-2">

                <li class="nav-item">
                    <a href="dashboard.php"
                        class="flex items-center p-3 rounded-xl hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-amber-700 sidebar-transition group active-item">
                        <div class="flex items-center justify-center w-10 h-10 bg-amber-100 rounded-lg group-hover:bg-amber-200 sidebar-transition">
                            <i class="fas fa-home text-amber-600"></i>
                        </div>
                        <span class="ml-3 font-medium">Dashboard</span>
                        <div class="ml-auto opacity-0 group-hover:opacity-100 sidebar-transition">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <button onclick="toggleSubMenu('projectsMenu')"
                        class="flex items-center justify-between w-full p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 sidebar-transition group">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg group-hover:bg-blue-200 sidebar-transition">
                                <i class="fas fa-briefcase text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Projects</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="projectsChevron"></i>
                    </button>

                    <ul id="projectsMenu" class="ml-6 mt-2 space-y-1 submenu-slide hidden">
                        <li>
                            <a href="?page=add_project" class="flex items-center p-2 rounded-lg hover:bg-blue-50 hover:text-blue-700">
                                <i class="fas fa-plus w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Add Project</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=project_list" class="flex items-center p-2 rounded-lg hover:bg-blue-50 hover:text-blue-700">
                                <i class="fas fa-list w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Project List</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <button onclick="toggleSubMenu('productsMenu')"
                        class="flex items-center justify-between w-full p-3 rounded-xl hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 sidebar-transition group">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg group-hover:bg-green-200 sidebar-transition">
                                <i class="fas fa-box text-green-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Products</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="productsChevron"></i>
                    </button>

                    <ul id="productsMenu" class="ml-6 mt-2 space-y-1 submenu-slide hidden">
                        <li>
                            <a href="?page=add_product" class="flex items-center p-2 rounded-lg hover:bg-green-50 hover:text-green-700">
                                <i class="fas fa-plus w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Add Product</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=product_list" class="flex items-center p-2 rounded-lg hover:bg-green-50 hover:text-green-700">
                                <i class="fas fa-list w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Product List</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=add_category_description" class="flex items-center p-2 rounded-lg hover:bg-blue-50 hover:text-blue-700">
                                <i class="fas fa-plus w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Add Category Description</span>
                            </a>
                        </li>
                    </ul>
                </li>

        
                <li class="nav-item">
                    <button onclick="toggleSubMenu('jaquarMenu')"
                        class="flex items-center justify-between w-full p-3 rounded-xl hover:bg-gradient-to-r hover:from-purple-50 hover:to-violet-50 hover:text-purple-700 sidebar-transition group">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-10 h-10 bg-purple-100 rounded-lg group-hover:bg-purple-200 sidebar-transition">
                                <i class="fas fa-shower text-purple-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Jaquar</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform duration-300" id="jaquarChevron"></i>
                    </button>

                    <ul id="jaquarMenu" class="ml-6 mt-2 space-y-1 submenu-slide hidden">

                        <li>
                            <a href="?page=add_jaquar_product" class="flex items-center p-2 rounded-lg hover:bg-purple-50 hover:text-purple-700">
                                <i class="fas fa-plus w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Add Jaquar Product</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=jaquar_products" class="flex items-center p-2 rounded-lg hover:bg-purple-50 hover:text-purple-700">
                                <i class="fas fa-list w-5 text-sm text-gray-400"></i>
                                <span class="ml-2 text-sm">Jaquar Product List</span>
                            </a>
                        </li>
                    </ul>
                </li>

        


            </ul>
        </nav>


        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center p-3 mb-2 bg-white rounded-lg shadow-sm">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">Admin User</p>
                    <p class="text-xs text-gray-500">admin@company.com</p>
                </div>
            </div>

            <a href="logout.php"
                class="flex items-center p-3 rounded-xl text-red-600 hover:bg-red-50 hover:text-red-700">
                <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-lg group-hover:bg-red-200">
                    <i class="fas fa-sign-out-alt text-red-600"></i>
                </div>
                <span class="ml-3 font-medium">Logout</span>
                <div class="ml-auto opacity-0 group-hover:opacity-100">
                    <i class="fas fa-arrow-right text-sm"></i>
                </div>
            </a>
        </div>
    </aside>

    <script>
        function toggleSubMenu(id) {
            const menu = document.getElementById(id);
            const chevron = document.getElementById(id.replace('Menu', 'Chevron'));

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                chevron.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                chevron.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>

</html>