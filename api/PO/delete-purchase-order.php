<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);

// Initialize filters
$po_id = isset($inputData['id']) ? $inputData['id'] : '';

// Build the query with filters
$query = "update camp_purchase_orders set status='Deleted' where po_id='$po_id'";


$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to Update purchase orders']);
    exit();
}


echo json_encode(['status' => 'success']);
?>