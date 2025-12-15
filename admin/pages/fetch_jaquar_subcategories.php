<?php
require_once('../includes/db.php');
$conn = (new Database())->getConnection();
$category_id = (int)$_GET['category_id'];
$res = $conn->query("SELECT * FROM jaquar_subcategories WHERE category_id = $category_id ORDER BY name");
$subs = [];
while ($row = $res->fetch_assoc()) {
    $subs[] = ['id' => $row['id'], 'name' => $row['name']];
}
echo json_encode($subs);
