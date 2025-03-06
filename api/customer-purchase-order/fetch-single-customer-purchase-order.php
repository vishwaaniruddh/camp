<?php
header("Content-Type: application/json");
require_once("../config.php"); // Include your DB connection




$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data["purchase_order_id"])) {
    echo json_encode(["status" => "error", "message" => "purchase_order_id is required"]);
    exit;
}

$purchase_order_id = intval($data["purchase_order_id"]);

$sql = "SELECT cpo.*, c.name AS customer_name, b.name AS bank_name 
        FROM camp_customer_purchase_orders cpo
        JOIN camp_customers c ON cpo.customer_id = c.id
        JOIN camp_banks b ON cpo.bank_id = b.id
        WHERE cpo.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $purchase_order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();

    // Fetch associated items
    $sql_items = "SELECT * FROM camp_customer_purchase_order_items WHERE customer_purchase_orders_id = ?";
    $stmt_items = $conn->prepare($sql_items);
    $stmt_items->bind_param("i", $purchase_order_id);
    $stmt_items->execute();
    $items_result = $stmt_items->get_result();
    $order["items"] = $items_result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["status" => "success", "order" => $order]);
} else {
    echo json_encode(["status" => "error", "message" => "Order not found"]);
}
?>
