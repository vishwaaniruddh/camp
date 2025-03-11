<?php
include('../config.php');

header('Content-Type: application/json');

$sql = "SELECT * FROM camp_users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode(['success' => true, 'users' => $users]);

$conn->close();
?>