<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Fetch distinct products and their models from camp_inventory table
$query = "SELECT DISTINCT CONCAT(product_name, ' - ', product_model) AS product_model FROM camp_inventory";
$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch distinct products and models']);
    exit();
}

$distinctProducts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $distinctProducts[] = $row['product_model'];
}

echo json_encode(['status' => 'success', 'data' => $distinctProducts]);

mysqli_close($con);
?>