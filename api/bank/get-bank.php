<?php
include('../config.php');

header('Content-Type: application/json');

$bankId = $_GET['id'];

$sql = "SELECT * FROM camp_banks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bankId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bank = $result->fetch_assoc();
    echo json_encode(['success' => true, 'bank' => $bank]);
} else {
    echo json_encode(['success' => false, 'message' => 'bank not found']);
}

$stmt->close();
$conn->close();
?>