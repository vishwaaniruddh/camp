<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_branchs limit 100";
$result = $conn->query($sql);

$branchs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branchs[] = $row;
    }
}

echo json_encode(['success' => true, 'branchs' => $branchs]);

$conn->close();
?>