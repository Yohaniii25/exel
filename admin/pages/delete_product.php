<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../includes/db.php');

$db = new Database();
$conn = $db->getConnection();

if (!isset($_GET['id'])) {
    die("Product ID is required.");
}
$product_id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM product_filters WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->close();

header("Location: ?page=product_list");
exit;
?>