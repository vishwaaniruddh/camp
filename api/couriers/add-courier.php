<?php
include('../config.php');

header('Content-Type: application/json');

$couriername = $_POST['couriername'];

$status = $_POST['status'];

$sql = "INSERT INTO camp_couriers (couriername, status) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $couriername,  $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'courier added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add courier']);
}

$stmt->close();
$conn->close();
?>