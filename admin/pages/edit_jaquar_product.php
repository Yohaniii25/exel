<?php
ob_start();
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');


$db = new Database();
$conn = $db->getConnection();

$success = $error = "";
$product = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID");
}
$product_id = (int)$_GET['id'];


$stmt = $conn->prepare("SELECT * FROM jaquar_products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Product not found.");
}
$product = $result->fetch_assoc();
$stmt->close();


$categories = [];
$stmt = $conn->prepare("SELECT id, parent_id, name FROM `jaquar-categories` ORDER BY parent_id ASC, name");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    if ($row['parent_id'] === null) {
        $categories[$row['id']] = ['id' => $row['id'], 'name' => $row['name'], 'subs' => []];
    } else {
        if (isset($categories[$row['parent_id']])) {
            $categories[$row['parent_id']]['subs'][$row['id']] = ['id' => $row['id'], 'name' => $row['name'], 'subs' => []];
        } else {

            foreach ($categories as &$main) {
                foreach ($main['subs'] as &$sub) {
                    if ($sub['id'] == $row['parent_id']) {
                        $sub['subs'][$row['id']] = ['id' => $row['id'], 'name' => $row['name']];
                    }
                }
            }
        }
    }
}
$stmt->close();

// (root-level path)
$uploadDir = dirname(__DIR__, 2) . '/uploads/jaquar_uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int)($_POST['subcategory'] ?? 0);
    $subsubcategory_id = (int)($_POST['sub_subcategory'] ?? 0);
    $final_category_id = $subsubcategory_id ?: $category_id;

    $item_code = $conn->real_escape_string($_POST['item_code'] ?? '');
    $collection = $conn->real_escape_string($_POST['collection'] ?? '');
    $item_type = $conn->real_escape_string($_POST['item_type'] ?? '');
    $item_finish = $conn->real_escape_string($_POST['item_finish'] ?? '');
    $product_link = $conn->real_escape_string($_POST['product_link'] ?? '');
    $image_path = null;

    if (!$final_category_id || !$item_code) {
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
            $stmt = $conn->prepare("UPDATE jaquar_products 
                SET category_id = ?, item_code = ?, collection = ?, item_type = ?, item_finish = ?, product_link = ?, image = ?
                WHERE id = ?");
            $stmt->bind_param("issssssi", $final_category_id, $item_code, $collection, $item_type, $item_finish, $product_link, $image_path, $product_id);

            if ($stmt->execute()) {
                $success = "Product updated successfully!";

                header("Location: edit_jaquar_product.php?id=" . $product_id . "&updated=1");
                exit;
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Jaquar Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const categories = <?php echo json_encode($categories); ?>;

        function updateSubcategories() {
            const mainCategoryId = document.getElementById("main_category").value;
            const subSelect = document.getElementById("subcategory");
            const subSubSelect = document.getElementById("sub_subcategory");

            subSelect.innerHTML = "<option value=''>-- Select Subcategory --</option>";
            subSubSelect.innerHTML = "<option value=''>-- Select Sub-Subcategory --</option>";

            if (mainCategoryId && categories[mainCategoryId]?.subs) {
                Object.values(categories[mainCategoryId].subs).forEach(sub => {
                    const opt = document.createElement("option");
                    opt.value = sub.id;
                    opt.text = sub.name;
                    subSelect.appendChild(opt);
                });
            }
        }

        function updateSubSubcategories() {
            const mainCategoryId = document.getElementById("main_category").value;
            const subCategoryId = document.getElementById("subcategory").value;
            const subSubSelect = document.getElementById("sub_subcategory");
            subSubSelect.innerHTML = "<option value=''>-- Select Sub-Subcategory --</option>";

            if (mainCategoryId && subCategoryId && categories[mainCategoryId]?.subs[subCategoryId]?.subs) {
                Object.values(categories[mainCategoryId].subs[subCategoryId].subs).forEach(subsub => {
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
    <?php require_once(__DIR__ . '/../includes/sidebar.php'); ?>
    <div class="ml-64 p-6 min-h-screen lg:ml-64 md:ml-0 sm:ml-0">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Edit Jaquar Product</h1>

            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow max-w-full">

                <div>
                    <label class="block text-gray-700 font-semibold">Main Category</label>
                    <select id="main_category" class="w-full border p-2 rounded" onchange="updateSubcategories()" required>
                        <option value="">-- Select Main Category --</option>
                        <?php foreach ($categories as $id => $cat): ?>
                            <option value="<?php echo $id; ?>" <?php echo in_array($product['category_id'], array_keys($cat['subs'])) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div>
                    <label class="block text-gray-700 font-semibold">Subcategory</label>
                    <select name="subcategory" id="subcategory" class="w-full border p-2 rounded" onchange="updateSubSubcategories()" required>
                        <option value="">-- Select Subcategory --</option>
                    </select>
                </div>


                <div>
                    <label class="block text-gray-700 font-semibold">Sub-Subcategory</label>
                    <select name="sub_subcategory" id="sub_subcategory" class="w-full border p-2 rounded">
                        <option value="">-- Select Sub-Subcategory --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Item Code</label>
                    <input type="text" name="item_code" value="<?php echo htmlspecialchars($product['item_code']); ?>" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Collection</label>
                    <input type="text" name="collection" value="<?php echo htmlspecialchars($product['collection']); ?>" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Item Type</label>
                    <input type="text" name="item_type" value="<?php echo htmlspecialchars($product['item_type']); ?>" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Item Finish</label>
                    <input type="text" name="item_finish" value="<?php echo htmlspecialchars($product['item_finish']); ?>" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Product Link</label>
                    <input type="url" name="product_link" value="<?php echo htmlspecialchars($product['product_link']); ?>" class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Current Image</label><br>
                    <?php if (!empty($product['image'])): ?>
                        <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="w-32 h-32 object-cover mb-3">
                    <?php else: ?>
                        <p>No image uploaded.</p>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/jpg" class="w-full border p-2 rounded">
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>