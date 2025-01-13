<?php
include('../config.php');

header('Content-Type: application/json');


$inputData = json_decode(file_get_contents('php://input'), true);


if (!isset($inputData['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$unitId = $inputData['id'];

// Fetch the previous state
$previousStateSql = "SELECT * FROM camp_units WHERE id = ?";
$stmt = $conn->prepare($previousStateSql);
$stmt->bind_param("i", $unitId);
$stmt->execute();
$previousStateResult = $stmt->get_result();
$previousState = $previousStateResult->fetch_assoc();
$stmt->close();

if (!$previousState) {
    echo json_encode(['success' => false, 'message' => 'Unit not found']);
    exit;
}

// Mark the unit as deleted
$deleteSql = "UPDATE camp_units SET status = 'deleted' WHERE id = ?";
$stmt = $conn->prepare($deleteSql);
$stmt->bind_param("i", $unitId);

if ($stmt->execute()) {
    // Fetch the new state
    $newStateSql = "SELECT * FROM camp_units WHERE id = ?";
    $stmtNew = $conn->prepare($newStateSql);
    $stmtNew->bind_param("i", $unitId);
    $stmtNew->execute();
    $newStateResult = $stmtNew->get_result();
    $newState = $newStateResult->fetch_assoc();
    $stmtNew->close();

    // Log the change
    logChange($conn, 'camp_units', $unitId, json_encode($previousState), json_encode($newState), 'current_user', 'delete');

    echo json_encode(['success' => true, 'message' => 'Unit deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete unit']);
}

$stmt->close();
$conn->close();
?>