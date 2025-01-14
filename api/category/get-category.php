<?php
include('../config.php');

header('Content-Type: application/json');

$categoryId = $_GET['id'];

$sql = "SELECT * FROM camp_categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $category = $result->fetch_assoc();
    echo json_encode(['success' => true, 'category' => $category]);
} else {
    echo json_encode(['success' => false, 'message' => 'Category not found']);
}

$stmt->close();
$conn->close();
?>