<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

$purchase_order = isset($_GET['purchase-order']) ? $_GET['purchase-order'] : '';
if($purchase_order){
    
    // Build the query with filters
    $query = "SELECT * FROM camp_purchase_orders WHERE po_number = '$purchase_order' order by po_id desc";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch purchase orders']);
        exit();
    }
    
    $purchaseOrders = [];
    if ($row = mysqli_fetch_assoc($result)) {


        $purchaseOrders = $row;
        $po_id = $row['po_id']; 

        $items_sql = mysqli_query($con,"SELECT * FROM `camp_po_items` where po_id='".$po_id."'");
        while($items_sql_result = mysqli_fetch_assoc($items_sql)){
            $product['name'][] = $items_sql_result['product_name']; 
            $product['model_name'][] = $items_sql_result['model_name']; 
            $product['quantity'][] = $items_sql_result['quantity']; 
            $product['unit_price'][] = $items_sql_result['unit_price']; 
        }



    }
    
    echo json_encode(['status' => 'success', 'po' => $purchaseOrders,'items' => $product]);
}else{
    echo json_encode(['status' => 'error', 'message' => 'No Purchase Order Provided']);
        exit();
}

?>