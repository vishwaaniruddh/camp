<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

$data = $_REQUEST;

if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input.']);
    exit;
}

// Validate required fields
$requiredFields = ['po_number', 'vendor_id', 'order_date', 'product_name'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400); // Bad Request
        echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
        exit;
    }
}

// Extract data
$po_number = mysqli_real_escape_string($con, $data['po_number']);
$vendor_id =  $data['vendor_id'];
$notes = isset($data['notes']) ? mysqli_real_escape_string($con, $data['notes']) : null;
$products = $data['product_name']; // This should be an array
$order_date = $data['order_date']; // This should be an array
$expected_delivery_date = $data['expected_delivery_date'];
$total_cost = $data['total_cost'];
// Begin a transaction
mysqli_begin_transaction($con);

try {
    // Insert into the purchase order table
    $insertPoQuery = "INSERT INTO camp_purchase_orders (
    
    po_number, order_date, expected_delivery_date, total_amount, created_at, po_date, notes, vendor) 
                      VALUES ('$po_number','".$order_date."',
                      '$expected_delivery_date','$total_cost','".$datetime."','".$datetime."','".$notes."','".$vendor_id."')";

    if (!mysqli_query($con, $insertPoQuery)) {
        throw new Exception('Error inserting purchase order: ' . mysqli_error($con));
    }

    // Get the inserted PO ID
    $po_id = mysqli_insert_id($con);

    $product_names = $data['product_name'];
    $model_names = $data['model_name'];
    $quantitys = $data['quantity'];
    $unit_costs =  $data['unit_cost'];



    // Insert products
    $counter = 0 ; 
    foreach ($products as $product) {


        
    $product_name = $product_names[$counter]  ; 
    $model_name = $model_names[$counter]  ; 
    $quantity = $quantitys[$counter]  ; 
    $unit_cost = $unit_costs[$counter]  ; 
    


       $insertProductQuery = "INSERT INTO camp_po_items (po_id, product_name, model_name, quantity, unit_price,total_price) 
                               VALUES ($po_id, '$product_name', '$model_name', $quantity, $unit_cost, $quantity * $unit_cost)";
        if (!mysqli_query($con, $insertProductQuery)) {
            throw new Exception('Error inserting product: ' . mysqli_error($con));
        }

        $counter++ ; 
    }

    // Commit the transaction
    mysqli_commit($con);

    // Respond with success
    echo json_encode(['status' => 'success', 'message' => 'Purchase order created successfully!', 'po_id' => $po_id]);

} catch (Exception $e) {
    // Rollback the transaction on error
    mysqli_rollback($con);

    // Respond with an error message
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
