<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

$po_id = $data['po_id'];
$po_number = $data['po_number'];
$status = $data['status'];
$notes = isset($data['notes']) ? $data['notes'] : '';
$quantity = isset($data['quantity']) ? $data['quantity'] : '';
$itemkey = $data['itemkey'];

// Validate input
if (empty($po_id) || empty($po_number) || empty($status) || empty($itemkey)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Update the purchase order item status in the database
$query = "UPDATE camp_po_items SET receivedStatus = ?, receivedQuantity = ?, notes = ? WHERE po_id = ? AND po_item_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('sssis', $status, $quantity, $notes, $po_id, $itemkey);

if ($stmt->execute()) {
    // If status is fully received, insert into camp_inventory
    if ($status === 'Fully Received') {
        $item_query = "SELECT * FROM camp_po_items WHERE po_item_id = ?";
        $item_stmt = $con->prepare($item_query);
        $item_stmt->bind_param('i', $itemkey);
        $item_stmt->execute();
        $item_result = $item_stmt->get_result();
        $item = $item_result->fetch_assoc();
        $working_status = 'Working';
        $material_tag = 'New';
        $status='Available';

        if ($item) {
            for ($i = 0; $i < $quantity; $i++) {
                $inventory_query = "INSERT INTO camp_inventory (product_name, product_model, serial_number, unit_price, working_status, material_tag, po_item_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $inventory_stmt = $con->prepare($inventory_query);
                $serial_number = uniqid(); // Generate a unique serial number
                $inventory_stmt->bind_param('sssdssis', $item['product_name'], $item['model_name'], $serial_number, $item['unit_price'], $working_status,$material_tag, $itemkey,$status);
                $inventory_stmt->execute();
            }
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
}

$stmt->close();
$con->close();
?>