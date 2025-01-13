<?php
include('../config.php');

header('Content-Type: application/json');

$unitId = $_POST['unit_id'];
$unitname = $_POST['unitname'];
$slug = $_POST['slug'];
$status = $_POST['status'];

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

// Update the unit
$updateSql = "UPDATE camp_units SET unitname = ?, slug = ?, status = ? WHERE id = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("ssii", $unitname, $slug, $status, $unitId);

if ($stmt->execute()) {
    // Fetch the new state
    $newStateSql = "SELECT * FROM camp_units WHERE id = ?";
    $stmt = $conn->prepare($newStateSql);
    $stmt->bind_param("i", $unitId);
    $stmt->execute();
    $newStateResult = $stmt->get_result();
    $newState = $newStateResult->fetch_assoc();
    $stmt->close();

    logChange($conn, 'camp_units', $unitId, json_encode($previousState), json_encode($newState), 'current_user', 'update');

    echo json_encode(['success' => true, 'message' => 'Unit updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update unit']);
}

$stmt->close();
$conn->close();
?>