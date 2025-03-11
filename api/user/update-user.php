<?php
include('../config.php');

header('Content-Type: application/json');

$userId = $_POST['user_id'];
$name = $_POST['name'];
$status = $_POST['user_status'];

$sql = "UPDATE camp_users SET name = ?,  status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $status, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'user updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user']);
}

$stmt->close();
$conn->close();
?>