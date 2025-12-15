<?php

require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/sidebar.php');

$projects = $conn->query("SELECT * FROM projects");
?>

<h2 class="text-2xl font-semibold mb-4">Project List</h2>
<table class="min-w-full bg-white shadow rounded">
  <thead class="bg-gray-200 text-left">
    <tr>
      <th class="px-4 py-2">Image</th>
      <th class="px-4 py-2">Name</th>
      <th class="px-4 py-2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($project = $projects->fetch_assoc()) : ?>
      <tr class="border-t">
        <td class="px-4 py-2"><img src="../admin/<?= $project['image'] ?>" class="h-12" /></td>
        <td class="px-4 py-2"><?= $project['name'] ?></td>
        <td class="px-4 py-2">
          <a href="projects/edit_project.php?id=<?= $project['id'] ?>" class="text-blue-600 mr-2"><i class="fas fa-edit"></i></a>
          <a href="projects/delete_project.php?id=<?= $project['id'] ?>" class="text-red-600" onclick="return confirm('Delete this project?');"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
