<?php
include('../config.php');

header('Content-Type: application/json');


$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$courierId = $inputData['id'];

// Fetch the previous state
$previousStateSql = "SELECT * FROM camp_couriers WHERE id = ?";
$stmt = $conn->prepare($previousStateSql);
$stmt->bind_param("i", $courierId);
$stmt->execute();
$previousStateResult = $stmt->get_result();
$previousState = $previousStateResult->fetch_assoc();
$stmt->close();

if (!$previousState) {
    echo json_encode(['success' => false, 'message' => 'courier not found']);
    exit;
}

// Mark the courier as deleted
$deleteSql = "UPDATE camp_couriers SET status = 'deleted' WHERE id = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $courierId);

if ($stmt->execute()) {
    // Fetch the new state
    $newStateSql = "SELECT * FROM camp_couriers WHERE id = ?";
    $stmtNew = $conn->prepare($newStateSql);
    $stmtNew->bind_param("i", $courierId);
    $stmtNew->execute();
    $newStateResult = $stmtNew->get_result();
    $newState = $newStateResult->fetch_assoc();
    $stmtNew->close();

    // Log the change
    logChange($conn, 'camp_couriers', $courierId, json_encode($previousState), json_encode($newState), 'current_user', 'delete');

    echo json_encode(['success' => true, 'message' => 'courier deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete courier']);
}

$stmt->close();
$conn->close();
?>