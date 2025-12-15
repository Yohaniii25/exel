<?php
ob_start();
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');

$db = new Database();
$conn = $db->getConnection();

$success = $error = "";

if (!isset($_GET['id'])) {
    die("Product ID is required.");
}
$product_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}
$stmt->close();

$categories = [];
$stmt = $conn->prepare("SELECT * FROM categories ORDER BY name");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    if ((int)$row['parent_id'] === 0) {
        $categories[$row['id']] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'subs' => []
        ];
    }
}
$result->data_seek(0);
while ($row = $result->fetch_assoc()) {
    if ((int)$row['parent_id'] !== 0 && isset($categories[$row['parent_id']])) {
        $categories[$row['parent_id']]['subs'][] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
}
$stmt->close();

$filters = [];
$stmt = $conn->prepare("
    SELECT f.id AS filter_id, f.name AS filter_name, f.filter_type, o.id AS option_id, o.value AS option_value
    FROM filters f
    JOIN filter_options o ON f.id = o.filter_id
    ORDER BY f.name, o.value
");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $filters[$row['filter_type']]['name'] = $row['filter_name'];
    $filters[$row['filter_type']]['options'][] = $row['option_value'];
}
$stmt->close();

$selected_filters = [];
$stmt = $conn->prepare("
    SELECT o.value, f.filter_type 
    FROM product_filters pf 
    JOIN filter_options o ON pf.filter_option_id = o.id
    JOIN filters f ON o.filter_id = f.id
    WHERE pf.product_id = ?
");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $selected_filters[$row['filter_type']][] = $row['value'];
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['name']) || empty($_POST['main_category']) || empty($_POST['subcategory'])) {
        $error = "Product name, main category, and subcategory are required.";
    } else {
        $conn->begin_transaction();
        try {
            $name = $conn->real_escape_string($_POST['name']);
            $category_id = (int)$_POST['main_category'];
            $subcategory_id = (int)$_POST['subcategory'];
            $description = $conn->real_escape_string($_POST['description'] ?? '');
            $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0.00;

            $image = $product['image'];
            if (!empty($_FILES['image']['name'])) {
                if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $uploadErrors = [
                        UPLOAD_ERR_INI_SIZE => "File exceeds upload_max_filesize.",
                        UPLOAD_ERR_FORM_SIZE => "File exceeds MAX_FILE_SIZE.",
                        UPLOAD_ERR_PARTIAL => "File was only partially uploaded.",
                        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
                        UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder.",
                        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
                        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the upload."
                    ];
                    throw new Exception("Upload error: " . ($uploadErrors[$_FILES['image']['error']] ?? "Unknown error."));
                }

                $uploadDir = realpath(__DIR__ . '/../../Uploads/products/');
                if (!$uploadDir) {
                    if (!mkdir(__DIR__ . '/../../Uploads/products/', 0777, true)) {
                        throw new Exception("Failed to create directory: " . __DIR__ . '/../../Uploads/products/');
                    }
                    $uploadDir = realpath(__DIR__ . '/../../Uploads/products/');
                    chmod($uploadDir, 0777); 
                }

                if (!is_writable($uploadDir)) {
                    throw new Exception("Upload directory is not writable: " . $uploadDir);
                }

                $imageName = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $_FILES["image"]["name"]);
                $targetFile = $uploadDir . DIRECTORY_SEPARATOR . $imageName;

                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES["image"]["type"], $allowedTypes)) {
                    throw new Exception("Invalid file type. Only JPG, PNG, WebP allowed.");
                }

                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    throw new Exception("Failed to move uploaded file. Temp: " . $_FILES["image"]["tmp_name"] . " → Target: " . $targetFile);
                }

                $image = "Uploads/products/" . $imageName;
            }

            $stmt = $conn->prepare("
                UPDATE products SET 
                    name = ?, 
                    category_id = ?, 
                    subcategory_id = ?, 
                    description = ?, 
                    price = ?, 
                    image = ?,
                    category = NULL,
                    subcategory = NULL
                WHERE id = ?
            ");
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("siisdsi", $name, $category_id, $subcategory_id, $description, $price, $image, $product_id);
            $stmt->execute();
            $stmt->close();


            $stmt_delete = $conn->prepare("DELETE FROM product_filters WHERE product_id = ?");
            if ($stmt_delete === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt_delete->bind_param("i", $product_id);
            $stmt_delete->execute();
            $stmt_delete->close();

            foreach ($filters as $filterType => $filterData) {
                if (!empty($_POST[$filterType])) {
                    foreach ($_POST[$filterType] as $val) {
                        $val = $conn->real_escape_string($val);
                        $stmt_filter = $conn->prepare("
                            INSERT INTO product_filters (product_id, filter_option_id) 
                            SELECT ?, id FROM filter_options WHERE value = ?
                        ");
                        if ($stmt_filter === false) {
                            throw new Exception("Prepare failed: " . $conn->error);
                        }
                        $stmt_filter->bind_param("is", $product_id, $val);
                        $stmt_filter->execute();
                        $stmt_filter->close();
                    }
                }
            }

            $conn->commit();
            ob_end_clean();
            header("Location: ../dashboard.php?page=product_list&success=Product+updated+successfully");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Error: " . $e->getMessage();
        }
    }
}
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function updateSubcategories() {
            let mainCategory = document.getElementById("main_category").value;
            let subSelect = document.getElementById("subcategory");
            subSelect.innerHTML = "<option value=''>-- Select Subcategory --</option>";
            let allCategories = <?php echo json_encode($categories); ?>;
            if (allCategories[mainCategory] && allCategories[mainCategory]['subs']) {
                allCategories[mainCategory]['subs'].forEach(sub => {
                    let opt = document.createElement("option");
                    opt.value = sub.id;
                    opt.text = sub.name;
                    subSelect.appendChild(opt);
                });
            }
        }
        window.onload = function() {
            updateSubcategories();
            document.getElementById("subcategory").value = "<?php echo $product['subcategory_id']; ?>";
        };
    </script>
