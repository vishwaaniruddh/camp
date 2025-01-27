<?php
include('../config.php');

header('Content-Type: application/json');

$product_id = $_GET['id'];

$sql = "SELECT * FROM camp_products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Fetch serial numbers
    $sql_serials = "SELECT serial_number FROM camp_product_serials WHERE product_id = ?";
    $stmt_serials = $conn->prepare($sql_serials);
    $stmt_serials->bind_param("i", $product_id);
    $stmt_serials->execute();
    $result_serials = $stmt_serials->get_result();

    $serial_numbers = [];
    while ($row_serials = $result_serials->fetch_assoc()) {
        $serial_numbers[] = $row_serials['serial_number'];
    }
    $stmt_serials->close();

    $product['serial_numbers'] = $serial_numbers;

    echo json_encode(['success' => true, 'product' => $product]);
} else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
}

$stmt->close();
$conn->close();
?>