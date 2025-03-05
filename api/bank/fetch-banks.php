<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_banks";
$result = $conn->query($sql);

$banks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $banks[] = $row;
    }
}

echo json_encode(['success' => true, 'banks' => $banks]);

$conn->close();
?>