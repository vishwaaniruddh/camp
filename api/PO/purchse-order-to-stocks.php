<?php
include('../config.php'); // Include your database configuration file

header('Content-Type: application/json');

$camp_po_items_details_id = $_REQUEST['id'];
$isReceived = $_REQUEST['isReceived'];
$receivedDate = $_REQUEST['receivedDate'];
$serial_number = $_REQUEST['serialNumber'];

try {
    // Start a transaction
    mysqli_begin_transaction($con);

    // Update camp_po_items_details table
    $query = "UPDATE camp_po_items_details SET 
                isReceived = ?, 
                receivedDate = ?, 
                serial_number = ? 
              WHERE id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $isReceived, $receivedDate, $serial_number, $camp_po_items_details_id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error updating camp_po_items_details: ' . mysqli_error($con));
    }
    mysqli_stmt_close($stmt); // Close the statement

    // Fetch po_item_id from camp_po_items_details
    $get_camp_po_items_details_sql = "SELECT po_item_id FROM camp_po_items_details WHERE id = ?";
    $stmt = mysqli_prepare($con, $get_camp_po_items_details_sql);
    mysqli_stmt_bind_param($stmt, "i", $camp_po_items_details_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $get_camp_po_items_details_row = mysqli_fetch_assoc($result);
    $po_item_id = $get_camp_po_items_details_row['po_item_id'];
    mysqli_stmt_close($stmt);

    // If received, check for existing inventory record
    if ($isReceived === 'yes') {
        $check_inventory_sql = "SELECT id FROM camp_inventory WHERE po_item_detail_id = ?";
        $stmt = mysqli_prepare($con, $check_inventory_sql);
        mysqli_stmt_bind_param($stmt, "i", $camp_po_items_details_id);
        mysqli_stmt_execute($stmt);
        $check_inventory_result = mysqli_stmt_get_result($stmt);
        $inventory_exists = mysqli_fetch_assoc($check_inventory_result);
        mysqli_stmt_close($stmt);

        if ($inventory_exists) {
            // If record exists, UPDATE it
            $update_inventory_sql = "UPDATE camp_inventory SET serial_number = ? WHERE po_item_detail_id = ?";
            $stmt = mysqli_prepare($con, $update_inventory_sql);
            mysqli_stmt_bind_param($stmt, "si", $serial_number, $camp_po_items_details_id);
        } else {
            // Fetch product details from camp_po_items
            $get_product_sql = "SELECT product_name, model_name, unit_price FROM camp_po_items WHERE po_item_id = ?";
            $stmt = mysqli_prepare($con, $get_product_sql);
            mysqli_stmt_bind_param($stmt, "i", $po_item_id);
            mysqli_stmt_execute($stmt);
            $product_result = mysqli_stmt_get_result($stmt);
            $get_product_row = mysqli_fetch_assoc($product_result);
            mysqli_stmt_close($stmt);

            // Insert new record into camp_inventory
            $product_name = $get_product_row['product_name'];
            $product_model = $get_product_row['model_name'];
            $unit_price = $get_product_row['unit_price'];
            $working_status = 'Working';
            $not_working_type = '';
            $non_repairable_reason = '';
            $material_tag = 'New';
            $entry_date = date("Y-m-d H:i:s");
            $status = 'Available';
            $remarks = '';
            $atmid = '';

            $insert_inventory_sql = "INSERT INTO camp_inventory 
                (product_name, product_model, serial_number, unit_price, working_status, not_working_type, 
                 non_repairable_reason, material_tag, entry_date, po_item_id, status, remarks, atmid, po_item_detail_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $insert_inventory_sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sssdsdsssssssi",
                $product_name,
                $product_model,
                $serial_number,
                $unit_price,
                $working_status,
                $not_working_type,
                $non_repairable_reason,
                $material_tag,
                $entry_date,
                $po_item_id,
                $status,
                $remarks,
                $atmid,
                $camp_po_items_details_id
            );
        }

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error inserting/updating inventory: ' . mysqli_error($con));
        }
        mysqli_stmt_close($stmt);
    }

    // Get total received quantity from camp_inventory
    $get_total_received_sql = "SELECT COUNT(*) as totalReceivedQuantity FROM camp_inventory WHERE po_item_id = ?";
    $stmt = mysqli_prepare($con, $get_total_received_sql);
    mysqli_stmt_bind_param($stmt, "i", $po_item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $total_received = mysqli_fetch_assoc($result)['totalReceivedQuantity'];
    mysqli_stmt_close($stmt);

    // Update receivedQuantity in camp_po_items
    $update_po_items_sql = "UPDATE camp_po_items SET receivedQuantity = ? WHERE po_item_id = ?";
    $stmt = mysqli_prepare($con, $update_po_items_sql);
    mysqli_stmt_bind_param($stmt, "ii", $total_received, $po_item_id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Error updating receivedQuantity in camp_po_items: ' . mysqli_error($con));
    }
    mysqli_stmt_close($stmt);

    // Commit transaction if everything is successful
    mysqli_commit($con);

    echo json_encode(['status' => 'success', 'message' => 'Purchase order updated successfully!']);
} catch (Exception $e) {
    // Rollback on failure
    mysqli_rollback($con);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>