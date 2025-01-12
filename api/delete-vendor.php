<?php
include('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content-type to JSON for API response
header('Content-Type: application/json');

// Get the raw POST data (JSON)
$inputData = json_decode(file_get_contents('php://input'), true);

// Check if the vendor_id is passed in the JSON body
if (isset($inputData['id'])) {
    $vendor_id = $inputData['id'];

    // Validate the vendor_id (basic check)
    if (is_numeric($vendor_id)) {
        // Prepare UPDATE statement to set status as 'deleted'
        $sql = "UPDATE camp_vendors SET status = 'deleted' WHERE id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameter to the query
            $stmt->bind_param('i', $vendor_id);  // 'i' denotes integer type

            // Execute the query and check if the update was successful
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Vendor status set to deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating vendor status"]);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to prepare the SQL statement"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid vendor ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Vendor ID not provided"]);
}
?>
