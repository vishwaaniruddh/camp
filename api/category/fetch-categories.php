<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_categories";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode(['success' => true, 'categories' => $categories]);

$conn->close();
?>