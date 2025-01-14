<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_products WHERE status = 'active'";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode(['success' => true, 'products' => $products]);

$conn->close();
?>