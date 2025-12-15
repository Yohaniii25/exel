<?php
require_once(__DIR__ . '/../includes/db.php');
require_once(__DIR__ . '/../includes/auth.php'); 

$db = new Database();
$conn = $db->getConnection();

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$response = [];

if (!empty($query)) {
    $search_param = "%$query%";
    $sql = "SELECT DISTINCT item_type FROM jaquar_products WHERE item_type LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row['item_type'];
    }
    $stmt->close();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>