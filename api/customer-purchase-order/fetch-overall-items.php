<?php
include('../config.php');

header("Content-Type: application/json");

$customer_purchase_order_number = $_REQUEST['customer_purchase_order_id'];

$query = "SELECT * FROM camp_customer_purchase_orders WHERE po_number = '".$customer_purchase_order_number."' AND isActive='active' ORDER BY id DESC";
$sql = mysqli_query($conn, $query);

if ($sql->num_rows > 0) {
    $row = $sql->fetch_assoc();

    $customer_purchase_order_id = $row['id'];
    $boq_id = $row['boq_id'];

    // Fetch customer purchase order details
    $cust_po_details_query = "SELECT COUNT(1) as total FROM `camp_customer_purchase_order_items` WHERE customer_purchase_orders_id='".$customer_purchase_order_id."'";
    $cust_po_details_sql = mysqli_query($conn, $cust_po_details_query); // FIXED: Changed $con to $conn
    $cust_po_details_sql_result = mysqli_fetch_assoc($cust_po_details_sql);
    $total_details_records = $cust_po_details_sql_result['total'];

    // Initialize array to avoid "Undefined variable" error
    $boqData = [];

    // Fetch BOQ items
    $boq_query = "SELECT * FROM `camp_boq_items` WHERE boq_id = $boq_id";
    $boq_sql = mysqli_query($conn, query: $boq_query);
    
    while ($boq_sql_result = mysqli_fetch_assoc($boq_sql)) {
        $spare_name = $boq_sql_result['spare_name'];
        $quantity = $boq_sql_result['quantity'] * $total_details_records;
        $unit_price = $boq_sql_result['unit_price'];
        $category = $boq_sql_result['category'];

        $boqData[] = ['spare_name' => $spare_name, 'quantity' => $quantity,'unit_price' => $unit_price,'category'=>$category];
    }

    // Send response
    $data = ['status' => 'success', 'isCustomerPurchaseOrder'=>1,'customerPurchaseOrderId'=>$customer_purchase_order_id,
    'customerPurchaseOrderNumber'=>$customer_purchase_order_number,'products' => $boqData];
    echo json_encode($data);
} else {
    // Send response for no data found
    echo json_encode(['status' => 'error', 'message' => 'No records found', 'products' => []]);
}
?>
