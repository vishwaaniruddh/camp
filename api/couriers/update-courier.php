<?php
include('../config.php');

header('Content-Type: application/json');

if (!isset($_REQUEST['courier_id']) || !isset($_REQUEST['couriername']) || !isset($_REQUEST['slug']) || !isset($_REQUEST['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$courierId = $_REQUEST['courier_id'];
$couriername = $_REQUEST['couriername'];
$slug = $_REQUEST['slug'];
$status = $_REQUEST['status'];

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

// Update the courier
$updateSql = "UPDATE camp_couriers SET couriername = ?, slug = ?, status = ? WHERE id = ?";
$stmt = $conn->prepare($updateSql);
$stmt->bind_param("sssi", $couriername, $slug, $status, $courierId);

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
    logChange($conn, 'camp_couriers', $courierId, json_encode($previousState), json_encode($newState), 'current_user', 'update');

    echo json_encode(['success' => true, 'message' => 'courier updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update courier']);
}

$stmt->close();
$conn->close();
?>