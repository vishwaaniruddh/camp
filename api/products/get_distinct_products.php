<?php
include('../config.php');
header('Content-Type: application/json');
// var_dump($_REQUEST);

$inputData = json_decode(file_get_contents('php://input'), true);
if(!$inputData){
    $inputData = $_REQUEST; 
}
$po_number = $inputData['po_number'];

$sql = "select boq_id from camp_customer_purchase_orders where po_number = ? order by id desc limit 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $po_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $results = $result->fetch_assoc();
    $boq_id = $results['boq_id'];

    $boq_sql = "SELECT distinct(category) as category from camp_boq_items where boq_id = ?";
    $boq_stmt = $conn->prepare($boq_sql);
    $boq_stmt->bind_param("i", $boq_id);
    $boq_stmt->execute();
    $boq_result = $boq_stmt->get_result();
    $categories = [];
    while ($row = $boq_result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode(['success' => true, 'products' => $categories]);
}



