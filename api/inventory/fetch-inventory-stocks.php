<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Fetch products from camp_inventory table
$query = "SELECT * FROM camp_inventory";
$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch inventory stocks']);
    exit();
}

$inventoryStocks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $inventoryStocks[] = $row;
}

echo json_encode(['status' => 'success', 'products' => $inventoryStocks]);

mysqli_close($con);
?>