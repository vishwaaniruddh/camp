<?php
include('../config.php');

header('Content-Type: application/json');

// Read raw JSON input
// $inputData = json_decode(file_get_contents("php://input"), true);

$inputData = $_REQUEST ; 

if (!$inputData || !isset($inputData['name'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$name = $inputData['name'];
$created_by = $userid ?? 'default_user'; // Make sure $userid is defined
$status = 'active'; // Default status

$sql = "INSERT INTO camp_users (name, created_by, status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $created_by, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'user added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add user']);
}

$stmt->close();
$conn->close();
?>
