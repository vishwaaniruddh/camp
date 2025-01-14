<?php
include('../config.php');
header('Content-Type: application/json');



// Get the JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['id']) || !isset($data['name']) || !isset($data['email']) || !isset($data['phoneno']) || !isset($data['address']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}


$vendorId = $data['id'];
$vendorName = $data['name'];
$vendorEmail = $data['email'];
$vendorPhone = $data['phoneno'];
$vendorAddress = $data['address'];
$vendorStatus = $data['status'];
$vendorGstin = $data['gstin'];
$user = 1; // Replace with actual user identification logic

// Fetch the previous state
$previousStateSql = "SELECT * FROM camp_vendors WHERE id = $vendorId";
$previousStateResult = $conn->query($previousStateSql);
$previousState = $previousStateResult->fetch_assoc();

// Update the vendor
$updateSql = "UPDATE camp_vendors SET 
    name = '$vendorName', 
    email = '$vendorEmail', 
    phone = '$vendorPhone', 
    address = '$vendorAddress', 
    status = '$vendorStatus',
    gstin = '$vendorGstin'
    WHERE id = $vendorId";

if ($conn->query($updateSql) === TRUE) {
    // Fetch the new state
    $newStateSql = "SELECT * FROM camp_vendors WHERE id = $vendorId";
    $newStateResult = $conn->query($newStateSql);
    $newState = $newStateResult->fetch_assoc();

    // Log the change
    logChange($conn, 'camp_vendors', $vendorId, $previousState, $newState, $user, 'update');

    echo json_encode(['success' => true, 'message' => 'Vendor updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update vendor']);
}

$conn->close();
?>