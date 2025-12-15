<?php
$project_count = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-white p-6 rounded shadow text-center">
    <h2 class="text-3xl font-bold text-gray-800"><?= $project_count ?></h2>
    <p class="text-gray-600 mb-4">Projects</p>
    <a href="dashboard.php?page=project_list" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">View More</a>
  </div>

 
</div>
