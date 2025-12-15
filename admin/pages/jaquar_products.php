<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$db = new Database();
$conn = $db->getConnection();

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM jaquar_products WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    $current_page = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search_param = $search ? "&search=" . urlencode($search) : '';
    header("Location: ?page=jaquar_products&pg=$current_page$search_param&success=Product+deleted+successfully");
    exit;
}

// Get search term and pagination parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$current_page = isset($_GET['pg']) ? max(1, (int)$_GET['pg']) : 1;
$per_page = 10;
$offset = ($current_page - 1) * $per_page;

// Count total products with search filter
$search_condition = $search ? " WHERE p.item_code LIKE ? OR p.collection LIKE ? OR p.item_type LIKE ? OR p.item_finish LIKE ?" : '';
$count_query = "SELECT COUNT(*) as total FROM jaquar_products p JOIN `jaquar-categories` c ON p.category_id = c.id" . $search_condition;
$stmt = $conn->prepare($count_query);
if ($search) {
    $search_term = "%$search%";
    $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
}
$stmt->execute();
$count_result = $stmt->get_result();
$total_products = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $per_page);

$start_record = ($current_page - 1) * $per_page + 1;
$end_record = min($current_page * $per_page, $total_products);

// Fetch products with search filter
$query = "
    SELECT p.id, p.item_code, p.collection, p.item_type, p.item_finish, p.product_link, c.name AS category_name
    FROM jaquar_products p
    JOIN `jaquar-categories` c ON p.category_id = c.id" .
    ($search ? " WHERE p.item_code LIKE ? OR p.collection LIKE ? OR p.item_type LIKE ? OR p.item_finish LIKE ?" : "") .
    " ORDER BY p.id DESC
    LIMIT ? OFFSET ?
";
$stmt = $conn->prepare($query);
if ($search) {
    $search_term = "%$search%";
    $stmt->bind_param("ssssii", $search_term, $search_term, $search_term, $search_term, $per_page, $offset);
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
    <title>Jaquar Products</title>
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
    </style>
</head>
<body class="bg-gray-50">
<div class="ml-64 p-6 min-h-screen md:ml-0 sm:ml-0">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Jaquar Products</h1>
                    <p class="text-gray-600">Manage your Jaquar product catalog with ease.</p>
                </div>
                <a href="add_jaquar_product.php" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                    Add New Product
                </a>
            </div>

            <!-- Search Form -->
            <div class="mb-6">
                <form action="?page=jaquar_products" method="GET" class="flex items-center space-x-4">
                    <input type="hidden" name="page" value="jaquar_products">
                    <div class="flex-1">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                               placeholder="Search by item code, collection, type, or finish..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i data-feather="search" class="w-4 h-4 mr-2"></i>
                        Search
                    </button>
                    <?php if ($search): ?>
                        <a href="?page=jaquar_products" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i data-feather="x" class="w-4 h-4 mr-2"></i>
                            Clear
                        </a>
                    <?php endif; ?>
                </form>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collection</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Finish</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $row['id']; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?php echo htmlspecialchars($row['category_name']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900"><?php echo htmlspecialchars($row['item_code']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['collection']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['item_type']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($row['item_finish']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php if ($row['product_link']): ?>
                                                <a href="<?php echo htmlspecialchars($row['product_link']); ?>" target="_blank" rel="noopener noreferrer" 
                                                   class="text-blue-600 hover:text-blue-900 font-medium transition-colors duration-150">
                                                    <i data-feather="external-link" class="w-4 h-4 inline mr-1"></i>
                                                    View Link
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400 italic">No link</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="pages/edit_jaquar_product.php?id=<?php echo $row['id']; ?>" 
                                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-150" 
                                                   title="Edit Product">
                                                    <i data-feather="edit-3" class="w-4 h-4"></i>
                                                </a>
                                                <a href="view_jaquar_product.php?id=<?php echo $row['id']; ?>" 
                                                   class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-150" 
                                                   title="View Product">
                                                    <i data-feather="eye" class="w-4 h-4"></i>
                                                </a>
                                                <a href="?page=jaquar_products&pg=<?php echo $current_page; ?>&delete_id=<?php echo $row['id']; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" 
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
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i data-feather="inbox" class="w-12 h-12 text-gray-400 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                            <p class="text-gray-500 mb-4">Get started by adding a new Jaquar product or try a different search.</p>
                                            <a href="add_jaquar_product.php" 
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
                            <!-- Mobile pagination -->
                            <div class="flex justify-between flex-1 sm:hidden">
                                <?php if ($current_page > 1): ?>
                                    <a href="?page=jaquar_products&pg=<?php echo $current_page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn">
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
                                    <a href="?page=jaquar_products&pg=<?php echo $current_page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn">
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
                                            <a href="?page=jaquar_products&pg=1<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn rounded-l-md" title="First page">
                                                <i data-feather="chevrons-left" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn rounded-l-md disabled" title="First page">
                                                <i data-feather="chevrons-left" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($current_page > 1): ?>
                                            <a href="?page=jaquar_products&pg=<?php echo $current_page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn" title="Previous page">
                                                <i data-feather="chevron-left" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn disabled" title="Previous page">
                                                <i data-feather="chevron-left" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>

                                        <?php
                                        $start_page = max(1, $current_page - 2);
                                        $end_page = min($total_pages, $current_page + 2);
                                        if ($start_page > 1): ?>
                                            <a href="?page=jaquar_products&pg=1<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn">1</a>
                                            <?php if ($start_page > 2): ?>
                                                <span class="pagination-btn disabled">...</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                            <?php if ($i == $current_page): ?>
                                                <span class="pagination-btn active"><?php echo $i; ?></span>
                                            <?php else: ?>
                                                <a href="?page=jaquar_products&pg=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn"><?php echo $i; ?></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if ($end_page < $total_pages): ?>
                                            <?php if ($end_page < $total_pages - 1): ?>
                                                <span class="pagination-btn disabled">...</span>
                                            <?php endif; ?>
                                            <a href="?page=jaquar_products&pg=<?php echo $total_pages; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn"><?php echo $total_pages; ?></a>
                                        <?php endif; ?>

                                        <?php if ($current_page < $total_pages): ?>
                                            <a href="?page=jaquar_products&pg=<?php echo $current_page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn" title="Next page">
                                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="pagination-btn disabled" title="Next page">
                                                <i data-feather="chevron-right" class="w-4 h-4"></i>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($current_page < $total_pages): ?>
                                            <a href="?page=jaquar_products&pg=<?php echo $total_pages; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="pagination-btn rounded-r-md" title="Last page">
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
    });
</script>
</body>
</html>

<?php
$result->close();
$stmt->close();
$conn->close();
?>