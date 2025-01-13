<?php
include('../config.php');

header('Content-Type: application/json');

$unitname = $_POST['unitname'];
$slug = $_POST['slug'];
$status = $_POST['status'];

$sql = "INSERT INTO camp_units (unitname, slug, status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $unitname, $slug, $status);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Unit added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add unit']);
}

$stmt->close();
$conn->close();
?>