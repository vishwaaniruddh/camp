<?php
include('../config.php');

header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}


$customerId = $inputData['id'];

$sql = "update  camp_customers set status='deleted' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'customer deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete customer']);
}

$stmt->close();
$conn->close();
?>