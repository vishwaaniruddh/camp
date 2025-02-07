<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_couriers";
$result = $conn->query($sql);

$couriers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $couriers[] = $row;
    }
}

echo json_encode(['success' => true, 'couriers' => $couriers]);

$conn->close();
?>