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


$branchId = $data['id'];
$branchName = $data['name'];
$branchEmail = $data['email'];
$branchPhone = $data['phoneno'];
$branchAddress = $data['address'];
$branchStatus = $data['status'];
$branchGstin = $data['gstin'];
$user = 1; // Replace with actual user identification logic

// Fetch the previous state
$previousStateSql = "SELECT * FROM camp_branchs WHERE id = $branchId";
$previousStateResult = $conn->query($previousStateSql);
$previousState = $previousStateResult->fetch_assoc();

// Update the branch
$updateSql = "UPDATE camp_branchs SET 
    name = '$branchName', 
    email = '$branchEmail', 
    phone = '$branchPhone', 
    address = '$branchAddress', 
    status = '$branchStatus',
    gstin = '$branchGstin'
    WHERE id = $branchId";

if ($conn->query($updateSql) === TRUE) {
    // Fetch the new state
    $newStateSql = "SELECT * FROM camp_branchs WHERE id = $branchId";
    $newStateResult = $conn->query($newStateSql);
    $newState = $newStateResult->fetch_assoc();

    // Log the change
    logChange($conn, 'camp_branchs', $branchId, $previousState, $newState, $user, 'update');

    echo json_encode(['success' => true, 'message' => 'branch updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update branch']);
}

$conn->close();
?>