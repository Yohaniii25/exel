<?php
require_once(__DIR__ . '/../includes/db.php');

$db = new Database();
$conn = $db->getConnection();

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
if ($query) {
    $search_param = "%$query%";
    $sql = "SELECT name FROM products WHERE name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['name'];
    }
    echo json_encode($suggestions);
}

$stmt->close();
$conn->close();
?>