</head>
<body class="bg-gray-100">
    <?php require_once(__DIR__ . '/../includes/sidebar.php'); ?>
    <div class="ml-64 p-6 min-h-screen lg:ml-64 md:ml-0 sm:ml-0">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow max-w-full">
                <div>
                    <label class="block text-gray-700 font-semibold">Product Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Main Category</label>
                    <select name="main_category" id="main_category" class="w-full border p-2 rounded" onchange="updateSubcategories()" required>
                        <option value="">-- Select Main Category --</option>
                        <?php foreach ($categories as $id => $cat): ?>
                            <option value="<?php echo $id; ?>" <?php echo $product['category_id'] == $id ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="w-full border p-2 rounded" required>
                        <option value="">-- Select Subcategory --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Description</label>
                    <textarea name="description" class="w-full border p-2 rounded"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Price</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Image</label>
                    <?php if ($product['image']): ?>
                        <img src="/exel/<?php echo htmlspecialchars($product['image']); ?>" class="w-32 max-w-full h-auto mb-2">
                    <?php endif; ?>
                    <input type="file" name="image" class="w-full border p-2 rounded">
                </div>

                <?php foreach ($filters as $filterType => $filterData): ?>
                    <div>
                        <label class="block text-gray-700 font-semibold"><?php echo htmlspecialchars($filterData['name']); ?> (optional)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <?php foreach ($filterData['options'] as $option): ?>
                                <label>
                                    <input type="checkbox" name="<?php echo $filterType; ?>[]" value="<?php echo htmlspecialchars($option); ?>"
                                        <?php echo !empty($selected_filters[$filterType]) && in_array($option, $selected_filters[$filterType]) ? 'checked' : ''; ?>>
                                    <?php echo htmlspecialchars($option); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>