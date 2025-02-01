<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$product_name = $data['product_name'];
$product_model = $data['product_model'];
$serial_number = $data['serial_number'];
$unit_price = $data['unit_price'];
$working_status = $data['working_status'];
$not_working_type = isset($data['not_working_type']) ? $data['not_working_type'] : null;
$non_repairable_reason = isset($data['non_repairable_reason']) ? $data['non_repairable_reason'] : null;
$material_tag = $data['material_tag'];
$status = $data['status'];
$remarks = isset($data['remarks']) ? $data['remarks'] : null;

if($working_status=='Working'){
    $not_working_type = '';
    $non_repairable_reason = '';
}
// Validate input
if (empty($id) || empty($product_name) || empty($product_model) || empty($serial_number) || empty($unit_price) || empty($working_status) || empty($material_tag) || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Update the product information in the database
$query = "UPDATE camp_inventory SET product_name = ?, product_model = ?, serial_number = ?, unit_price = ?, working_status = ?, not_working_type = ?, non_repairable_reason = ?, material_tag = ?, status = ?, remarks = ? WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('ssssssssssi', $product_name, $product_model, $serial_number, $unit_price, $working_status, $not_working_type, $non_repairable_reason, $material_tag, $status, $remarks, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product information updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product information']);
}

$stmt->close();
$con->close();
?>