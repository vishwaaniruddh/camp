<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Get the product ID from the query string
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit();
}

// Fetch product information from camp_inventory table
$query = "SELECT * FROM camp_inventory WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode(['success' => true, 'product' => $product]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
}

$stmt->close();
$con->close();
?>