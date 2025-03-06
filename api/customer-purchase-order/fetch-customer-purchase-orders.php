<?php
include('../config.php');
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Fetch all customer purchase orders
$sql = "SELECT 
            cpo.id, 
            cpo.po_number, 
            cpo.customer_id, 
            c.name as customer_name, 
            cpo.bank_id, 
            b.name as bank_name,
            cpo.order_received_date, 
            cpo.created_at, 
            cpo.status
        FROM camp_customer_purchase_orders AS cpo
        JOIN camp_customers AS c ON cpo.customer_id = c.id
        JOIN camp_banks AS b ON cpo.bank_id = b.id
        WHERE cpo.isActive = 'active'
        ORDER BY cpo.created_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            "id" => $row["id"],
            "po_number" => $row["po_number"],
            "customer_name" => $row["customer_name"],
            "bank_name" => $row["bank_name"],
            "order_received_date" => $row["order_received_date"],
            "created_at" => $row["created_at"],
            "status" => $row["status"]
        ];
    }
    echo json_encode(["status" => "success", "orders" => $orders]);
} else {
    echo json_encode(["status" => "error", "message" => "No purchase orders found"]);
}

$conn->close();
?>
