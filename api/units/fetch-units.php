<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_units";
$result = $conn->query($sql);

$units = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $units[] = $row;
    }
}

echo json_encode(['success' => true, 'units' => $units]);

$conn->close();
?>