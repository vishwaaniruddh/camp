<?php
include('../config.php');

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $unitId = $_GET['id'];

    $sql = "SELECT * FROM camp_units WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $unitId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $unit = $result->fetch_assoc();
        echo json_encode(['success' => true, 'unit' => $unit]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Unit not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Unit ID is required']);
}

$conn->close();
?>