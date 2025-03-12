<?php
include('../config.php');

header('Content-Type: application/json');

$stateId = $_POST['state_id'];
$name = $_POST['name'];
$status = $_POST['state_status'];

$sql = "UPDATE camp_states SET name = ?,  status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $status, $stateId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'state updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update state']);
}

$stmt->close();
$conn->close();
?>