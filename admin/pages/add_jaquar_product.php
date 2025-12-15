<?php
ob_start();
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$db = new Database();
$conn = $db->getConnection();

$success = $error = "";

$categories = [];
$stmt = $conn->prepare("SELECT id, parent_id, name FROM `jaquar-categories` ORDER BY parent_id ASC, name");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
$stmt->close();


$tree = [];
foreach ($categories as $cat) {
    $cat['subs'] = [];
    $tree[$cat['id']] = $cat;
}
foreach ($tree as $id => &$node) {
    if ($node['parent_id'] !== null && isset($tree[$node['parent_id']])) {
        $tree[$node['parent_id']]['subs'][] = &$node;
    }
}
unset($node);


$uploadDir = __DIR__ . '/uploads/jaquar_uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int)($_POST['subsubcategory'] ?: ($_POST['subcategory'] ?: 0));
    $item_code   = $conn->real_escape_string($_POST['item_code'] ?? '');
    $collection  = $conn->real_escape_string($_POST['collection'] ?? '');
    $item_type   = $conn->real_escape_string($_POST['item_type'] ?? '');
    $item_finish = $conn->real_escape_string($_POST['item_finish'] ?? '');
    $product_link = $conn->real_escape_string($_POST['product_link'] ?? '');
    $image_path = null;

    if (!$category_id || !$item_code) {
        $error = "Category and Item Code are required.";
    } else {

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                $error = "Only JPEG, PNG, and GIF images are allowed.";
            } else {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('product_') . '.' . $ext;
                $destination = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $image_path = 'uploads/jaquar_uploads/' . $filename;
                } else {
                    $error = "Failed to upload image.";
                }
            }
        }


        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO jaquar_products (category_id, item_code, collection, item_type, item_finish, product_link, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) die("SQL error: " . $conn->error);
            $stmt->bind_param("issssss", $category_id, $item_code, $collection, $item_type, $item_finish, $product_link, $image_path);
            if ($stmt->execute()) {
                $success = "Product added successfully!";
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Jaquar Product</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Create category map for JS
        const allCategories = <?php echo json_encode($categories); ?>;

        // Convert to map by parent_id
        const mapByParent = {};
        allCategories.forEach(cat => {
            if (!mapByParent[cat.parent_id]) mapByParent[cat.parent_id] = [];
            mapByParent[cat.parent_id].push(cat);
        });

        function updateSubcategories() {
            const mainId = document.getElementById('main_category').value;
            const subSelect = document.getElementById('subcategory');
            const subSubSelect = document.getElementById('subsubcategory');

            subSelect.innerHTML = "<option value=''>-- Select Subcategory --</option>";
            subSubSelect.innerHTML = "<option value=''>-- Select Sub-Subcategory --</option>";

            if (mapByParent[mainId]) {
                mapByParent[mainId].forEach(sub => {
                    const opt = document.createElement("option");
                    opt.value = sub.id;
                    opt.text = sub.name;
                    subSelect.appendChild(opt);
                });
            }
        }

        function updateSubSubcategories() {
            const subId = document.getElementById('subcategory').value;
            const subSubSelect = document.getElementById('subsubcategory');
            subSubSelect.innerHTML = "<option value=''>-- Select Sub-Subcategory --</option>";

            if (mapByParent[subId]) {
                mapByParent[subId].forEach(subsub => {
                    const opt = document.createElement("option");
                    opt.value = subsub.id;
                    opt.text = subsub.name;
                    subSubSelect.appendChild(opt);
                });
            }
        }
    </script>
</head>

<body class="bg-gray-100">
<div class="ml-64 p-6 min-h-screen md:ml-0 sm:ml-0">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Add Jaquar Product</h1>

        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $success; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
            <!-- MAIN CATEGORY -->
            <div>
                <label class="block text-gray-700 font-semibold">Main Category</label>
                <select id="main_category" class="w-full border p-2 rounded" onchange="updateSubcategories()" required>
                    <option value="">-- Select Main Category --</option>
                    <?php foreach ($tree as $id => $cat): ?>
                        <?php if ($cat['parent_id'] === null): ?>
                            <option value="<?= $id; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- SUBCATEGORY -->
            <div>
                <label class="block text-gray-700 font-semibold">Subcategory</label>
                <select name="subcategory" id="subcategory" class="w-full border p-2 rounded" onchange="updateSubSubcategories()">
                    <option value="">-- Select Subcategory --</option>
                </select>
            </div>

            <!-- SUB-SUBCATEGORY -->
            <div>
                <label class="block text-gray-700 font-semibold">Sub-Subcategory</label>
                <select name="subsubcategory" id="subsubcategory" class="w-full border p-2 rounded">
                    <option value="">-- Select Sub-Subcategory --</option>
                </select>
            </div>

            <!-- PRODUCT DETAILS -->
            <div>
                <label class="block text-gray-700 font-semibold">Item Code</label>
                <input type="text" name="item_code" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Collection</label>
                <input type="text" name="collection" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Item Type</label>
                <input type="text" name="item_type" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Item Finish</label>
                <input type="text" name="item_finish" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Product Link</label>
                <input type="url" name="product_link" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Product Image</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/gif" class="w-full border p-2 rounded">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
