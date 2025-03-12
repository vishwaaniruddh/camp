<?php
include('../config.php');

header('Content-Type: application/json');

$stateId = $_GET['id'];

$sql = "SELECT * FROM camp_states WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stateId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $state = $result->fetch_assoc();
    echo json_encode(['success' => true, 'state' => $state]);
} else {
    echo json_encode(['success' => false, 'message' => 'state not found']);
}

$stmt->close();
$conn->close();
?>