<?php
include('../config.php');

header('Content-Type: application/json');

$customerId = $_POST['customer_id'];
$name = $_POST['name'];
$status = $_POST['customer_status'];

$sql = "UPDATE camp_customers SET name = ?,  status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $status, $customerId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'customer updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update customer']);
}

$stmt->close();
$conn->close();
?>