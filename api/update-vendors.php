<?php
include('./config.php');
header('Content-Type: application/json');



// Get the JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['id']) || !isset($data['name']) || !isset($data['email']) || !isset($data['phone']) || !isset($data['address']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$address = $conn->real_escape_string($data['address']);
$status = $conn->real_escape_string($data['status']);

// Update the vendor data
 $sql = "UPDATE camp_vendors SET name='$name', email='$email', phone='$phone', address='$address', status='$status' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Vendor updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating vendor: ' . $conn->error]);
}

$conn->close();
?>