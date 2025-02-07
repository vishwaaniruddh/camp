<?php
include('../config.php');

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $courierId = $_GET['id'];

    $sql = "SELECT * FROM camp_couriers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courierId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $courier = $result->fetch_assoc();
        echo json_encode(['success' => true, 'courier' => $courier]);
    } else {
        echo json_encode(['success' => false, 'message' => 'courier not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'courier ID is required']);
}

$conn->close();
?>