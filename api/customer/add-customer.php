<?php
include('../config.php');

header('Content-Type: application/json');

$name = $_POST['name'];
$created_by = $userid;
$status = 'active'; // Default status

$sql = "INSERT INTO camp_customers (name, created_by, status) VALUES (?,  ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'customer added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add customer']);
}

$stmt->close();
$conn->close();
?>