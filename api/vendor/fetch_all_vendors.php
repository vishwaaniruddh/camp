<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_vendors limit 100";
$result = $conn->query($sql);

$vendors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vendors[] = $row;
    }
}

echo json_encode(['success' => true, 'vendors' => $vendors]);

$conn->close();
?>