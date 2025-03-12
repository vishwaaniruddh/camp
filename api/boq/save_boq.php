<?php
include('../config.php');
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Something went wrong"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get JSON input
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (!isset($inputData['boq_name']) || empty($inputData['boq_name'])) {
        $response["message"] = "BOQ Name is required";
        echo json_encode($response);
        exit;
    }

    $customer_name = trim($inputData['customer']); // Received as a string
    $bank_name = trim($inputData['bank']); // Received as a string
    $items = isset($inputData['items']) ? $inputData['items'] : [];

    // Convert names to IDs
    $customer_id = null;
    $bank_id = null;

    if (!empty($customer_name)) {
        $customer_query = mysqli_prepare($conn, "SELECT id FROM camp_customers WHERE name = ?");
        mysqli_stmt_bind_param($customer_query, "s", $customer_name);
        mysqli_stmt_execute($customer_query);
        mysqli_stmt_bind_result($customer_query, $customer_id);
        mysqli_stmt_fetch($customer_query);
        mysqli_stmt_close($customer_query);
    }

    if (!empty($bank_name)) {
        $bank_query = mysqli_prepare($conn, "SELECT id FROM camp_banks WHERE name = ?");
        mysqli_stmt_bind_param($bank_query, "s", $bank_name);
        mysqli_stmt_execute($bank_query);
        mysqli_stmt_bind_result($bank_query, $bank_id);
        mysqli_stmt_fetch($bank_query);
        mysqli_stmt_close($bank_query);
    }

    if (!$customer_id && !$bank_id) {
        $response["message"] = "Invalid Customer or Bank name";
        echo json_encode($response);
        exit;
    }

    try {
        // Start transaction
        mysqli_begin_transaction($conn);

        // Generate a unique BOQ number
        $boq_number = $inputData['boq_name'];

        // Insert into `camp_boq_master`
        $stmt = mysqli_prepare($conn, "INSERT INTO camp_boq_master (boq_number, customer_id, bank_id) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sii", $boq_number, $customer_id, $bank_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("BOQ Insert Failed: " . mysqli_error($conn));
        }
        $boq_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Insert items into `camp_boq_items`
        if (!empty($items)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO camp_boq_items (boq_id, spare_name, quantity,unit_price) VALUES (?, ?, ?, ?)");
            foreach ($items as $item) {
                $spare_name = ($item['item_name']); // Convert item_name to spare_name
                $quantity = intval($item['quantity']);
                $unit_price = intval($item['unit_cost']);

                mysqli_stmt_bind_param($stmt, "isis", $boq_id, $spare_name, $quantity,$unit_price);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Item Insert Failed: " . mysqli_error($conn));
                }
            }
            mysqli_stmt_close($stmt);
        }

        // Commit transaction
        mysqli_commit($conn);
        $response = ["status" => "success", "message" => "BOQ saved successfully", "boq_number" => $boq_number];
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $response["message"] = "Error: " . $e->getMessage();
    }
}

echo json_encode($response);
?>
