<?php
include('../config.php');

header('Content-Type: application/json');

$customerId = $_GET['id'];

$sql = "SELECT * FROM camp_customers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    echo json_encode(['success' => true, 'customer' => $customer]);
} else {
    echo json_encode(['success' => false, 'message' => 'customer not found']);
}

$stmt->close();
$conn->close();
?>