<?php
include('../config.php');

header('Content-Type: application/json');

$zoneId = $_GET['id'];

$sql = "SELECT * FROM camp_zones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $zoneId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $zone = $result->fetch_assoc();
    echo json_encode(['success' => true, 'zone' => $zone]);
} else {
    echo json_encode(['success' => false, 'message' => 'zone not found']);
}

$stmt->close();
$conn->close();
?>