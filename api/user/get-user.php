<?php
include('../config.php');

header('Content-Type: application/json');

$userId = $_GET['id'];

$sql = "SELECT * FROM camp_users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'user not found']);
}

$stmt->close();
$conn->close();
?>