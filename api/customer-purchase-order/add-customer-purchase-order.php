<?php
include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Invalid request"];

    $inputData = $_REQUEST ;

    $requiredFields = ['po_number', 'customer', 'bank', 'order_received_date', 'boq'];
    foreach ($requiredFields as $field) {

        if (!isset($inputData[$field]) || empty($inputData[$field])) {
            $response["message"] = "$field is required";
            echo json_encode($response);
            exit;
        }
    }

    $po_number = $inputData['po_number'];
    $customer_id = intval($inputData['customer']);
    $bank_id = intval($inputData['bank']);
    $order_received_date = $inputData['order_received_date'];
    $boq_id = intval($inputData['boq']);
    $notes = isset($inputData['notes']) ? $inputData['notes'] : null;


    $created_by = $userid;
    $created_by_name = $username; // Change accordingly

    // Fetch customer name
    $stmt = $conn->prepare("SELECT name FROM camp_customers WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer_name = ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : "Unknown";

    // Fetch bank name
    $stmt = $conn->prepare("SELECT name FROM camp_banks WHERE id = ?");
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bank_name = ($result->num_rows > 0) ? $result->fetch_assoc()['name'] : "Unknown";

    // Insert into camp_customer_purchase_orders
    $stmt = $conn->prepare("
        INSERT INTO camp_customer_purchase_orders (po_number, customer_id, customer_name, bank_id, bank_name, order_received_date, boq_id, notes, created_by, created_by_name) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sisssissss", $po_number, $customer_id, $customer_name, $bank_id, $bank_name, $order_received_date, $boq_id, $notes, $created_by, $username);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert PO Items if available
        if (isset($inputData['atm_id'], $inputData['address'], $inputData['remarks'])) {
            $atm_ids = $inputData['atm_id'];
            $addresses = $inputData['address'];
            $remarks = $inputData['remarks'];

            if (is_array($atm_ids) && is_array($addresses) && is_array($remarks)) {
                $stmt = $conn->prepare("
                    INSERT INTO camp_customer_purchase_order_items (customer_purchase_orders_id, atm_id, address, remarks) 
                    VALUES (?, ?, ?, ?)
                ");

                foreach ($atm_ids as $index => $atm_id) {
                    $addr = $addresses[$index] ?? "";
                    $remark = $remarks[$index] ?? "";
                    $stmt->bind_param("isss", $order_id, $atm_id, $addr, $remark);
                    $stmt->execute();
                }
            }
        }

        $response = ["status" => "success", "message" => "Customer Purchase Order added successfully"];
    } else {
        $response["message"] = "Failed to add Purchase Order";
    }

echo json_encode($response);
?>
