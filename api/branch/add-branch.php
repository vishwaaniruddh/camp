<?php
include('../config.php');

header("Content-Type: application/json");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $branch_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $zone_id = filter_input(INPUT_POST, 'zone', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Validate required fields
    if (!$branch_name) {
        echo json_encode([
            "success" => false,
            "message" => "Branch name is a required field."
        ]);
        exit;
    }

    // Get current timestamp
    $datetime = date("Y-m-d H:i:s");

    // Prepare the SQL query
    $query = "INSERT INTO camp_branchs (name,zone, created_at, updated_at) 
              VALUES (?, ?, ?, ?)";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters (fix: "sss" instead of "sssssss")
        $stmt->bind_param("siss", $branch_name,$zone_id, $datetime, $datetime);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Branch added successfully.",
                "data" => [
                    "id" => $stmt->insert_id,
                    "name" => $branch_name,
                    "created_at" => $datetime,
                    "updated_at" => $datetime
                ]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add branch. Please try again later."
            ]);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database error: Unable to prepare the statement."
        ]);
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>
