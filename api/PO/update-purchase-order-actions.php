<?php
header('Content-Type: application/json');
include('../config.php');

// Get raw JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit;
}

$request_id = $data['request_id'] ?? null;
$approvalStatus = $data['approvalStatus'] ?? null;

if (!$request_id || !$approvalStatus) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing required parameters"]);
    exit;
}

$con->begin_transaction();

try {
    // Update purchase order status
    $updateQuery = "UPDATE camp_purchase_orders_new SET status = ? WHERE po_id = ?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("si", $approvalStatus, $request_id);
    if (!$stmt->execute()) {
        throw new Exception("Error updating purchase order status: " . $stmt->error);
    }
    $stmt->close();

    if ($approvalStatus === 'Approved') {
        $itemsQuery = "SELECT po_item_id, quantity FROM camp_po_items WHERE po_id = ?";
        $stmt = $con->prepare($itemsQuery);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $po_item_id = $row['po_item_id'];
            $quantity = (int)$row['quantity'];
            $itemDetailsQuery = "INSERT INTO camp_po_items_details (po_item_id, po_id, isReceived, receivedDate, serial_number, isActive) 
                                VALUES (?, ?, 'no', '', '', 'yes')";
            $stmt = $con->prepare($itemDetailsQuery);
            for ($i = 0; $i < $quantity; $i++) {
                $stmt->bind_param("ii", $po_item_id, $request_id);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting product details: " . $stmt->error);
                }
            }
            $stmt->close();
        }
    }
    
    $con->commit();
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Purchase order updated successfully"]);
} catch (Exception $e) {
    $con->rollback();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$con->close();
?>
