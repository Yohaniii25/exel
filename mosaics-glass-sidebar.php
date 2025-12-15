<?php
require_once(__DIR__ . '/admin/includes/db.php');

if (!isset($conn)) {
    $db = new Database();
    $conn = $db->getConnection();
}

if (!function_exists('slugify')) {
    function slugify($text) {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower($text));
        $text = trim($text, '-');
        return $text;
    }
}

$subQry = "SELECT * FROM categories WHERE parent_id = 27 ORDER BY name ASC";
$subRes = $conn->query($subQry);
?>

<style>
.sidebar-item {
    opacity: 0;
    transform: translateX(-20px);
    animation: slideInLeft 0.6s ease-out forwards;
}

.sidebar-item:nth-child(1) {
    animation-delay: 0.1s;
}

.sidebar-item:nth-child(2) {
    animation-delay: 0.2s;
}

.sidebar-item:nth-child(3) {
    animation-delay: 0.3s;
}

.sidebar-item:nth-child(4) {
    animation-delay: 0.4s;
}

.sidebar-item:nth-child(5) {
    animation-delay: 0.5s;
}

.sidebar-item:nth-child(6) {
    animation-delay: 0.6s;
}

.sidebar-item:nth-child(7) {
    animation-delay: 0.7s;
}

.sidebar-item:nth-child(8) {
    animation-delay: 0.8s;
}

@keyframes slideInLeft {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.subcategory-item {
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    background: #edecec;
    border-radius: 12px;
    margin-bottom: 8px;
}

.subcategory-item:hover {
    transform: translateX(8px);
    background: #b4a4a4ff;
    box-shadow: 0 6px 20px rgba(107, 107, 107, 0.15);
}

.subcategory-item.selected {
    background: #b4a4a4ff;
    transform: translateX(8px);
    box-shadow: 0 8px 25px rgba(231, 231, 231, 0.3);
    color: #ffffffff;
}

.subcategory-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 4px;
    height: 0;

    transform: translateY(-50%);
    transition: height 0.3s ease;
    border-radius: 0 8px 8px 0;
}

.subcategory-item:hover::before,
.subcategory-item.selected::before {
    height: 70%;
}

.product-item {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
    animation: productEntrance 0.8s ease-out forwards;
}

.product-item:nth-child(1) {
    animation-delay: 0.1s;
}

.product-item:nth-child(2) {
    animation-delay: 0.2s;
}

.product-item:nth-child(3) {
    animation-delay: 0.3s;
}

.product-item:nth-child(4) {
    animation-delay: 0.4s;
}

.product-item:nth-child(5) {
    animation-delay: 0.5s;
}

.product-item:nth-child(6) {
    animation-delay: 0.6s;
}

@keyframes productEntrance {
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.header-gradient {
    background: linear-gradient(90deg, #254983ff, #1d4ed8, #1e40af);
    background-size: 200% 100%;
    animation: gradientShift 3s ease-in-out infinite;
}

@keyframes gradientShift {

    0%,
    100% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }
}

.selected-pulse {
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.02);
    }
}

#sidebar {
    backdrop-filter: blur(12px);
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
    border-right: 1px solid #cbd5e1;
}

#sidebar-overlay {
    backdrop-filter: blur(2px);
}

.sidebar-header {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-bottom: 1px solid #e2e8f0;
    border-radius: 0 0 16px 16px;
    margin-bottom: 16px;
}

.sidebar-content {
    background: transparent;
}
</style>

<div id="sidebar"
    class="fixed lg:static inset-y-0 left-0 w-80 z-30 shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto rounded-r-2xl">

    <div class="lg:hidden flex justify-end p-4 sidebar-header">
        <button id="sidebar-close" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="p-6 sidebar-content">
        <div class="sidebar-header p-4 -m-4 mb-4">
            <h3 class="text-xl font-bold text-gray-800 mb-3 sidebar-item">Tiles - Standard Range</h3>
            <div class="w-16 h-1 header-gradient rounded-full sidebar-item"></div>
        </div>

        <div class="space-y-3 mt-6">
            <?php $index = 0; while ($sub = $subRes->fetch_assoc()): $index++; ?>
            <div class="subcategory-item sidebar-item relative flex items-center p-4 cursor-pointer"
                onclick="selectCategory(<?= (int)$sub['id'] ?>, this)" data-subcat-id="<?= (int)$sub['id'] ?>"
                style="animation-delay: <?= 0.2 + ($index * 0.1) ?>s">
                <span class="text-sm text-gray-700 font-medium"><?= htmlspecialchars($sub['name']) ?></span>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div id="selected-category"
        class="hidden mx-6 mb-6 p-4 bg-gradient-to-r from-blue-50 via-white to-blue-50 rounded-xl border border-blue-200 selected-pulse shadow-md">
        <div class="flex items-center justify-between">
            <div class="text-sm text-blue-800">
                <span class="font-semibold">Selected:</span>
                <span id="selected-category-name" class="ml-2 font-medium"></span>
            </div>
            <button onclick="clearFilter()"
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-sm">Clear</button>
        </div>
    </div>
</div>

<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-20 hidden lg:hidden"></div>

<script>
let selectedCategory = null;

function closeSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
    document.body.style.overflow = "";
}

function selectCategory(categoryId, element) {
    if (selectedCategory) selectedCategory.classList.remove('selected');
    element.classList.add('selected');
    selectedCategory = element;

    const selectedDiv = document.getElementById('selected-category');
    selectedDiv.classList.remove('hidden');
    selectedDiv.classList.add('selected-pulse');
    document.getElementById('selected-category-name').textContent = element.textContent.trim();

    if (window.innerWidth < 1024) closeSidebar();

    animateProductsEntrance();

    const url = new URL(window.location.href);
    url.searchParams.set('category', categoryId);
    window.location.href = url.toString();
}

function clearFilter() {
    if (selectedCategory) selectedCategory.classList.remove('selected');
    const selectedDiv = document.getElementById('selected-category');
    selectedDiv.classList.add('hidden');
    selectedDiv.classList.remove('selected-pulse');
    selectedCategory = null;

    const url = new URL(window.location.href);
    url.searchParams.delete('category');
    window.location.href = url.toString();
}

function animateProductsEntrance() {
    const products = document.querySelectorAll('.product-card, .product-item');
    products.forEach((product, index) => {
        product.style.opacity = '0';
        product.style.transform = 'translateY(30px) scale(0.95)';
        product.style.animation = `productEntrance 0.8s ease-out forwards`;
        product.style.animationDelay = `${index * 0.1}s`;
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");
    const toggleBtn = document.getElementById("sidebar-toggle");
    const closeBtn = document.getElementById("sidebar-close");

    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    }

    if (toggleBtn) toggleBtn.addEventListener("click", openSidebar);
    if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
    overlay.addEventListener("click", closeSidebar);

    setTimeout(() => {
        animateProductsEntrance();
    }, 300);

    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategoryId = urlParams.get('category');
    if (selectedCategoryId) {
        const categoryElement = document.querySelector(`[data-subcat-id="${selectedCategoryId}"]`);
        if (categoryElement) {
            categoryElement.classList.add('selected');
            selectedCategory = categoryElement;
            document.getElementById('selected-category').classList.remove('hidden');
            document.getElementById('selected-category-name').textContent = categoryElement.textContent.trim();
        }
    }
});
</script>