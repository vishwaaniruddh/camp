<?php
include('../config.php');

header('Content-Type: application/json');

$name = $_POST['name'];
$created_by = $userid;
$status = 'active'; // Default status

$sql = "INSERT INTO camp_banks (name, created_by, status) VALUES (?,  ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'bank added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add bank']);
}

$stmt->close();
$conn->close();
?>