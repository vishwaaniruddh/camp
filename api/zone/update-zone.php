<?php
include('../config.php');

header('Content-Type: application/json');

$zoneId = $_POST['zone_id'];
$name = $_POST['name'];
$status = $_POST['zone_status'];

$sql = "UPDATE camp_zones SET name = ?,  status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $status, $zoneId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'zone updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update zone']);
}

$stmt->close();
$conn->close();
?>