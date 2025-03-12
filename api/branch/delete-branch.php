<?php
include('../config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content-type to JSON for API response
header('Content-Type: application/json');

// Get the raw POST data (JSON)
$inputData = json_decode(file_get_contents('php://input'), true);

// Check if the branch_id is passed in the JSON body
if (isset($inputData['id'])) {
    $branch_id = $inputData['id'];

    // Validate the branch_id (basic check)
    if (is_numeric($branch_id)) {
        // Prepare UPDATE statement to set status as 'deleted'
        $sql = "UPDATE camp_branchs SET status = 'deleted' WHERE id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameter to the query
            $stmt->bind_param('i', $branch_id);  // 'i' denotes integer type

            // Execute the query and check if the update was successful
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "branch status set to deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating branch status"]);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to prepare the SQL statement"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid branch ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "branch ID not provided"]);
}
?>
