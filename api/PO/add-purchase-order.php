<?php
include('../config.php');

header('Content-Type: application/json');
$data = $_REQUEST;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$data) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
    exit;
}



$requiredFields = ['po_number', 'vendor_id', 'order_date', 'product_name'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
        exit;
    }
}

if (isset($data['isCustomerPurchaseOrder'])) {

    $isCustomerPurchaseOrder = $data['isCustomerPurchaseOrder'];
    $customerPurchaseOrderId = $data['customerPurchaseOrderId'];
    $customerPurchaseOrderNumber = $data['customerPurchaseOrderNumber'];
} else {
    $isCustomerPurchaseOrder = null;
    $customerPurchaseOrderId = null;
    $customerPurchaseOrderNumber = null;
}


// Extract data
$po_number = mysqli_real_escape_string($con, $data['po_number']);
$vendor_id = $data['vendor_id'];
$notes = isset($data['notes']) ? mysqli_real_escape_string($con, $data['notes']) : null;
$products = $data['product_name'];

$order_date = $data['order_date'];

$expected_delivery_date = $data['expected_delivery_date'];
$total_cost = $data['total_cost'];


mysqli_begin_transaction($con);

try {

    $insertPoQuery = "INSERT INTO camp_purchase_orders_new (po_number, order_date, expected_delivery_date, total_amount, created_at, po_date, notes, vendor,isCustomerPurchaseOrder,customerPurchaseOrderId,customerPurchaseOrderNumber) 
                      VALUES ('$po_number','" . $order_date . "',
                      '$expected_delivery_date','$total_cost','" . $datetime . "','" . $datetime . "','" . $notes . "','" . $vendor_id . "','" . $isCustomerPurchaseOrder . "','" . $customerPurchaseOrderId . "','" . $customerPurchaseOrderNumber . "')";

    if (!mysqli_query($con, $insertPoQuery)) {
        throw new Exception('Error inserting purchase order: ' . mysqli_error($con));
    }


    $po_id = mysqli_insert_id($con);

    $product_names = $data['product_name'];
    // $model_names = explode('-', $data['product_name'])[1];

    $quantitys = $data['quantity'];
    $unit_costs = $data['unit_cost'];




    $counter = 0;
    foreach ($product_names as $product) {


        $product_names = explode('  ---  ', $product)[0];
        $model_name = explode('  ---  ', $product)[1];

        $quantity = $quantitys[$counter];
        $unit_cost = $unit_costs[$counter];


        $insertProductQuery = "INSERT INTO camp_po_items (po_id, product_name, model_name, quantity, unit_price, receivedQuantity, receivedStatus, notes) 
        VALUES ($po_id, '$product_names', '$model_name', $quantity, $unit_cost, 0, 'Pending', '')";

        if (!mysqli_query($con, $insertProductQuery)) {
            throw new Exception('Error inserting product: ' . mysqli_error($con));
        }

        $po_item_id = mysqli_insert_id($con);


        $counter++;
    }


    mysqli_commit($con);


    echo json_encode(['status' => 'success', 'message' => 'Purchase order created successfully!', 'po_id' => $po_id]);

} catch (Exception $e) {

    mysqli_rollback($con);


    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>