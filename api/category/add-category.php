<?php
include('../config.php');

header('Content-Type: application/json');

$name = $_POST['name'];
$slug = $_POST['slug'];
$created_by = $userid;
$status = 'active'; // Default status

$sql = "INSERT INTO camp_categories (name, slug, created_by, status) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $slug, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add category']);
}

$stmt->close();
$conn->close();
?>