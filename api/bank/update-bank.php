<?php
include('../config.php');

header('Content-Type: application/json');

$bankId = $_POST['bank_id'];
$name = $_POST['name'];
$status = $_POST['bank_status'];

$sql = "UPDATE camp_banks SET name = ?,  status = ?  WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $status, $bankId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'bank updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update bank']);
}

$stmt->close();
$conn->close();
?>