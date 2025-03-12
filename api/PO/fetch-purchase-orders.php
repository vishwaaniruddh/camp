<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Initialize filters
$vendor = isset($_GET['vendor']) ? $_GET['vendor'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Build the query with filters
$query = "SELECT * FROM camp_purchase_orders_new WHERE 1=1";

if ($vendor) {
    $query .= " AND vendor = '" . mysqli_real_escape_string($conn, $vendor) . "'";
}

if ($status) {
    $query .= " AND status = '" . mysqli_real_escape_string($conn, $status) . "'";
}

if ($from_date) {
    $query .= " AND order_date >= '" . mysqli_real_escape_string($conn, $from_date) . "'";
}

if ($to_date) {
    $query .= " AND order_date <= '" . mysqli_real_escape_string($conn, $to_date) . "'";
}

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch purchase orders']);
    exit();
}

$purchaseOrders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $purchaseOrders[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $purchaseOrders]);
?>