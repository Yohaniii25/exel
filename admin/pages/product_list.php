<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$db = new Database();
$conn = $db->getConnection();

$current_page = isset($_GET['pg']) ? max(1, (int)$_GET['pg']) : 1;
$per_page = 10;
$offset = ($current_page - 1) * $per_page;

// Handle search parameter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$count_query = "SELECT COUNT(*) as total FROM products" . ($search ? " WHERE name LIKE ?" : "");
$count_stmt = $conn->prepare($count_query);
if ($search) {
    $search_param = "%$search%";
    $count_stmt->bind_param("s", $search_param);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_products = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $per_page);

$start_record = ($current_page - 1) * $per_page + 1;
$end_record = min($current_page * $per_page, $total_products);

$sql = "
    SELECT p.id, p.name, c1.name AS main_category, c2.name AS sub_category
    FROM products p
    LEFT JOIN categories c1 ON p.category_id = c1.id
    LEFT JOIN categories c2 ON p.subcategory_id = c2.id
    " . ($search ? "WHERE p.name LIKE ?" : "") . "
    ORDER BY p.id DESC
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($sql);
if ($search) {
    $search_param = "%$search%";
    $stmt->bind_param("sii", $search_param, $per_page, $offset);
} else {
    $stmt->bind_param("ii", $per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .pagination-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
            text-decoration: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
        }
        .pagination-btn:hover:not(.disabled):not(.active) {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }
        .pagination-btn.active {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Search suggestion styles */
        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            display: none;
        }
        .suggestion-item {
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .suggestion-item:hover {
            background-color: #f3f4f6;
        }
        .search-container {
            position: relative;
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body class="bg-gray-50">
<div class="ml-64 p-6 min-h-screen md:ml-0 sm:ml-0">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Product List</h1>
                    <p class="text-gray-600">Manage your product catalog with ease.</p>
                </div>
                <div class="flex space-x-4">
                    <div class="search-container">
                        <form action="" method="get" class="relative">
                            <input type="text" name="search" id="search-input" value="<?php echo htmlspecialchars($search); ?>" 
                                   placeholder="Search products..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   onkeyup="fetchSuggestions()">
                            <div id="suggestions" class="suggestions"></div>
                            <input type="hidden" name="page" value="product_list">
                        </form>
                    </div>
                    <a href="./dashboard.php?page=add_product" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        Add New Product
                    </a>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md mb-6 fade-in">
                    <div class="flex items-center">
                        <i data-feather="check-circle" class="w-5 h-5 mr-2"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="overflow-hidden rounded-lg shadow border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Main Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategory</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $row['id']; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?php echo htmlspecialchars($row['main_category'] ?? '-'); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <?php echo htmlspecialchars($row['sub_category'] ?? '-'); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="view_product.php?id=<?php echo $row['id']; ?>&pg=<?php echo $current_page; ?>&search=<?php echo urlencode($search); ?>" 
                                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-150" 
                                                   title="View Product">
                                                    <i data-feather="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="../admin/pages/edit_product.php?id=<?php echo $row['id']; ?>&pg=<?php echo $current_page; ?>&search=<?php echo urlencode($search); ?>" 
                                                   class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-150" 
                                                   title="Edit Product">
                                                    <i data-feather="edit-3" class="w-4 h-4"></i>
                                                </a>
                                                <a href="delete_product.php?id=<?php echo $row['id']; ?>&pg=<?php echo $current_page; ?>&search=<?php echo urlencode($search); ?>" 
                                                   onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.');" 
                                                   class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-150" 
                                                   title="Delete Product">
                                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 text-gray-400 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                            <p class="text-gray-500 mb-4">Get started by adding a new product.</p>
                                            <a href="add_product.php" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition ease-in-out duration-150">
                                                <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                                                Add Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex justify-between flex-1 sm:hidden">
                                <?php if ($current_page > 1): ?>
                                    <a href="?page=product_list&pg=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                        <i data-feather="chevron-left" class="w-4 h-4 mr-1"></i>
                                        Previous
                                    </a>
                                <?php else: ?>
                                    <span class="pagination-btn disabled">
                                        <i data-feather="chevron-left" class="w-4 h-4 mr-1"></i>
                                        Previous
                                    </span>
                                <?php endif; ?>
                                <?php if ($current_page < $total_pages): ?>
                                    <a href="?page=product_list&pg=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                        Next
                                        <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="pagination-btn disabled">
                                        Next
                                        <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing
                                        <span class="font-medium"><?php echo number_format($start_record); ?></span>
                                        to
                                        <span class="font-medium"><?php echo number_format($end_record); ?></span>
                                        of
                                        <span class="font-medium"><?php echo number_format($total_products); ?></span>
                                        results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        <?php if ($current_page > 1): ?>
                                            <a href="?page=product_list&pg=1&search=<?php echo urlencode($search); ?>" class="pagination-btn rounded-l-md" title="First page">
                                                <i data-feather="chevrons-left" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn rounded-l-md disabled" title="First page">
                                                <i data-feather="chevrons-left" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($current_page > 1): ?>
                                            <a href="?page=product_list&pg=<?php echo $current_page - 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn" title="Previous page">
                                                <i data-feather="chevron-left" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn disabled" title="Previous page">
                                                <i data-feather="chevron-left" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php $start_page = max(1, $current_page - 2); ?>
                                        <?php $end_page = min($total_pages, $current_page + 2); ?>
                                        <?php if ($start_page > 1): ?>
                                            <a href="?page=product_list&pg=1&search=<?php echo urlencode($search); ?>" class="pagination-btn">1</a>
                                            <?php if ($start_page > 2): ?>
                                                <span class="pagination-btn disabled">...</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                            <?php if ($i == $current_page): ?>
                                                <span class="pagination-btn active"><?php echo $i; ?></span>
                                            <?php else: ?>
                                                <a href="?page=product_list&pg=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn"><?php echo $i; ?></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if ($end_page < $total_pages): ?>
                                            <?php if ($end_page < $total_pages - 1): ?>
                                                <span class="pagination-btn disabled">...</span>
                                            <?php endif; ?>
                                            <a href="?page=product_list&pg=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn"><?php echo $total_pages; ?></a>
                                        <?php endif; ?>
                                        <?php if ($current_page < $total_pages): ?>
                                            <a href="?page=product_list&pg=<?php echo $current_page + 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn" title="Next page">
                                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn disabled" title="Next page">
                                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($current_page < $total_pages): ?>
                                            <a href="?page=product_list&pg=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn rounded-r-md" title="Last page">
                                                <i data-feather="chevrons-right" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn rounded-r-md disabled" title="Last page">
                                                <i data-feather="chevrons-right" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        const searchInput = document.getElementById('search-input');
        const suggestions = document.getElementById('suggestions');

        searchInput.addEventListener('focus', fetchSuggestions);
        searchInput.addEventListener('input', fetchSuggestions);

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.style.display = 'none';
            }
        });

        function fetchSuggestions() {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                suggestions.style.display = 'none';
                return;
            }

            fetch(`search_suggestions.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestions.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.textContent = item;
                            div.onclick = () => {
                                searchInput.value = item;
                                suggestions.style.display = 'none';
                                searchInput.form.submit(); // Submit the form to filter results
                            };
                            suggestions.appendChild(div);
                        });
                        suggestions.style.display = 'block';
                    } else {
                        suggestions.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching suggestions:', error));
        }
    });
</script>
</body>
</html>

<?php
$result->close();
$stmt->close();
$count_stmt->close();
$conn->close();
?>