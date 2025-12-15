<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $imagePath = "";

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/projects/";
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Create folder if not exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = "uploads/projects/" . $fileName; // Relative path to store in DB
        } else {
            $error = "Failed to upload image.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO projects (name, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $imagePath);
        if ($stmt->execute()) {
            $success = "Project added successfully.";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Add New Project</h2>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block font-medium">Project Name</label>
                <input type="text" name="name" required class="w-full border px-4 py-2 rounded">
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" rows="4" class="w-full border px-4 py-2 rounded"></textarea>
            </div>

            <div>
                <label class="block font-medium">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border px-4 py-2 rounded">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Add Project</button>
        </form>
    </div>

</body>
</html>
