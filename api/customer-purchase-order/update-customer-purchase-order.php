<?php
header("Content-Type: application/json");
require_once("../config.php"); // Include your DB connection

$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($data["purchase_order_id"], $data["po_number"], $data["order_received_date"], 
          $data["customer_id"], $data["bank_id"], $data["boq_id"])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    exit;
}

$purchase_order_id = intval($data["purchase_order_id"]);
$po_number = $data["po_number"];
$order_received_date = $data["order_received_date"];
$customer_id = intval($data["customer_id"]);
$bank_id = intval($data["bank_id"]);
$boq_id = intval($data["boq_id"]);
$notes = isset($data["notes"]) ? $data["notes"] : "";

// Start transaction
$conn->begin_transaction();

try {
    // Update the main Purchase Order record
    $sql_update_po = "UPDATE camp_customer_purchase_orders 
                      SET po_number = ?, order_received_date = ?, customer_id = ?, 
                          bank_id = ?, boq_id = ?, notes = ?
                      WHERE id = ?";
    
    $stmt = $conn->prepare($sql_update_po);
    $stmt->bind_param("sssissi", $po_number, $order_received_date, $customer_id, 
                      $bank_id, $boq_id, $notes, $purchase_order_id);
    $stmt->execute();

    // Delete existing items related to this purchase order
    $sql_delete_items = "DELETE FROM camp_customer_purchase_order_items WHERE customer_purchase_orders_id = ?";
    $stmt = $conn->prepare($sql_delete_items);
    $stmt->bind_param("i", $purchase_order_id);
    $stmt->execute();

    // Insert updated items
    if (!empty($data["items"])) {
        $sql_insert_items = "INSERT INTO camp_customer_purchase_order_items 
                            (customer_purchase_orders_id, atm_id, address, remarks) 
                            VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql_insert_items);
        
        foreach ($data["items"] as $item) {
            $atm_id = $item["atm_id"];
            $address = isset($item["address"]) ? $item["address"] : "N/A";
            $remarks = isset($item["remarks"]) ? $item["remarks"] : "N/A";
            
            $stmt->bind_param("isss", $purchase_order_id, $atm_id, $address, $remarks);
            $stmt->execute();
        }
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Purchase Order updated successfully."]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Failed to update purchase order: " . $e->getMessage()]);
}

$conn->close();
?>
