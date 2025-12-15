<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$db = new Database();
$conn = $db->getConnection();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategory_id = (int)$_POST['subcategory_id'];
    $description = $conn->real_escape_string($_POST['description']);
    $image = "";


    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/categories/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName  = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $imageName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES["image"]["type"], $allowedTypes)) {
            $error = "Invalid file type. Only JPG, PNG, WebP allowed.";
        } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "uploads/categories/" . $imageName;
        }
    }

    if (!empty($subcategory_id)) {
        if (!empty($description) || !empty($image)) {
            if (!empty($image)) {
                $stmt = $conn->prepare("UPDATE categories SET description = ?, image = ? WHERE id = ?");
                $stmt->bind_param("ssi", $description, $image, $subcategory_id);
            } else {
                $stmt = $conn->prepare("UPDATE categories SET description = ? WHERE id = ?");
                $stmt->bind_param("si", $description, $subcategory_id);
            }

            if ($stmt->execute()) {
                $success = "Category updated successfully!";
            } else {
                $error = "Error: " . $conn->error;
            }
            $stmt->close();
        } else {
            $error = "Please provide description or image!";
        }
    } else {
        $error = "Please select a category!";
    }
}

$categories = [];
$result = $conn->query("SELECT id, name, parent_id FROM categories ORDER BY parent_id, name");
while ($row = $result->fetch_assoc()) {
    $row['id'] = (int)$row['id'];
    $row['parent_id'] = $row['parent_id'] !== null ? (int)$row['parent_id'] : null;
    $categories[] = $row;
}

$mainCategories = array_filter($categories, fn($c) => $c['parent_id'] === null);
$subCategories = array_filter($categories, fn($c) => $c['parent_id'] !== null);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Category Description & Image</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Add / Update Category Description & Image</h1>

        <?php if (!empty($success)): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= $success ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">

  
            <div>
                <label class="block text-gray-700 font-semibold">Choose Main Category</label>
                <select id="mainCategory" class="w-full border p-2 rounded" required>
                    <option value="">-- Select Main Category --</option>
                    <?php foreach ($mainCategories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div>
                <label class="block text-gray-700 font-semibold">Choose Subcategory</label>
                <select name="subcategory_id" id="subcategory" class="w-full border p-2 rounded" required>
                    <option value="">-- Select Subcategory --</option>
                </select>
            </div>


            <div>
                <label class="block text-gray-700 font-semibold">Category Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded" rows="4" required></textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>

    <script>
        const subCategories = <?= json_encode(array_values($subCategories)) ?>;
        const subSelect = document.getElementById('subcategory');
        const mainSelect = document.getElementById('mainCategory');

        mainSelect.addEventListener('change', function() {
            const mainId = parseInt(this.value);
            subSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';

            if (mainId) {
                subCategories
                    .filter(sub => parseInt(sub.parent_id) === mainId)
                    .forEach(sub => {
                        let opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = sub.name;
                        subSelect.appendChild(opt);
                    });
            }
        });
    </script>

</body>
</html>
