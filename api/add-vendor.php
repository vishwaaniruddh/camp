<?php
include('./config.php');


header("Content-Type: application/json");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $vendor_name = filter_input(INPUT_POST, 'vendor_name', FILTER_SANITIZE_STRING);
    $vendor_email = filter_input(INPUT_POST, 'vendor_email', FILTER_VALIDATE_EMAIL);
    $vendor_phoneno = filter_input(INPUT_POST, 'vendor_phoneno', FILTER_SANITIZE_NUMBER_INT);
    $vendor_address = filter_input(INPUT_POST, 'vendor_address', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (!$vendor_name || !$vendor_email || !$vendor_phoneno) {
        echo json_encode([
            "success" => false,
            "message" => "Vendor Name, Email, and Phone are required fields."
        ]);
        exit;
    }

    // Prepare the SQL query
    $query = "INSERT INTO camp_vendors (name, email, phone, address, created_at, updated_at) 
              VALUES (?, ?, ?, ?, ?, ?)";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("ssssss", $vendor_name, $vendor_email, $vendor_phoneno, $vendor_address,$datetime,$datetime);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Vendor added successfully.",
                "data" => [
                    "id" => $stmt->insert_id,
                    "name" => $vendor_name,
                    "email" => $vendor_email,
                    "phone" => $vendor_phoneno,
                    "address" => $vendor_address,
                    "created_at"=>$datetime,
                    "updated_at"=>$datetime
                ]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add vendor. Please try again later."
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
