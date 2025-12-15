<?php

require_once 'includes/db.php';

$email = 'admin@gmail.com';
$password = '7R%3Qk8x';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert admin user
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashedPassword);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
