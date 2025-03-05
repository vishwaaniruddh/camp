<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_customers";
$result = $conn->query($sql);

$customers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

echo json_encode(['success' => true, 'customers' => $customers]);

$conn->close();
?>