<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

$po_id = $_REQUEST['po_id'];

$query = "SELECT b.id,a.product_name,a.model_name ,b.isReceived,b.receivedDate, b.serial_number from 
camp_po_items a INNER JOIN camp_po_items_details b ON a.po_item_id = b.po_item_id 
where a.po_id='".$po_id."'";


$sql = mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($sql)){
    $data[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $data]);
