<?php
include('../config.php');

header('Content-Type: application/json');
$data = $_REQUEST;

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
// var_dump($data);
// return ; 

// Extract data
$po_number = mysqli_real_escape_string($con, $data['po_number']);
$vendor_id = $data['vendor_id'];
$notes = isset($data['notes']) ? mysqli_real_escape_string($con, $data['notes']) : null;
$products = $data['product_name'];

$order_date = $data['order_date'];

$expected_delivery_date = $data['expected_delivery_date'];
$total_cost = $data['total_cost'];
$po_id = $data['po_id'];

mysqli_begin_transaction($con);

try {

    $updatePoQuery = "UPDATE camp_purchase_orders_new 
                  SET po_number = '$po_number',
                      order_date = '$order_date',
                      expected_delivery_date = '$expected_delivery_date',
                      total_amount = '$total_cost',
                      created_at = '$datetime',
                      po_date = '$datetime',
                      notes = '$notes',
                      vendor = '$vendor_id'
                  WHERE po_id = '$po_id'";


    // $insertPoQuery = "INSERT INTO camp_purchase_orders_new (po_number, order_date, expected_delivery_date, total_amount, created_at, po_date, notes, vendor) 
    //                   VALUES ('$po_number','" . $order_date . "',
    //                   '$expected_delivery_date','$total_cost','" . $datetime . "','" . $datetime . "','" . $notes . "','" . $vendor_id . "')";

    if (!mysqli_query($con, $updatePoQuery)) {
        throw new Exception('Error updating purchase order: ' . mysqli_error($con));
    }



    $product_names = $data['product_name'];
    // $model_names = explode('-', $data['product_name'])[1];

    $quantitys = $data['quantity'];
    $unit_costs = $data['unit_cost'];
    $item_id = $data['item_id'];



    $counter = 0;
    foreach ($item_id as $item_id_key => $item_id_val) {


        $product_names = explode('  ---  ', $product)[0];
        $model_name = explode('  ---  ', $product)[1];

        $quantity = $quantitys[$counter];
        $unit_cost = $unit_costs[$counter];

        if ($product_names && $model_name && $quantity && $unit_cost) {

            $updatePoItemsQuery = "update camp_po_items set product_name = '$product_names', 
            model_name = '$model_name', quantity = $quantity, unit_price = $unit_cost 
            where po_item_id = $item_id_val";

            if (!mysqli_query($con, $updatePoItemsQuery)) {
                throw new Exception('Error Updating Items: ' . mysqli_error($con));
            }
            $counter++;

        }


    }


    mysqli_commit($con);


    echo json_encode(['status' => 'success', 'message' => 'Purchase order created successfully!', 'po_id' => $po_id]);

} catch (Exception $e) {

    mysqli_rollback($con);


    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>