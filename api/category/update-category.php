<?php
include('../config.php');

header('Content-Type: application/json');

$categoryId = $_POST['category_id'];
$name = $_POST['name'];
$slug = $_POST['slug'];
$status = $_POST['category_status'];

$sql = "UPDATE camp_categories SET name = ?, slug = ?, status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $name, $slug, $status, $categoryId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update category']);
}

$stmt->close();
$conn->close();
?>