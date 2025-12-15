<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$db = new Database();
$conn = $db->getConnection();

$success = $error = "";


$categories = [];
$result = $conn->query("SELECT * FROM categories ORDER BY name");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (empty($row['parent_id']) || (int)$row['parent_id'] === 0) {
            $categories[$row['id']] = [
                'id'   => $row['id'],
                'name' => $row['name'],
                'subs' => []
            ];
        }
    }


    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['parent_id']) && isset($categories[$row['parent_id']])) {
            $categories[$row['parent_id']]['subs'][] = [
                'id'   => $row['id'],
                'name' => $row['name']
            ];
        }
    }
}

$filters = [];
$result = $conn->query("
    SELECT f.id as filter_id, f.name as filter_name, f.filter_type, 
           o.id as option_id, o.value as option_value
    FROM filters f
    JOIN filter_options o ON f.id = o.filter_id
    ORDER BY f.name, o.value
");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if (!isset($filters[$row['filter_type']])) {
            $filters[$row['filter_type']] = [
                'name'    => $row['filter_name'],
                'options' => []
            ];
        }
        $filters[$row['filter_type']]['options'][] = $row['option_value'];
    }
} else {
    die("SQL Error: " . $conn->error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name           = $conn->real_escape_string($_POST['name']);
    $category_id    = (int) $_POST['main_category'];
    $subcategory_id = (int) $_POST['subcategory'];
    $description    = $conn->real_escape_string($_POST['description']);
    $product_code = $conn->real_escape_string($_POST['product_code']);
    $price          = $conn->real_escape_string($_POST['price']);

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/products/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName  = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;


        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES["image"]["type"], $allowedTypes)) {
            $error = "Invalid file type. Only JPG, PNG, WebP allowed.";
        } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "uploads/products/" . $imageName;
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO products (name, category_id, subcategory_id, description, product_code, price, image)
                VALUES ('$name', '$category_id', '$subcategory_id', '$description', '$product_code', '$price', '$image')";

        if ($conn->query($sql)) {
            $product_id = $conn->insert_id;


            foreach ($filters as $filterType => $filterData) {
                if (!empty($_POST[$filterType])) {
                    foreach ($_POST[$filterType] as $val) {
                        $val = $conn->real_escape_string($val);
                        $conn->query("INSERT INTO product_filters (product_id, filter_type, filter_value) 
                                      VALUES ('$product_id', '$filterType', '$val')");
                    }
                }
            }

            $success = "Product added successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
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
                opt.text  = sub.name;
                subSelect.appendChild(opt);
            });
        }
    }
  </script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

    <?php if (!empty($success)): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $success ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">


        <div>
            <label class="block text-gray-700 font-semibold">Product Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">Main Category</label>
            <select name="main_category" id="main_category" class="w-full border p-2 rounded" onchange="updateSubcategories()" required>
                <option value="">-- Select Main Category --</option>
                <?php foreach ($categories as $id => $cat): ?>
                    <option value="<?= $id ?>"><?= htmlspecialchars($cat['name']) ?></option>
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
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">Product Code</label>
            <input type="text" name="product_code" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">Price</label>
            <input type="number" step="0.01" name="price" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded">
        </div>


        <?php foreach ($filters as $filterType => $filterData): ?>
            <div>
                <label class="block text-gray-700 font-semibold"><?= htmlspecialchars($filterData['name']) ?> (optional)</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ($filterData['options'] as $option): ?>
                        <label>
                            <input type="checkbox" name="<?= $filterType ?>[]" value="<?= htmlspecialchars($option) ?>">
                            <?= htmlspecialchars($option) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Product
            </button>
        </div>
    </form>
</div>

</body>
</html>
